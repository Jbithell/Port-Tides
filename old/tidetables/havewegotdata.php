<?php
require_once (dirname(__FILE__)."/../login.php");
date_default_timezone_set('Europe/London');

function havewegotdata($month, $year) {
global $db_hostname;
global $db_username;
global $db_password;
global $db_database;
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
    die("SQL Connection Error" .  $conn->connect_error);
} 
$sql = "SELECT * FROM ukhoporthmadogdata WHERE date BETWEEN '" . date('Y-m-d', strtotime('01-' . $month . '-' . $year)) . "' AND '" . date('Y-m-t', strtotime('01-' . $month . '-' . $year))  . "'";
$result = $conn->query($sql);
$counter = 0;
$daylightsavingmessage = false;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $counter ++;
    }
    $conn->close();
    if (cal_days_in_month(CAL_GREGORIAN,$month,$year) == $counter) return true;
    else return false;
    }
    else {
    $conn->close();
    return false;
    }

}
?>
