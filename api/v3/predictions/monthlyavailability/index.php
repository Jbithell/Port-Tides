<?php
require_once __DIR__ . '/../../apihead.php';
$GLOBALS['DBLIB']->where("date <= '" . date('Y-m-d', strtotime("+" . $MAXDISPLAY  . " days")) . "'"); //For license compliance
$SQLDATA = $GLOBALS['DBLIB']->get($SQLTIDESTABLE, null, "DISTINCT month(date), year(date)");
$OUTPUT = [];
foreach ($SQLDATA as $month) {
	$OUTPUT[] = ["MONTH" => $month["month(date)"], "YEAR" => $month["year(date)"], "MONTHNAME" => strftime("%B", strtotime("" . $month["month(date)"] . "/1/" . $month["year(date)"]))];
}
die(json_encode($OUTPUT));
?>
