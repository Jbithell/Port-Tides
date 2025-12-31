import { DateTime } from 'luxon';
import fs from 'node:fs';
import path from 'node:path';
import PDFDocument from 'pdfkit';
import SunCalc from 'suncalc';

const RAW_DATA_DIR = path.resolve('data/rawData');
const OUTPUT_FILE = path.resolve('data/tides.json');
const OUTPUT_FILE_PRETTY = path.resolve('data/tides-pretty.json');
const HTML_OUTPUT_BASE = path.resolve('data/html-tide-tables');
const PDF_OUTPUT_BASE = path.resolve('public/tide-tables');
const CSV_OUTPUT_BASE = path.resolve('public/tide-tables');

// Porthmadog definition
const LAT = 52.92;
const LON = -4.13;

interface TideEvent {
  time: string; // HH:mm:ss
  height: string;
}

interface TideDay {
  date: string; // YYYY-MM-DD
  groups: TideEvent[];
  sunrise: string;
  sunset: string;
}

interface GeneratedPdf {
  name: string;
  date: string;
  filename: string;
  htmlfilename: string;
  url: string;
}

interface OutputData {
  schedule: TideDay[];
  pdfs: GeneratedPdf[];
}

function ensureDir(dir: string) {
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
  }
}

/**
 * Parses a single line of tide data
 * Format is CSVish, but we are looking for Porthmadog (0484)
 * The file is a bit weird, usually 0484 lines are headers, then data lines follow.
 */
function parseFile(content: string): Record<string, TideEvent[]> {
  const tides: Record<string, TideEvent[]> = {};

  // Mimic PHP cleaning
  // $data = str_replace("\r", "", $data);
  // $data = str_replace("\n", ",", $data);
  let cleaned = content.replace(/\r/g, '').replace(/\n/g, ',');

  // $data = explode('"0484"', $data);
  const chunks = cleaned.split('"0484"');

  for (const chunk of chunks) {
    if (!chunk.trim()) continue;

    // The chunk starts with the rest of the header line: ,"PORTHMADOG",...
    const parts = chunk.split(',');

    // We expect parts to look like:
    // [ "", "PORTHMADOG", "52.92", "-4.13", "20250101", "0", "+0000", "X", "L", "X", "0912", "H", "4.881", "X", "L", "X", "2132", "H", "4.714", "" ]

    // Check minimal length
    if (parts.length < 17) continue;

    const dateStr = parts[4]; // YYYYMMDD
    if (!dateStr || dateStr.length !== 8) continue;

    // Parse data points
    // There are 4 potential tides at indices:
    // 1: 7,8,9
    // 2: 10,11,12
    // 3: 13,14,15
    // 4: 16,17,18

    const possibleTides = [
      { time: parts[7], event: parts[8], height: parts[9] },
      { time: parts[10], event: parts[11], height: parts[12] },
      { time: parts[13], event: parts[14], height: parts[15] },
      { time: parts[16], event: parts[17], height: parts[18] },
    ];

    const dayTides: TideEvent[] = [];

    for (const pt of possibleTides) {
      if (pt.event === 'H' && pt.time !== 'X' && pt.time) {
        // Parse time. Raw is 'HHmm' (GMT)
        // We need to convert to Local Time (Europe/London)
        // Construct standard ISO string for UTC
        const iso = `${dateStr.substring(0, 4)}-${dateStr.substring(4, 6)}-${dateStr.substring(6, 8)}T${pt.time.substring(0, 2)}:${pt.time.substring(2, 4)}:00`;

        // Parse as UTC
        const dt = DateTime.fromISO(iso, { zone: 'utc' });

        // Convert to London
        const local = dt.setZone('Europe/London');

        // If the shift caused a day change?
        // Actually, the tides are listed *for that day*.
        // If 23:50 GMT becomes 00:50 BST next day?
        // The PHP script adds 3600s to the timestamp. 
        // $tides[strtotime($date ...)] = ...
        // If $date is "01 Jan 2025" and we add time + 3600, it effectively moves it.
        // We will store the full timestamp and later group by Day.
        // Wait, the JSON output structure groups by 'date'.
        // If a tide moves to the next day in local time, does it belong to the next day's group?
        // Usually yes.
        // We will collect ALL tides in a flat list first (map by timestamp), then regroup.

        dayTides.push({
          // Store epoch to sort/dedupe
          // @ts-ignore
          epoch: local.toMillis(),
          time: local.toFormat('HH:mm:ss'),
          height: pt.height,
          dateKey: local.toFormat('yyyy-MM-dd')
        });
      }
    }

    // Add to global list
    for (const t of dayTides) {
      // @ts-ignore
      if (!tides[t.epoch]) tides[t.epoch] = [];
      // @ts-ignore
      tides[t.epoch].push(t);
    }
  }

  return tides;
}


function generateHtml(monthKey: string, days: TideDay[], firstDayDt: DateTime) {
  const monthName = firstDayDt.toFormat('MMMM');
  const year = firstDayDt.toFormat('yyyy');

  // Structure from PHP
  // Header
  let html = `<center><div style="margin-top: 8px; margin-bottom: 2px; margin-left: 5px; margin-right: 5px;">
				<style>
					h1 { margin: 1.1; }
					h2 { margin: 1.1; }
					h3 { margin: 1.1; }
					h4 { margin: 1.1; }
				</style>
				<table style="width: 99%; border: none;">
					<tr style="width: 99%;">
						<td colspan="5" style="width: 50%; border: none;">
							<h2>${monthName}&nbsp;${year}</h2>
						</td>
						<td colspan="3" style="text-align: right; width: 50%;">
							<h2>Porthmadog</h2>
						</td>
					</tr>
					<tr style="width: 99%; border: 1px solid black;">
						<td style="width: 10%; border: 1px solid black;" rowspan="2" colspan="2">
							<br/><br/><br/><br/>
							<center><h3>Date</h3></center>
						<td colspan="6" style="width: 80%; border: 1px solid black;">
							<center>
								<h3>HEIGHTS ABOVE CHART DATUM<br/>High Water</h3>
							</center>
						</td>
					</tr>
					<tr style="width: 99%; border: 1px solid black;">
						<td style="width: 14%; border: 1px solid black; min-width: 60px;" colspan="1">
							<center><b>Sunrise</b></center>
						</td>
						<td style="width: 14%; border: 1px solid black; min-width: 60px;" colspan="1">
							<center><b>Time</b></center>
						</td>
						<td style="width: 12%; border: 1px solid black; min-width: 92px;" colspan="1">
							<center><b>Height</b></center>
						</td>
						<td style="width: 14%; border: 1px solid black; min-width: 60px;" colspan="1">
							<center><b>Time</b></center>
						</td>
						<td style="width: 12%;  min-width: 92px; border: 1px solid black;" colspan="1">
							<center><b>Height</b></center>
						</td>
						<td style="width: 14%; border: 1px solid black; min-width: 60px;" colspan="1">
							<center><b>Sunset</b></center>
						</td>
					</tr>`;

  // Rows
  for (const day of days) {
    const dt = DateTime.fromISO(day.date);
    const dayName = dt.toFormat('cccc'); // l -> Monday
    const dayNum = dt.toFormat('dd');

    // Tides
    const tide1 = day.groups[0];
    const tide2 = day.groups[1]; // May be undefined

    html += `<tr style="width: 99%; border: 1px solid black;">
            <td style="border: 1px solid black; text-align: right;">&nbsp;${dayName}&nbsp;</td>
            <td style="border: 1px solid black; text-align: left;">&nbsp;${dayNum}&nbsp;</td>
            <td style="border: 1px solid black; text-align: center">${day.sunrise}</td>
            <td style="border: 1px solid black; text-align: center;">&nbsp;${tide1 ? tide1.time.substring(0, 5) : ''}&nbsp;</td>
            <td style="border: 1px solid black; text-align: center;">&nbsp;${tide1 ? tide1.height + 'm' : ''} &nbsp;</td>`;

    if (tide2) {
      html += `<td style="border: 1px solid black; text-align: center;">&nbsp;${tide2.time.substring(0, 5)}&nbsp;</td>
                      <td style="border: 1px solid black; text-align: center;">&nbsp;${tide2.height}m &nbsp;</td>`;
    } else {
      html += `<td style="border: 1px solid black; text-align: center;" colspan="2">&nbsp;&nbsp;</td>`;
    }

    html += `<td style="border: 1px solid black; text-align:center">${day.sunset}</td></tr>`;
  }

  html += `</table>`;
  html += `<span style="font-weight: bold;">Copyright Information:</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.<br/><span style="font-weight: bold;">Disclaimer:</span> Tidal Predictions are provided for use by all water users though the providers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data. <span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT/BST<br/><div align="right" style="font-style: italic;">Table provided by port-tides.com</div>`;
  html += `</div></center>`;
  return html;
}

function generateCompactPdf(monthKey: string, days: TideDay[], firstDayDt: DateTime, outputPath: string) {
  const doc = new PDFDocument({ size: 'A4', margins: { top: 40, bottom: 40, left: 20, right: 20 } });
  const monthName = firstDayDt.toFormat('MMMM');
  doc.info.Title = `Porthmadog Tide Times (Compact) - ${monthName}`;
  doc.info.Author = 'Port-Tides.com';
  const stream = fs.createWriteStream(outputPath);
  doc.pipe(stream);

  // --- Layout Constants ---
  const startX = 20;
  const startY = 60;
  const rowHeight = 15;
  const tableWidth = 550;
  const columnWidth = tableWidth / 10;

  // Header Title
  doc.font('Helvetica-Bold').fontSize(16);
  doc.text(`High Water Porthmadog (Compact View) - ${monthName}`, startX, 30, { align: 'center', width: tableWidth });

  // Table Header
  doc.fontSize(12);
  const headerY = startY;
  const subHeaderY = headerY + 15;

  // Header labels (AM, HT, PM, HT)
  doc.text('AM', startX + columnWidth, headerY, { width: columnWidth, align: 'center' });
  doc.text('HT', startX + columnWidth * 2, headerY, { width: columnWidth, align: 'center' });
  doc.text('PM', startX + columnWidth * 3, headerY, { width: columnWidth, align: 'center' });
  doc.text('HT', startX + columnWidth * 4, headerY, { width: columnWidth, align: 'center' });

  doc.text('AM', startX + columnWidth * 6, headerY, { width: columnWidth, align: 'center' });
  doc.text('HT', startX + columnWidth * 7, headerY, { width: columnWidth, align: 'center' });
  doc.text('PM', startX + columnWidth * 8, headerY, { width: columnWidth, align: 'center' });
  doc.text('HT', startX + columnWidth * 9, headerY, { width: columnWidth, align: 'center' });

  // Draw grid lines
  doc.lineWidth(1);

  const rows = 16;
  const tableHeight = rows * rowHeight;
  const topOfTable = subHeaderY;
  const bottomOfTable = topOfTable + tableHeight;

  // Outer border
  doc.rect(startX, topOfTable, tableWidth, tableHeight).stroke();

  // Horizontal lines
  for (let i = 1; i < rows; i++) {
    doc.moveTo(startX, topOfTable + i * rowHeight).lineTo(startX + tableWidth, topOfTable + i * rowHeight).stroke();
  }

  // Vertical lines
  for (let i = 1; i < 10; i++) {
    doc.lineWidth(i === 5 ? 2 : 1); // Thicker line in middle
    doc.moveTo(startX + i * columnWidth, topOfTable).lineTo(startX + i * columnWidth, bottomOfTable).stroke();
  }

  // Data
  doc.font('Helvetica').fontSize(11);
  for (let i = 0; i < 16; i++) {
    const y = topOfTable + i * rowHeight + 2;

    // Day Left (1-16)
    const dayLeft = days[i];
    if (dayLeft) {
      const dt = DateTime.fromISO(dayLeft.date);
      doc.text(dt.toFormat('d'), startX, y, { width: columnWidth, align: 'center' });

      const amTide = dayLeft.groups.find(g => parseInt(g.time.split(':')[0]) < 12);
      const pmTide = dayLeft.groups.find(g => parseInt(g.time.split(':')[0]) >= 12);

      if (amTide) {
        doc.text(amTide.time.substring(0, 5).replace(':', ''), startX + columnWidth, y, { width: columnWidth, align: 'center' });
        doc.text(parseFloat(amTide.height).toFixed(1), startX + columnWidth * 2, y, { width: columnWidth, align: 'center' });
      }
      if (pmTide) {
        doc.text(pmTide.time.substring(0, 5).replace(':', ''), startX + columnWidth * 3, y, { width: columnWidth, align: 'center' });
        doc.text(parseFloat(pmTide.height).toFixed(1), startX + columnWidth * 4, y, { width: columnWidth, align: 'center' });
      }
    }

    // Day Right (17-31)
    const dayRight = days[i + 16];
    if (dayRight) {
      const dt = DateTime.fromISO(dayRight.date);
      doc.text(dt.toFormat('d'), startX + columnWidth * 5, y, { width: columnWidth, align: 'center' });

      const amTide = dayRight.groups.find(g => parseInt(g.time.split(':')[0]) < 12);
      const pmTide = dayRight.groups.find(g => parseInt(g.time.split(':')[0]) >= 12);

      if (amTide) {
        doc.text(amTide.time.substring(0, 5).replace(':', ''), startX + columnWidth * 6, y, { width: columnWidth, align: 'center' });
        doc.text(parseFloat(amTide.height).toFixed(1), startX + columnWidth * 7, y, { width: columnWidth, align: 'center' });
      }
      if (pmTide) {
        doc.text(pmTide.time.substring(0, 5).replace(':', ''), startX + columnWidth * 8, y, { width: columnWidth, align: 'center' });
        doc.text(parseFloat(pmTide.height).toFixed(1), startX + columnWidth * 9, y, { width: columnWidth, align: 'center' });
      }
    }
  }

  // --- Footer ---
  let footerY = bottomOfTable + 20;
  doc.font("Helvetica").fontSize(12);
  doc.text('Copyright Information: All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.', startX, footerY, { width: tableWidth });
  footerY += 45;
  doc.text('Disclaimer: Tidal Predictions are provided for use by all water users though the providers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data. Time Zone Information: All Tidal Predictions above are displayed in GMT/BST', startX, footerY, { width: tableWidth });
  footerY += 45;
  doc.text('Table provided by port-tides.com', startX, footerY, { align: 'right', width: tableWidth });

  doc.end();
}

function generateCsv(days: TideDay[], outputPath: string) {
  let csv = "Day,AM Time,AM Height,PM Time,PM Height\n";

  for (const day of days) {
    const dt = DateTime.fromISO(day.date);
    const amTide = day.groups.find(g => parseInt(g.time.split(':')[0]) < 12);
    const pmTide = day.groups.find(g => parseInt(g.time.split(':')[0]) >= 12);

    let row: string[] = [
      dt.toFormat('d'),
      amTide ? amTide.time.substring(0, 5).replace(':', '') : "",
      amTide ? parseFloat(amTide.height).toFixed(1) : "",
      pmTide ? pmTide.time.substring(0, 5).replace(':', '') : "",
      pmTide ? parseFloat(pmTide.height).toFixed(1) : ""
    ];

    csv += row.join(",") + "\n";
  }

  fs.writeFileSync(outputPath, csv);
}

function generatePdf(monthKey: string, days: TideDay[], firstDayDt: DateTime, outputPath: string) {
  const doc = new PDFDocument({ size: 'A4', margins: { top: 9, bottom: 10, left: 10, right: 10 } });
  doc.info.Title = `Porthmadog Tide Times - ${monthKey}`;
  doc.info.Author = 'Port-Tides.com';
  const stream = fs.createWriteStream(outputPath);
  doc.pipe(stream);

  const monthName = firstDayDt.toFormat('MMMM');
  const year = firstDayDt.toFormat('yyyy');

  // --- Layout Constants ---
  const startX = 10;
  const rowHeight = 20;

  // Column Widths
  const colWidths = {
    dayName: 85,
    dayNum: 35,
    sunrise: 75,
    tide1Time: 75,
    tide1Height: 80,
    tide2Time: 75,
    tide2Height: 80,
    sunset: 70
  };

  // X Coordinates calculation
  let currentX = startX;
  const xPos: any = {};
  for (const [key, width] of Object.entries(colWidths)) {
    xPos[key] = currentX;
    currentX += width;
  }
  const tableWidth = currentX - startX;

  // --- Page Header ---
  doc.font('Helvetica-Bold').fontSize(20);
  doc.text(`${monthName} ${year}`, startX, 10, { align: 'left' });
  doc.text('Porthmadog', startX, 10, { align: 'right', width: tableWidth });
  doc.font('Helvetica').fontSize(18);
  doc.text('High Water - Heights above Chart Datum', startX, 32, { align: 'center', width: tableWidth });

  // --- Table Header ---
  const headerTop = 55;
  const headerHeight = 35;

  // Draw Main Box for Header
  doc.lineWidth(1);
  doc.rect(startX, headerTop, tableWidth, headerHeight).stroke();

  // Vertical Lines in Header
  doc.moveTo(xPos.sunrise, headerTop).lineTo(xPos.sunrise, headerTop + headerHeight).stroke();
  doc.moveTo(xPos.tide1Time, headerTop).lineTo(xPos.tide1Time, headerTop + headerHeight).stroke();
  doc.moveTo(xPos.tide1Height, headerTop).lineTo(xPos.tide1Height, headerTop + headerHeight).stroke();
  doc.moveTo(xPos.tide2Time, headerTop).lineTo(xPos.tide2Time, headerTop + headerHeight).stroke();
  doc.moveTo(xPos.tide2Height, headerTop).lineTo(xPos.tide2Height, headerTop + headerHeight).stroke();
  doc.moveTo(xPos.sunset, headerTop).lineTo(xPos.sunset, headerTop + headerHeight).stroke();

  // --- Header Text ---
  doc.fontSize(14).font('Helvetica-Bold');

  const textY = headerTop + 12;

  // Date
  doc.text('Date', startX, textY, { width: colWidths.dayName + colWidths.dayNum, align: 'center' });

  // Sunrise
  doc.text('Sunrise', xPos.sunrise, textY, { width: colWidths.sunrise, align: 'center' });

  // Tides
  doc.text('Time', xPos.tide1Time, textY, { width: colWidths.tide1Time, align: 'center' });
  doc.text('Height', xPos.tide1Height, textY, { width: colWidths.tide1Height, align: 'center' });
  doc.text('Time', xPos.tide2Time, textY, { width: colWidths.tide2Time, align: 'center' });
  doc.text('Height', xPos.tide2Height, textY, { width: colWidths.tide2Height, align: 'center' });

  // Sunset
  doc.text('Sunset', xPos.sunset, textY, { width: colWidths.sunset, align: 'center' });


  // --- Data Rows ---
  doc.font('Courier').fontSize(12);
  let y = headerTop + headerHeight;

  // Initial top line for data is already drawn by the header box bottom

  days.forEach((day, index) => {
    const rowBottom = y + rowHeight;

    // Horizontal Line
    doc.lineWidth(0.5);
    doc.moveTo(startX, rowBottom).lineTo(startX + tableWidth, rowBottom).stroke();

    // Vertical Lines (Full height of table so far? Better to draw cell borders or long lines at end)
    // Drawing cell borders row by row is safer for pagination if needed (though 1 month fits on 1 page)
    // Let's draw vertical lines for this row
    const diffCols = [
      xPos.dayName, xPos.dayNum, xPos.sunrise,
      xPos.tide1Time, xPos.tide1Height, xPos.tide2Time, xPos.tide2Height, xPos.sunset,
      startX + tableWidth
    ];

    // Skip the very first and last if we draw a rect? 
    // Let's just draw internal verticals + borders
    for (const vx of diffCols) {
      doc.moveTo(vx, y).lineTo(vx, rowBottom).stroke();
    }

    // Content
    const dt = DateTime.fromISO(day.date);

    // Date - Day Name (Right align with padding)
    doc.text(dt.toFormat('cccc'), xPos.dayName, y + 5, { width: colWidths.dayName - 5, align: 'right' });

    // Date - Day Num (Left align or Center? Image usually shows distinct box. Let's Center)
    doc.text(dt.toFormat('dd'), xPos.dayNum, y + 5, { width: colWidths.dayNum, align: 'center' });

    // Sunrise
    doc.text(day.sunrise, xPos.sunrise, y + 5, { width: colWidths.sunrise, align: 'center' });

    // Tides
    const t1 = day.groups[0];
    const t2 = day.groups[1];

    if (t1) {
      doc.text(t1.time.substring(0, 5), xPos.tide1Time, y + 5, { width: colWidths.tide1Time, align: 'center' });
      doc.text(t1.height + 'm', xPos.tide1Height, y + 5, { width: colWidths.tide1Height, align: 'center' });
    }

    if (t2) {
      doc.text(t2.time.substring(0, 5), xPos.tide2Time, y + 5, { width: colWidths.tide2Time, align: 'center' });
      doc.text(t2.height + 'm', xPos.tide2Height, y + 5, { width: colWidths.tide2Height, align: 'center' });
    }

    // Sunset
    doc.text(day.sunset, xPos.sunset, y + 5, { width: colWidths.sunset, align: 'center' });


    y += rowHeight;
  });

  // --- Footer ---
  y += 10;
  doc.font("Helvetica").fontSize(12);
  doc.text('Copyright Information: All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.', startX, y, { width: tableWidth });
  y += 45;
  doc.text('Disclaimer: Tidal Predictions are provided for use by all water users though the providers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data. Time Zone Information: All Tidal Predictions above are displayed in GMT/BST', startX, y, { width: tableWidth });
  y += 45;
  doc.text('Table provided by port-tides.com', startX, y, { align: 'right', width: tableWidth });

  doc.end();
}

async function main() {
  console.log('Starting Tide Parsing...');

  // 1. Read all Files
  const files = fs.readdirSync(RAW_DATA_DIR).filter(f => f.endsWith('.txt'));
  console.log(`Found ${files.length} raw data files.`);

  let allTides: Record<string, TideEvent[]> = {};

  for (const file of files) {
    console.log(`Processing ${file}...`);
    const content = fs.readFileSync(path.join(RAW_DATA_DIR, file), 'utf-8');
    const fileTides = parseFile(content);
    // Merge
    Object.assign(allTides, fileTides);
  }

  // 2. Sort Tides
  const epochs = Object.keys(allTides).map(k => parseInt(k)).sort((a, b) => a - b);

  console.log(`Total tide events found: ${epochs.length}`);

  // 3. Group by Day
  const tidesByDay: Record<string, TideEvent[]> = {};

  for (const epoch of epochs) {
    // @ts-ignore
    const tideList = allTides[epoch];
    if (!tideList || tideList.length === 0) continue;

    const tide = tideList[0]; // Take first if collision?
    // @ts-ignore
    const dateKey = tide.dateKey;

    if (!tidesByDay[dateKey]) tidesByDay[dateKey] = [];
    tidesByDay[dateKey].push(tide);
  }

  // 4. Create App Output Structure
  const schedule: TideDay[] = [];
  const tideMonths: Record<string, TideDay[]> = {}; // Key: YYYY-MM

  for (const dateKey of Object.keys(tidesByDay).sort()) {
    const dayTides = tidesByDay[dateKey];


    // Calculate Sunrise/Sunset
    // Use setZone to ensure we interpret the YYYY-MM-DD as a London date (midnight start)
    const dt = DateTime.fromISO(dateKey, { zone: 'Europe/London' });
    // SunCalc requires Date object. 
    // Note: SunCalc returns times based on Date object provided. 
    // We want times for the day at noon to avoid edge cases?
    const noon = dt.set({ hour: 12 }).toJSDate();
    const sunTimes = SunCalc.getTimes(noon, LAT, LON);

    // Format sunrise/set as HH:mm
    const sunrise = DateTime.fromJSDate(sunTimes.sunrise).setZone('Europe/London').toFormat('HH:mm');
    const sunset = DateTime.fromJSDate(sunTimes.sunset).setZone('Europe/London').toFormat('HH:mm');

    const tideDay: TideDay = {
      date: dateKey,
      groups: dayTides.map(({ time, height }) => ({ time, height })),
      sunrise,
      sunset
    };

    schedule.push(tideDay);

    const monthKey = dt.toFormat('yyyy-MM');
    if (!tideMonths[monthKey]) tideMonths[monthKey] = [];
    tideMonths[monthKey].push(tideDay);
  }

  // 5. Generate PDFs info (and HTML files)
  const pdfs: GeneratedPdf[] = [];
  ensureDir(HTML_OUTPUT_BASE);
  ensureDir(PDF_OUTPUT_BASE);
  ensureDir(CSV_OUTPUT_BASE);

  for (const monthKey of Object.keys(tideMonths).sort()) {
    const days = tideMonths[monthKey];
    const dt = DateTime.fromFormat(monthKey, 'yyyy-MM', { zone: 'Europe/London' });

    const year = dt.toFormat('yyyy');
    const month = dt.toFormat('MM'); // 01, 02...

    // Target Dir: public/tide-tables/YYYY
    const htmlTargetDir = path.join(HTML_OUTPUT_BASE, year);
    const pdfTargetDir = path.join(PDF_OUTPUT_BASE, year);
    const csvTargetDir = path.join(CSV_OUTPUT_BASE, year);
    ensureDir(htmlTargetDir);
    ensureDir(pdfTargetDir);
    ensureDir(csvTargetDir);

    const relPath = `${year}/${month}`;
    const htmlFilename = `${month}.html`;
    const fullHtmlPath = path.join(htmlTargetDir, htmlFilename);

    // Generate HTML Content
    const htmlContent = generateHtml(monthKey, days, dt); // We need the date object
    fs.writeFileSync(fullHtmlPath, htmlContent);
    console.log(`Generated HTML: ${relPath}/${htmlFilename}`);

    const pdfFilename = `${month}.pdf`;
    const fullPdfPath = path.join(pdfTargetDir, pdfFilename);
    generatePdf(monthKey, days, dt, fullPdfPath);
    console.log(`Generated PDF: ${relPath}/${pdfFilename}`);

    const compactPdfFilename = `${month}-compact.pdf`;
    const fullCompactPdfPath = path.join(pdfTargetDir, compactPdfFilename);
    generateCompactPdf(monthKey, days, dt, fullCompactPdfPath);
    console.log(`Generated Compact PDF: ${relPath}-compact.pdf`);

    const csvFilename = `${month}.csv`;
    const fullCsvPath = path.join(csvTargetDir, csvFilename);
    generateCsv(days, fullCsvPath);
    console.log(`Generated CSV: ${relPath}.csv`);

    pdfs.push({
      name: dt.toFormat('MMMM yyyy'),
      date: dt.toFormat('yyyy-MM-dd'),
      filename: `${relPath}.pdf`,
      htmlfilename: `${relPath}.html`,
      url: `${relPath}`
    });
  }

  // 6. Write JSON
  const output: OutputData = {
    schedule,
    pdfs
  };

  fs.writeFileSync(OUTPUT_FILE, JSON.stringify(output));
  fs.writeFileSync(OUTPUT_FILE_PRETTY, JSON.stringify(output, null, 2));

  console.log('Successfully generated tides.json and tides-pretty.json.');
}

main().catch(err => {
  console.error(err);
  process.exit(1);
});
