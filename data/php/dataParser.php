<?php
require_once __DIR__ . '/vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', 'On');
/*
	This program is designed to convert UKHO Format 12 data to a sql table - It only works for Porthmadog!
*/
$CONFIG = [
	"folder" => '../rawData'
];
/*

*First line
"Port Number","Port Name",Latitude [in decimal degrees (d)d.dd positive north negative south],Longitude [in decimal degrees (dd)d.dd positive east negative west],Date [yyyymmdd],Time Interval Height Output [This sample file doesn't have fixed Time Intervals, it shows the times and heights of high and low water when they occur. But fixed Time Intervals can be created in the range between 1 minute to 120 minutes],Time Zone [+/-hhmm]

*Second line
Time [24 hour format hhmm],Event [High or Low Water H/L],Height [metres above Chart Datum m.mmm],Time [24 hour format hhmm],Event [High or Low Water H/L],Height [metres above Chart Datum m.mmm],Time [24 hour format hhmm],Event [High or Low Water H/L],Height [metres above Chart Datum m.mmm],Time [24 hour format hhmm],Event [High or Low Water H/L],Height [metres above Chart Datum m.mmm]

*/

//Begin Program
date_default_timezone_set('Europe/London');
$files = glob($CONFIG['folder'] . '/*.{txt}', GLOB_BRACE);
$output = [];
$tides = [];
foreach ($files as $file) {
	$data = file_get_contents($file);
	$data = str_replace("\r", "", $data);
	$data = str_replace("\n", ",", $data);
	$data = explode('"0484"', $data);
	foreach ($data as $line) {
		if ($line == '') continue;
		$array =  explode(",", $line);
		if (count($array) != 20 and count($array) != 17) continue;

		$date = date("d M Y", strtotime($array[4])); //Date for next iteration



		if (date("I",strtotime($date)) == 1) $daylightAdjust = 3600; //Add an hour for BST
		else $daylightAdjust = 0;

		//For some reason, known only to the UKHO - some of them do high/low tide in the wrong order....
		if ($array[10] == "X") $tides[strtotime($date . " " . substr_replace($array[7], ":", 2, 0 ) . ":00")+$daylightAdjust] = $array[9];
		else $tides[strtotime($date . " " . substr_replace($array[10], ":", 2, 0 ) . ":00")+$daylightAdjust] = $array[12];

		if (($array[13] != "X" and count($array) == 17) or count($array) == 20) {
			if ($array[13] != "X") $tides[strtotime($date . " " . substr_replace($array[13], ":", 2, 0 ) . ":00")+$daylightAdjust] = $array[15]; //Two tides on that day
			else $tides[strtotime($date . " " . substr_replace($array[16], ":", 2, 0 ) . ":00")+$daylightAdjust] = $array[18]; //Two tides on that day
		}
	}
}
ksort ($tides); //Put the tides in ascending order
$tidesDays = [];
foreach ($tides as $time=>$height) {
	if (!isset($tidesDays[date("d M Y", $time)])) $tidesDays[date("d M Y", $time)] = [];

	$tidesDays[date("d M Y", $time)][] = ["time" => date("H:i:s", $time), "height" => $height];
}
//Generate timings in the format that the app likes
$tidesApp = [];
foreach ($tidesDays as $time=>$day) {
	$tidesApp[] = ["date" => date("Y-m-d", strtotime($time)), "groups" => $day];
}

//Generate tide tables as PDFs that look nice
$tidesMonths = [];
foreach ($tidesDays as $time=>$day) {
	if (!isset($tidesMonths[date("M Y", strtotime($time))])) $tidesMonths[date("M Y", strtotime($time))] = [];
	$tidesMonths[date("M Y", strtotime($time))][$time] = $day;
}
$pdfs = [];
foreach ($tidesMonths as $month=>$data) {
	//Generate a PDF
	$pdf = ["name" => date("F Y",strtotime($month)), "date" => date("Y-m-d", strtotime($month)), "filename" => strtolower(date("m-Y",strtotime($month))) . '.pdf', "htmlfilename" => strtolower(date("m-Y",strtotime($month))) . '.html'];
	$pdf['url'] = $pdf['filename'];

	$output = '<center><div style="margin-top: 8px; margin-bottom: 2px; margin-left: 5px; margin-right: 5px;">
				<style>
					h1 {
						margin: 1.1;
					}
					h2 {
						margin: 1.1;
					}
					h3 {
						margin: 1.1;
					}
					h4 {
						margin: 1.1;
					}
				</style>
				<table style="width: 99%; border: none;">
					<tr style="width: 99%;">
						<td colspan="5" style="width: 50%; border: none;">
							<h2>' .  date("F",strtotime($month)) . '&nbsp;' . date("Y",strtotime($month)) . '</h2>
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
							<center>
								<b>Sunrise</b>
							</center>
						</td>
						<td style="width: 14%; border: 1px solid black; min-width: 60px;" colspan="1">
							<center>
								<b>Time</b>
							</center>
						</td>
						<td style="width: 12%; border: 1px solid black; min-width: 92px;" colspan="1">
							<center>
								<b>Height</b>
							</center>
						</td>
						<td style="width: 14%; border: 1px solid black; min-width: 60px;" colspan="1">
							<center>
								<b>Time</b>
							</center>
						</td>
						<td style="width: 12%;  min-width: 92px; border: 1px solid black;" colspan="1">
							<center>
								<b>Height</b>
							</center>
						</td>
						<td style="width: 14%; border: 1px solid black; min-width: 60px;" colspan="1">
							<center>
								<b>Sunset</b>
							</center>
						</td>
					</tr>';
				foreach ($data as $dayDate=>$day) {
					$output .= '<tr style="width: 99%; border: 1px solid black;">
								<td style="border: 1px solid black; text-align: right;">&nbsp;' . date('l', strtotime($dayDate)) . '&nbsp;</td>
								<td style="border: 1px solid black; text-align: left;">&nbsp;' . date('d', strtotime($dayDate)) . '&nbsp;</td>
								<td style="border: 1px solid black; text-align: center">' . date_sunrise(strtotime($dayDate), SUNFUNCS_RET_STRING,52.92,-4.13,ini_get("date.sunrise_zenith"),date("I",strtotime($dayDate))) . '</td>
								<td style="border: 1px solid black; text-align: center;">&nbsp;' . date('H:i', strtotime($day[0]['time'])) . '&nbsp;</td>
								<td style="border: 1px solid black; text-align: center;">&nbsp;' . $day[0]['height'] . 'm &nbsp;</td>';
					if (count($day)>1) {
						$output .= '<td style="border: 1px solid black; text-align: center;">&nbsp;' . date('H:i', strtotime($day[1]['time'])) . '&nbsp;</td>
									<td style="border: 1px solid black; text-align: center;">&nbsp;' . $day[1]['height'] . 'm &nbsp;</td>';
					} else {
						$output .= '<td style="border: 1px solid black; text-align: center;" colspan="2">&nbsp;&nbsp;</td>';
					}
					$output .= '<td style="border: 1px solid black; text-align:center">' . date_sunset (strtotime($dayDate), SUNFUNCS_RET_STRING,52.92,-4.13,ini_get("date.sunrise_zenith"),date("I",strtotime($dayDate))) . '</td></tr>';
				}
	$output .= '</table>';
	$footer = '<span style="font-weight: bold;">Copyright Information:</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.<br/><span style="font-weight: bold;">Disclaimer:</span> Tidal Predictions are provided for use by all water users though the providers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data. <span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT/BST<br/><div align="right" style="font-style: italic;">Table provided by port-tides.com</div>';
	$mpdf=new \Mpdf\Mpdf(['format' => 'A4',
		'margin_left' => 10,
		'margin_right' => 10,
		'margin_top' => 9,
		'margin_bottom' => 10,
		'margin_header' => 0,
		'margin_footer' => 9
	]);
	$mpdf->SetHTMLFooter($footer);
	$mpdf->SetTitle('Porthmadog Tide Times | ' .  date("F",strtotime($month)) . '/' .date("Y",strtotime($month)));
	$mpdf->SetAuthor ('port-tides.com');
	$mpdf->SetProtection(array('print'), '');
	$mpdf->WriteHTML($output);
	$mpdf->Output(__DIR__ . '/../../static/tide-tables/' . $pdf['filename'],'F');
	file_put_contents(__DIR__ . '/../../static/tide-tables/' . $pdf['htmlfilename'],($output.$footer));
	$pdfs[] = $pdf;
}


$output = [
	"schedule" => $tidesApp,
	"tides" => [
		"rawAdjusted" => $tides,
		"daysAdjusted" => $tidesDays,
		"monthsAdjusted" => $tidesMonths
	],
	"pdfs" => $pdfs
];
$fp = fopen('tides.json', 'w');
fwrite($fp, json_encode($output));
fclose($fp);

echo "Finished";
?>

