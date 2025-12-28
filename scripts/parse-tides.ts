import { DateTime } from 'luxon';
import fs from 'node:fs';
import path from 'node:path';
import SunCalc from 'suncalc';

const RAW_DATA_DIR = path.resolve('data/rawData');
const OUTPUT_FILE = path.resolve('data/tides.json');
const OUTPUT_FILE_PRETTY = path.resolve('data/tides-pretty.json');
const HTML_OUTPUT_BASE = path.resolve('data/html-tide-tables');
const PDF_OUTPUT_BASE = path.resolve('public/tide-tables');

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
        const iso = `${dateStr.substring(0,4)}-${dateStr.substring(4,6)}-${dateStr.substring(6,8)}T${pt.time.substring(0,2)}:${pt.time.substring(2,4)}:00`;
        
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
            <td style="border: 1px solid black; text-align: center;">&nbsp;${tide1 ? tide1.time.substring(0,5) : ''}&nbsp;</td>
            <td style="border: 1px solid black; text-align: center;">&nbsp;${tide1 ? tide1.height + 'm' : ''} &nbsp;</td>`;
        
        if (tide2) {
             html += `<td style="border: 1px solid black; text-align: center;">&nbsp;${tide2.time.substring(0,5)}&nbsp;</td>
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
     const dt = DateTime.fromISO(dateKey).setZone('Europe/London');
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

  for (const monthKey of Object.keys(tideMonths).sort()) {
      const days = tideMonths[monthKey];
      const dt = DateTime.fromFormat(monthKey, 'yyyy-MM');
      
      const year = dt.toFormat('yyyy');
      const month = dt.toFormat('MM'); // 01, 02...
      
      // Target Dir: public/tide-tables/YYYY
      const targetDir = path.join(HTML_OUTPUT_BASE, year);
      ensureDir(targetDir);
      
      const relPath = `${year}/${month}`;
      const htmlFilename = `${month}.html`;
      const fullHtmlPath = path.join(targetDir, htmlFilename);
      
      // Generate HTML Content
      const htmlContent = generateHtml(monthKey, days, dt); // We need the date object
      fs.writeFileSync(fullHtmlPath, htmlContent);
      console.log(`Generated HTML: ${relPath}/${htmlFilename}`);

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
