<?php
require_once '../../../../login.php';
$lang = 'en';
if (isset($_GET['lang'])) $lang = $_GET['lang'];
//Announcements system!
// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
die("Connection failed, please contact support");
}
$sql = "SELECT * FROM porttides_announcements WHERE visible=1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo '<div class="alert alert-danger alert-dismissable"  style="margin-bottom: 0px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . ($lang == 'en' ? $row["text"] : $row["wtext"]) . ' ' . (empty($row["linktext"]) ? null : '<a href="' . $row["linkurl"] . '?lang=' . $lang . '" class="alert-link">' . ($lang == 'en' ? $row["linktext"] : $row["wlinktext"]). '</a>') . '</div>';
	}
}
?>