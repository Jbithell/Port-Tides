<?php
require_once (dirname(__FILE__)."/../login.php");
date_default_timezone_set('Europe/London');
header("Access-Control-Allow-Origin: *");

$printversion = false;
$pdfformat = false;
$email = false;
$download = false;
require_once "moon.php";
//End Moon
function numbertonameformonth($number) {
$dateObj = DateTime::createFromFormat('!m', $number);
return $dateObj->format('F');
}
//Begin getting settings
function getsettingsfromforminput() {
global $month;
global $year;
global $pdfformat;
global $printversion;
global $email;
global $emailgot;
global $download;
$month = substr($_GET['tidetableselectorforminput'], 0, 2);
$year = substr($_GET['tidetableselectorforminput'], 2);
$pdfformat = true;
if (isset($_GET['print'])) $printversion = true;
elseif (isset($_GET['email'])) $email = true;
elseif (isset($_GET['download'])) $download = true;
elseif (isset($_GET['emailgot'])) $emailgot = true;
}
if (isset($_GET['tidetableselectorforminput'])) getsettingsfromforminput();
elseif (!isset($_GET['month']) or !isset($_GET['year'])) die('Could not get settings!');
else {
$month = $_GET['month'];
$year = $_GET['year'];
if ($_GET['format'] == 'pdf') $pdfformat = true;
}

//End getting settings

$output = '<link href="bootstrap.min.css" rel="stylesheet"><center><div style="margin-top: 8px; margin-bottom: 2px; margin-left: 5px; margin-right: 5px;">';

$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
    die("SQL Connection Error");
} 
$sql = "SELECT * FROM ukhoporthmadogdata WHERE date BETWEEN '" . date('Y-m-d', strtotime($year . '-' . $month . '-01')) . "' AND '" . date('Y-m-t', strtotime($year . '-' . $month . '-01'))  . "'";
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
    $output .= '<tr style="width: 99%;"><td colspan="4" style="width: 50%; border: none;"><h2>' . numbertonameformonth($month) . '&nbsp;' . $year . '</h2></td><td  colspan="2" style="text-align: right; width: 50%;"><h2>Porthmadog</h2></td></tr>';
    $output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 10%; border: 1px solid black;" rowspan="3" colspan="2"><br/><br/><br/><br/><br/><center><h3>Date</h3></center><td colspan="4" style="width: 80%;"><center><h3>HEIGHTS ABOVE CHART DATUM<br/><br/>High Water</h3></center></td></tr>';
    $output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 20%; border: 1px solid black;" colspan="2"><center><b>First Tide</b></center></td><td style="width: 20%;" colspan="2"><center><b>Second Tide</b></center></td></tr>';
    $output .= '<tr style="width: 99%; border: 1px solid black;"><td style="width: 20%; border: 1px solid black; min-width: 60px;" colspan="1"><center><b>Time</b></center></td><td style="width: 20%; border: 1px solid black; min-width: 92px;" colspan="1"><center><b>Height (m)</b></center></td><td style="width: 20%; border: 1px solid black; min-width: 60px;" colspan="1"><center><b>Time</b></center></td><td style="width: 20%;  min-width: 92px; border: 1px solid black;" colspan="1"><center><b>Height (m)</b></center></td></tr>';
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
    $output .= 'Sorry - We do not have the data available for this month.';    
    }
$conn->close();



$output .= '</div></center>';


//Output Finished - Formatting Time!

if ($_GET['format'] == 'html') echo $output . '<span style="font-weight: bold;">Copyright Information:</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.<br/><span style="font-weight: bold;">Disclaimer:</span> Tidal Predictions are provided for use by all water users though the providers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.<br/><span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT and are not adjusted for BST<br/><div align="right" style="font-style: italic;">Table provided by <a href="http://www.port-tides.com">Port-tides.com</a></div>';
elseif ($printversion) die($output . '<br/><br/><span style="font-weight: bold;">Copyright Information:</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.<br/><span style="font-weight: bold;">Disclaimer:</span> Tidal Predictions are provided for use by all water users though the providers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.<br/><span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT and are not adjusted for BST<br/><div align="right" style="font-style: italic;">Table provided by <a href="http://www.port-tides.com">Port-tides.com</a></div>' . '<script>window.print();</script>');
elseif ($pdfformat) {
require_once (dirname(__FILE__).'/PDF-Generation/mpdf/mpdf.php');
$mpdf=new mPDF('', 'A4');
$mpdf->AddPage('','','','','',10,10,10,10,'','');
$mpdf->SetHTMLFooter('<span style="font-weight: bold;">Copyright Information:</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.<br/><span style="font-weight: bold;">Disclaimer:</span> Tidal Predictions are provided for use by all water users though the providers of this table can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.<br/><span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT and are not adjusted for BST<br/><div align="right" style="font-style: italic;">Table provided by <a href="http://www.port-tides.com">Port-tides.com</a></div>');
$mpdf->SetTitle('Porthmadog Tide Times - ' . numbertonameformonth($month) . ' ' . $year);
$mpdf->SetAuthor ('The Porthmadog Tide Times Team (port-tides.com). All tidal data is crown copyright and supplied by the UKHO');
$mpdf->SetProtection(array('print'), '');
$mpdf->WriteHTML($output);
if ($download) $mpdf->Output('Porthmadog Tide Times - ' . numbertonameformonth($month) . ' ' . $year . '.pdf','D');
elseif ($email) die('<html><head><title>E-Mail a Tide Table</title></head><body><!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" onClick="window.close();" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">E-Mail a Tide Table</h4>
                                        </div>
                                        <form action="tidetables.php" method="get"><div class="modal-body">
                                            <i>Please enter an E-Mail address to send the tide table to:</i></br>
                                            <input type="text" class="form-control" placeholder="E-Mail address" name="emailgot" />
                                            <input type="hidden" value="' . $_GET['tidetableselectorforminput'] . '" name="tidetableselectorforminput" />
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" onClick="window.close();" class="btn btn-default">Close</button>
                                            <button type="submit" type="button" class="btn btn-primary">Send</button>
                                        </div></form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div> <!-- jQuery Version 1.11.0 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script><script type="text/javascript">'
                            . "
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>" . '</body></html>');
elseif ($emailgot) {
$content = $mpdf->Output('', 'S');

$content = chunk_split(base64_encode($content));
$mailto = $_GET['emailgot'];
$from_name = 'Porthmadog Tide Times';
$from_mail = 'tides@port-tides.com';
$replyto = $from_mail;
$uid = md5(uniqid(time())); 
$subject = 'Porthmadog Tide Times PDF for ' . numbertonameformonth($month) . ' ' . $year;
$message = 'Please find attached your Porthmadog Tide Times PDF for ' . numbertonameformonth($month) . ' ' . $year;
$filename = 'Porthmadog Tide Times - ' . numbertonameformonth($month) . ' ' . $year . '.pdf';

$header = "From: ".$from_name." <".$from_mail.">\r\n";
$header .= "Reply-To: ".$replyto."\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
$header .= "This is a multi-part message in MIME format.\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$header .= $message."\r\n\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
$header .= "Content-Transfer-Encoding: base64\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$header .= $content."\r\n\r\n";
$header .= "--".$uid."--";
$is_sent = @mail($mailto, $subject, "", $header);

//$mpdf->Output();
header_remove();

header("Content-Type:text/html");
echo('<html><head><title>E-Mail a Tide Table</title></head><body><!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" onClick="window.close();" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">E-Mail Sent!</h4>
                                        </div>
                                        <p>Your tide table has been sent to ' . $_GET['emailgot'] . '</p><br/><b>Spam filters are hungry!</b> please check your spam folder for our E-Mail (Sent from ' . $from_mail . ')
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" onClick="window.close();" class="btn btn-default">Close</button>
                                            
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div> <!-- jQuery Version 1.11.0 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script><script type="text/javascript">'
                            . "
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>" . '</body></html>');
exit;
}
else $mpdf->Output('Porthmadog Tide Times - ' . numbertonameformonth($month) . ' ' . $year . '.pdf','I');
exit;
}
else echo $output;
?>
