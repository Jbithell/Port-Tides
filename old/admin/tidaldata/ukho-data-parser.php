<?php
error_reporting(-1);
ini_set('display_errors', 'On');
/*
	This program is designed to convert UKHO Format 12 data to a sql table - It only works for Porthmadog!
	RUN adjust.php after this
*/
//Config!
$table = 'porttides_insertionworker';
$pathtodata = "../../../originaldata/2019.txt"; //Path to file
//Eng Config

//Begin Program
date_default_timezone_set('Europe/London');
require_once '../../../config.php';
$data = file_get_contents($pathtodata);
$data = str_replace("X,L,X,","",$data);
$data = str_replace(",X,L,X","",$data);
$data = str_replace('"0484","Porthmadog",52.92,-4.13,',"",$data);
$data = str_replace(',0,+0000',"",$data);
$data = str_replace(",H,","",$data);
$data = str_replace(",","",$data);
//echo 'Here is the formatted data: ' . $data . ' look ok?';

$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($conn->connect_error) die("Connection failed");




foreach(explode("\n", $data) as $line) {
	//echo $line;
	//echo strlen($line);
	if (strlen($line) == 9) $nextdate = $line; //Date for next iteration
	elseif (strlen($line) < 9) continue; //Line is empty (Could be last line)
	else {
		$tide1time = substr($line, 0, 4);
		$tide1height = substr($line, 4, 5);
		if (strlen($line) <= 10) {
			//One tide today!
			$tide2time = $tide1time;
			$tide2height = $tide1height;
			$tide1time = "ONE--";
			$tide1height = "-TIDE";
		} else {
			$tide2time = substr($line, 9, 4);
			$tide2height = substr($line, 13, 5);
		}
		$tides[] = array(date('Y-m-d', strtotime($nextdate)), $tide1time, $tide2time, $tide1height, $tide2height);

		unset($nextdate, $tide1time, $tide2time, $tide1height, $tide2height);
	}
}
print_r($tides);
foreach ($tides as $days) {
	if (!$conn->query("INSERT INTO " . $table . " VALUES ('" . $days[0] . "', '" . $days[1] . "', '" . $days[2] . "', '" . $days[3] . "', '" . $days[4] . "')")) echo mysqli_error($conn);
}
echo "Done. " .  count($tides) . " days worth of tides inserted!";
?>
