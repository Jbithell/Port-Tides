<?php
/* This script converts GMT tidal data stored in $tablefrom to GMT/BST and puts it in $tableto (Which must be an empty table!) */
//Setup
$tableto = 'porttides_ukho_adjusted';
$tablefrom = 'porttides_insertionworker';
//Begin Script
require_once '../../../config.php';
date_default_timezone_set('Europe/London');

//Check you have required dblogins!
// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
die("Connection failed, please contact support");
}
$sql = "SELECT * FROM " . $tablefrom;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$gmttides = array();
	$heights = array();
	while($row = $result->fetch_assoc()) {
		if ($row["tide1time"] != 'ONE--') {
			array_push($gmttides,strtotime($row["date"] . ' ' . $row["tide1time"]));
			array_push($heights,$row["tide1height"]);
		}
		array_push($gmttides,strtotime($row["date"] . ' ' . $row["tide2time"]));
		array_push($heights,$row["tide2height"]);
	}
} else {
die("Data Error");
}

//Do the adjustment!
$adjustedtides = array();
foreach ($gmttides as $tide) {
	if (date('I', $tide)) array_push($adjustedtides, ($tide + 3600));
	else array_push($adjustedtides, ($tide));
}

$previousdate = '';
$counter=0;

foreach ($adjustedtides as $tide) {
	$date = date('Y-m-d', $tide);
	$time = date('H:i', $tide);
	$nextdate = date('Y-m-d', $adjustedtides[$counter+1]);
	$nexttime = date('H:i', $adjustedtides[$counter+1]);
	//echo $date . ' ' . $time . ' - ' . $nextdate . ' ' . $nexttime . ' - ' . $previousdate . ' - ' . $tide . "\n";
	if ($date != $previousdate) {
		//We are on a new day!
		if ($nextdate == $date) $sql = "INSERT INTO `" . $tableto . "` (`date`, `tide1time`, `tide2time`, `tide1height`, `tide2height`) VALUES ('" . $date . "','" . $time . "', '" . $nexttime . "', '" . $heights[$counter] . "', '" . $heights[$counter+1] . "')";
		else $sql = "INSERT INTO `" . $tableto . "` (`date`, `tide1time`, `tide2time`, `tide1height`, `tide2height`) VALUES ('" . $date . "','ONE--', '" . $time . "', '-TIDE', '" . $heights[$counter] . "')";
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	}

	//Get ready for next one!
	$previousdate = date('Y-m-d', $tide);
	$counter++;
}
echo 'All Adjusted';
$conn->close();
?>
