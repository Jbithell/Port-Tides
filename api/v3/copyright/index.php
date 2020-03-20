<?php
//PDF GENERATION SCRIPT STORES IT'S OWN VERSION OF THIS FILE!!!!! SEE /PREDICTIONS
require_once __DIR__ . '/../apihead.php';
if ($WELSH) {
	$RETURN = ["Copyright Information (Gwybodaeth Hawlfraint)" => "Pob Data Llanw yn © Hawlfraint y Goron. Atgynhyrchwyd gyda chaniatâd Rheolwr Llyfrfa Ei Mawrhydi a Swyddfa Hydrograffeg y Deyrnas Unedig (www.ukho.gov.uk). Gall Dim data llanw gael ei atgynhyrchu heb ganiatâd penodol yr adran drwyddedu UKHO. Oherwydd cyfyngiadau trwyddedu mae'n rhaid i ni yn awr yn dangos y neges yn Saesneg: All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty's Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department. Gwefan ©" . date('Y') . " James Bithell", "Ymwadiad" => "Rhagfynegiadau Llanw eu darparu ar gyfer defnyddio gan bob defnyddiwr dŵr er na all y datblygwyr y safle hwn yn cael ei gynnal yn atebol am gywirdeb y data hwn neu unrhyw ddamweiniau sy'n deillio o ddefnyddio'r data hwn.", "Parth Amser Gwybodaeth" => "Mae'r holl rhagfynegiadau Llanw uchod yn cael eu harddangos yn GMT / BST."];
} else {
	$RETURN = ["Copyright Information" => "All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty's Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department. Website ©" . date('Y') . " James Bithell", "Disclaimer" => "Tidal Predictions are provided for use by all water users though the developers of this site can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.", "Time Zone Information" => "All Tidal Predictions above are displayed in GMT/BST."];
}
die(json_encode($RETURN));
?>
