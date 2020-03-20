<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
require_once ("../../../login.php");
date_default_timezone_set('Europe/London');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
	die("SQL Connection Error");
}
$sql = "SELECT * FROM porttides_ukho_adjusted WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+1 year"))  . "'";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
	array_push($data,["day" => date("l",strtotime($row['date'])), "date" => date("d",strtotime($row['date'])), "month" => date("F",strtotime($row['date'])), "year" => date("Y",strtotime($row['date'])),"tide1time" => $row['tide1time'],"tide1height" => $row['tide1height'],"tide2time" => $row['tide2time'],"tide2height" => $row['tide2height']]);
}
echo json_encode($data);
$conn->close();
?>