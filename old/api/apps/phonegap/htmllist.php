<?php
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
$prevmonth = 0;
echo '<ons-list-header class="list__header ons-list-header-inner">' . date("F") . ' ' . date("Y") . '</ons-list-header>';
while ($row = $result->fetch_assoc()) {
	if ($prevmonth != date("F",strtotime($row['date']))) echo '<ons-list-header class="list__header ons-list-header-inner">' . date("F",strtotime($row['date'])) . ' ' . date("Y",strtotime($row['date'])) . '</ons-list-header>';
	echo '<ons-list-item';
	//echo 'modifier="chevron"';
	echo ' class="item list__item ons-list-item-inner';
	//echo 'list__item--chevron';
	echo '"';
	//echo 'onclick="showDetail({date: ' . "'" . date("l d F Y",strtotime($row['date'])) . "'" . ', tide1time: ' . "'" . $row['tide1time'] . "'" . ',tide2time: ' . "'" . $row['tide2time'] . "'" . ',tide1height: ' . "'" . $row['tide1height'] . "'" . ',tide2height: ' . "'" . $row['tide2height'] . "'" . '})"';
	echo '>
			<ons-row class="row ons-row-inner">
				<ons-col style="-webkit-box-flex: 0; flex: 0 0 60px; max-width: 60px;" class="col ons-col-inner"> 
					<div class="item-thum"><img src="images\days' . '\\' . date("d",strtotime($row['date'])) . '.jpg" style="width: 50px; height: 50px;" alt="Day of Week"></div>
				</ons-col>
				<ons-col class="col ons-col-inner">
					<header>
						<span class="item-title">' . date("l",strtotime($row['date'])) . ' ' . date("d",strtotime($row['date'])) . '<sup>' . date("S",strtotime($row['date'])) . '</sup> ' . date("F",strtotime($row['date'])) . ' ' . date("Y",strtotime($row['date'])) . '</span>
					</header>
					<p class="item-desc">' . ($row['tide1time'] == 'ONE--' ? null : $row['tide1time'] . ' (' . $row['tide1height'] . ') &amp; ') . $row['tide2time'] . ' (' . $row['tide2height'] . ')</p>
					<!--<span class="list-item-note lucent"></span>-->
				</ons-col>
			</ons-row>
		</ons-list-item>';
		$prevmonth = date("F",strtotime($row['date'])); //Previous Month
}
echo '<ons-list-item class="item list__item ons-list-item-inner">
		<ons-row class="row ons-row-inner">
		<ons-col class="col ons-col-inner">
			<header>
				<span class="item-title">Tide times for further into the future than a year</span>
			</header>
			<p class="item-desc">Due to Copyright constraints we are unable to display tides beyond a year in advance. More information is available on our website - Port-Tides.com</p>
		</ons-col>
	</ons-row>
</ons-list-item>';
$conn->close();
?>