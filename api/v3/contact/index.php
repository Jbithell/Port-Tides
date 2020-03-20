<?php
$_GET['format'] = "text"; //This thing only does text - no json
require_once __DIR__ . '/../apihead.php';
if ($WELSH) {
	$RETURN = "I gysylltu â'n tîm cymorth e-bostiwch: tides@port-tides.com, yn cynnwys y wybodaeth ganlynol '" . $_SERVER['HTTP_USER_AGENT'] . "'";
} else {
	$RETURN = "To contact our support team please E-Mail: tides@port-tides.com, including the following information '" . $_SERVER['HTTP_USER_AGENT'] . "'";
}
die($RETURN);
?>
