<?php
header('Content-Type: text/plain');
require_once ("../../../login.php");
date_default_timezone_set('Europe/London');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
	die("SQL Connection Error");
}
$sql = "SELECT * FROM porttides_ukho_adjusted WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+8 days"))  . "'";
$result = $conn->query($sql);
$daylightsavingmessage = false;
$counter = 0;
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		if ($counter != 0) echo ",";
		if ($row["tide1time"] != 'ONE--') echo ('"' . $row["tide1time"] . ' (' . $row["tide1height"] . ")\n" .$row["tide2time"] . ' (' .$row["tide2height"] . ')"');
		else echo '"' . $row["tide2time"]. ' (' . $row["tide2height"] . ')"';
		$counter ++;
	}
}
$conn->close();
?>