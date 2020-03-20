<?php
require_once __DIR__ . "/../../config.php";
if (!isset($_GET['format']) or $_GET['format'] == "json") {
	header('Access-Control-Allow-Origin: *');  
	header('Content-Type: application/json');
	$PDF = false;
} else {
	$PDF = true;
}

if (isset($_GET['lang']) and $_GET['lang'] == "cy") {
	$WELSH = true;
	setlocale(LC_TIME, 'cy_GB');
} else $WELSH = false;

?>
