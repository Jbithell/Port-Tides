<?php
require_once (dirname(__FILE__)."/../login.php");
date_default_timezone_set('Europe/London');
header('Access-Control-Allow-Origin: *');  
$pdfformat = true;

require_once "moon.php";
//End Moon

function numbertonameformonth($number) {
$dateObj = DateTime::createFromFormat('!m', $number);
return $dateObj->format('F');
}

//Begin getting settings
$month = $_GET['month'];
$year = $_GET['year'];
$lang = 'en'; //en = English & cy = Welsh
if (isset($_GET['lang'])) if ($_GET['lang'] == 'cy') $lang = 'cy';
//End getting settings

$output = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Porthmadog - ' . numbertonameformonth($month) . '&nbsp;' . $year  . '</h4>
          </div>
          <div class="modal-body">
         <link href="bootstrap.min.css" rel="stylesheet"><center><div style="margin-top: 8px; margin-bottom: 2px; margin-left: 5px; margin-right: 5px;">';

$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
    die("SQL Connection Error");
} 
$sql = "SELECT * FROM porttides_ukho_adjusted WHERE date BETWEEN '" . date('Y-m-d', strtotime($year . '-' . $month . '-01')) . "' AND '" . date('Y-m-t', strtotime($year . '-' . $month . '-01'))  . "'";
$result = $conn->query($sql);
$counter = 0;
$daylightsavingmessage = false;
if ($result->num_rows > 0) {
    //Begin Table Title
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
    //$output .= '<tr style="width: 99%;"><td colspan="4" style="width: 50%; border: none;"><h2>' . numbertonameformonth($month) . '&nbsp;' . $year . '</h2></td><td  colspan="2" style="text-align: right; width: 50%;"><h2>Porthmadog</h2></td></tr>';
    if ($lang == 'en') {
		$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 10%; border: 1px solid black;" rowspan="3" colspan="2"><br/><br/><br/><br/><br/><center><h3>Date</h3></center><td colspan="4" style="width: 80%;"><center><h3>HEIGHTS ABOVE CHART DATUM<br/><br/>High Water</h3></center></td></tr>';
		$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 20%; border: 1px solid black;" colspan="2"><center><b>First Tide</b></center></td><td style="width: 20%;" colspan="2"><center><b>Second Tide</b></center></td></tr>';
		$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 20%; border: 1px solid black; min-width: 60px;" colspan="1"><center><b>Time</b></center></td><td style="width: 20%; border: 1px solid black; min-width: 92px;" colspan="1"><center><b>Height (m)</b></center></td><td style="width: 20%; border: 1px solid black; min-width: 60px;" colspan="1"><center><b>Time</b></center></td><td style="width: 20%;  min-width: 92px; border: 1px solid black;" colspan="1"><center><b>Height (m)</b></center></td></tr>';
	} else {
		$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 10%; border: 1px solid black;" rowspan="3" colspan="2"><br/><br/><br/><br/><br/><center><h3>Dyddiad</h3></center><td colspan="4" style="width: 80%;"><center><h3>UCHDER UWCHLAW DATWM SIART<br/><br/>D&#373;r uchel</h3></center></td></tr>';
		$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 20%; border: 1px solid black;" colspan="2"><center><b>cyntaf Tide</b></center></td><td style="width: 20%;" colspan="2"><center><b>ail Llanw</b></center></td></tr>';
		$output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 20%; border: 1px solid black; min-width: 60px;" colspan="1"><center><b>Amser</b></center></td><td style="width: 20%; border: 1px solid black; min-width: 92px;" colspan="1"><center><b>Uchder (m)</b></center></td><td style="width: 20%; border: 1px solid black; min-width: 60px;" colspan="1"><center><b>Uchder</b></center></td><td style="width: 20%;  min-width: 92px; border: 1px solid black;" colspan="1"><center><b>Uchder (m)</b></center></td></tr>';
	}
	while($row = $result->fetch_assoc()) {
    
        if (date("I", strtotime($row["date"])) == 1) $daylightsavingmessage = true;
        $output .= '<tr style="width: 99%; border: 1px solid black;">';
        $output .= '<td style="width: 3%; min-width: 25px; border: 1px solid black;">&nbsp;';
        $output .= date("d", strtotime($row["date"])); 
        $output .= '&nbsp;</td><td style="width: 7%; min-width: 65px; border: 1px solid black;">&nbsp;';
        $output .= strtoupper(date("D", strtotime($row["date"]))); 
        
        //Moon Data
        /*
        $output .= '&nbsp;&nbsp;';
        $moontimestamp = strtotime($row["date"]);
        $output .= moon_phase(date('Y', $moontimestamp), date('n', $moontimestamp), date('j', $moontimestamp));
        */
        //End Moon Data
        
        $output .= '</td><td style="width: 10%;  min-width: 65px; border: 1px solid black;"><center>';
        if ($row["tide1time"] != 'ONE--') $output .= $row["tide1time"];
        else $output .= $row["tide2time"];
        $output .= '</center></td><td style="width: 10%; border: 1px solid black;"><center>';
        if ($row["tide1time"] != 'ONE--') $output .= $row["tide1height"];
        else $output .= $row["tide2height"];
        $output .= '</center></td><td style="width: 10%; border: 1px solid black;"><center>';
        if ($row["tide1time"] != 'ONE--') $output .= $row["tide2time"];
        $output .= '</center></td><td style="width: 10%; border: 1px solid black;"><center>';
        if ($row["tide1time"] != 'ONE--') $output .= $row["tide2height"];
        $output .= '</center></td>';
        $output .= '</tr>';
        $counter ++;
    }
    $output .= '</table>';
    
    }
    else {
    $output .= ($lang == 'en' ? 'Sorry - We do not have the data available for this month.' : 'Mae\'n ddrwg gennym - nid oes gennym ddata ar gael ar gyfer y mis hwn.');    
    }
$conn->close();



$output .= '</div></center> </div>
          <div class="modal-footer">
			    <div style="text-align: left">';
				if ($lang == 'en') {
					$output .=  '<span style="font-weight: bold;">Copyright Information:</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department. Website &copy;' . date('Y') . ' James Bithell<br/>';
					$output .= '<span style="font-weight: bold;">Disclaimer:</span> Tidal Predictions are provided for use by all water users though the developers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.<br/>';
					$output .=  '<span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT/BST.';
				} else {
					$output .=  '<span style="font-weight: bold;">Gwybodaeth Hawlfraint:</span> Data Pob Tidal yw &copy;Hawlfraint y Goron. Atgynhyrchwyd gyda chaniatâd Rheolwr Llyfrfa Ei Mawrhydi a\'r Swyddfa Hydrograffig y Deyrnas Unedig (www.ukho.gov.uk). Ni chaiff unrhyw ddata y llanw gael ei atgynhyrchu heb ganiatâd penodol yr adran drwyddedu UKHO. Gwefan &copy;' . date('Y') . ' James Bithell<br/>';
					$output .=  '<span style="font-weight: bold;">Ymwadiad:</span> Rhagfynegiadau Llanw eu darparu ar gyfer eu defnyddio gan bob defnyddiwr dŵr er na all y datblygwyr y safle hwn yn cael ei gynnal yn atebol am gywirdeb y data hwn neu unrhyw ddamweiniau sy\'n deillio o ddefnyddio\'r data hwn.<br/>';
					$output .=  '<span style="font-weight: bold;">Parth Amser Gwybodaeth: </span>Pob Rhagfynegiadau Llanw uchod yn cael eu harddangos yn GMT/BST.';
				}
				$output .=  '</div>
			<hr/>
		    <a href="https://docs.google.com/forms/d/1fWguWKA-uIfHnm70DBvghWcD9XxO-PRqKzM4UD7qGIU/viewform"><button type="button" class="btn btn-default">' . ($lang == 'en' ? 'Report a Problem' : 'Adrodd am Broblem') . '</button></a>
            <a href="http://port-tides.com/tidetables/viewpdf.php?month=' . $_GET["month"] . '&year=' . $_GET["year"] . '&lang=' . $lang .'"><button type="button" class="btn btn-default">' . ($lang == 'en' ? 'View Larger' : 'Gweld mwy o faint') . '</button></a>
			<button type="button" class="btn btn-default" data-dismiss="modal">' . ($lang == 'en' ? 'Close' : 'Cau') . '</button>
          </div>';


//Output Finished - Formatting Time!

echo $output;
?>
