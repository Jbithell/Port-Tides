<?php
require_once __DIR__ . '/../apihead.php';
if (isset($_GET['month']) and isset($_GET['year']) and is_numeric($_GET['month']) and is_numeric($_GET['year'])) { //If the user wants a month - we make sure it's an int as basic SQL injection prevention
	$TIME['START'] = date('Y-m-d', strtotime($_GET['year'] . '-' . $_GET['month'] . '-01'));
	$TIME['END'] = date('Y-m-t', strtotime($_GET['year'] . '-' . $_GET['month'] . '-01'));
} elseif (isset($_GET['period']) and is_numeric($_GET['period'])) { //Period is a number of days to retrieve 
	$TIME['START'] = date('Y-m-d');
	$TIME['END'] = date('Y-m-d', strtotime("+" . $_GET['period'] . " days"));
	$_GET['month'] = date('m');
	$_GET['year'] = date('Y');
} else { //Default to Next 7 Days
	$TIME['START'] = date('Y-m-d');
	$TIME['END'] = date('Y-m-d', strtotime("+7 days"));
	$_GET['month'] = date('m');
	$_GET['year'] = date('Y');
}
$GLOBALS['DBLIB']->where("date BETWEEN '" . $TIME['START'] . "' AND '" . $TIME['END'] . "'");
$GLOBALS['DBLIB']->where("date <= '" . date('Y-m-d', strtotime("+" . $MAXDISPLAY  . " days")) . "'"); //For license compliance
$SQLDATA = $GLOBALS['DBLIB']->get($SQLTIDESTABLE);
$OUTPUT = [];
foreach ($SQLDATA as $day) {
	$dayoutput = ["DATE" => strtotime($day['date'])*1000, "DAYNAME" => strftime("%A", strtotime($day['date'])),  "DAYNUMBER" =>  date("d", strtotime($day['date'])),  "DAYORDINAL" => date("S", strtotime($day['date'])), "MONTHNAME" => strftime("%B", strtotime($day['date'])), "MONTHNUMBER" => date("m", strtotime($day['date'])), "YEAR" => date("Y", strtotime($day['date']))];

	$dayoutput['TIDES'] = [];
	if ($day["tide1time"] != 'ONE--') {
		$dayoutput['TIDES'][] = ["TIME" => $day["tide1time"], "HEIGHT" => $day["tide1height"]];
	}
	$dayoutput['TIDES'][] = ["TIME" => $day["tide2time"], "HEIGHT" => $day["tide2height"]];

	$OUTPUT[] = $dayoutput;
}
if (!$PDF) die(json_encode($OUTPUT));
else {
	$output = '<center><div style="margin-top: 8px; margin-bottom: 2px; margin-left: 5px; margin-right: 5px;">';
	$output .= '<style>
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
				</style>';
	$output .= '<table style="width: 99%; border: none;">';
	$output .= '<tr style="width: 99%;"><td colspan="4" style="width: 50%; border: none;"><h2>' . strftime("%B", strtotime("" . $_GET['month'] . "/1/" . $_GET['year'])). '&nbsp;' . $_GET['year'] . '</h2></td><td  colspan="2" style="text-align: right; width: 50%;"><h2>Porthmadog</h2></td></tr>';
	$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 10%; border: 1px solid black;" rowspan="3" colspan="2"><br/><br/><br/><br/><br/><center><h3>Date</h3></center><td colspan="4" style="width: 80%; border: 1px solid black;"><center><h3>HEIGHTS ABOVE CHART DATUM<br/><br/>High Water</h3></center></td></tr>';
	$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 20%; border: 1px solid black;" colspan="2"><center><b>First Tide</b></center></td><td style="width: 20%; border: 1px solid black;" colspan="2"><center><b>Second Tide</b></center></td></tr>';
	$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 20%; border: 1px solid black; min-width: 60px;" colspan="1"><center><b>Time</b></center></td><td style="width: 20%; border: 1px solid black; min-width: 92px;" colspan="1"><center><b>Height (m)</b></center></td><td style="width: 20%; border: 1px solid black; min-width: 60px;" colspan="1"><center><b>Time</b></center></td><td style="width: 20%;  min-width: 92px; border: 1px solid black;" colspan="1"><center><b>Height (m)</b></center></td></tr>';
	foreach ($OUTPUT as $day) {
		$output .= '<tr style="width: 99%; border: 1px solid black;">';
			$output .= '<td style="border: 1px solid black; text-align: right;">&nbsp;' . date('l', $day['DATE']/1000) . '&nbsp;</td>';
			$output .= '<td style="border: 1px solid black; text-align: left;">&nbsp;' . date('d', $day['DATE']/1000) . '&nbsp;</td>';
			$output .= '<td style="border: 1px solid black; text-align: center;">&nbsp;' . $day['TIDES'][0]['TIME'] . '&nbsp;</td>';
			$output .= '<td style="border: 1px solid black; text-align: center;">&nbsp;' . $day['TIDES'][0]['HEIGHT'] . 'm &nbsp;</td>';
			if (isset($day['TIDES'][1]['TIME'])) {
				$output .= '<td style="border: 1px solid black; text-align: center;">&nbsp;' . $day['TIDES'][1]['TIME'] . '&nbsp;</td>';
				$output .= '<td style="border: 1px solid black; text-align: center;">&nbsp;' . $day['TIDES'][1]['HEIGHT'] . 'm &nbsp;</td>';
			} else {
				$output .= '<td style="border: 1px solid black; text-align: center;">&nbsp;&nbsp;</td>';
				$output .= '<td style="border: 1px solid black; text-align: center;">&nbsp;&nbsp;</td>';
			}
		$output .= '</tr>';
	}
	$output .= '</table>';

	$mpdf=new mPDF('', 'A4');
	$mpdf->AddPage('','','','','',10,10,10,10,'','');
	$mpdf->SetHTMLFooter('<span style="font-weight: bold;">Copyright Information:</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.<br/><span style="font-weight: bold;">Disclaimer:</span> Tidal Predictions are provided for use by all water users though the providers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data. <span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT/BST<br/><div align="right" style="font-style: italic;">Table provided by <a href="http://www.port-tides.com">Port-tides.com</a></div>');
	$mpdf->SetTitle('Porthmadog Tide Times | ' . $_GET['month'] . '/' . $_GET['year']);
	$mpdf->SetAuthor ('port-tides.com');
	$mpdf->SetProtection(array('print'), '');
	$mpdf->WriteHTML($output, 0);
	$mpdf->Output('tidetable.pdf','I');
	echo $output;
}
?>
