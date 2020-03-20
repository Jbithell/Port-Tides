<?php 
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0"?>';
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title>Porthmadog Tide Times</title>
<description>Free tidal predictions for Porthmadog</description>
<link>http://port-tides.com</link>
<language>en-us</language>
<atom:link href="http://www.port-tides.com/rss.php" rel="self" type="application/rss+xml" />
<copyright>All Tidal Data is Crown Copyright. Reproduced by permission of the Controller of Her Majestys Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department.</copyright>
<?php
require_once "login.php";
date_default_timezone_set('Europe/London');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
    die("SQL Connection Error");
} 

$sql = "SELECT * FROM porttides_ukhoporthmadogdata WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+59 days"))  . "' ORDER BY date ASC";

$result = $conn->query($sql);
$counter = 0;
$daylightsavingmessage = false;
if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        echo '<item><title>';
        //if ($counter < 6) echo date("l", strtotime("+" . $counter . " days")); 
        echo date("l (d/m/y)", strtotime("+" . $counter . " days")); 
        if (date("I", strtotime("+" . $counter . " days")) == 1) $daylightsavingmessage = true;
        echo '</title><link>http://www.port-tides.com</link><pubDate>';
        echo date("r", strtotime("-" . $counter . " days"));         
        echo '</pubDate><description>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]." (".$row["tide1height"].") and ".$row["tide2time"]." (".$row["tide2height"].")";
        else echo "" . $row["tide2time"]." (".$row["tide2height"].")";
        echo '</description>';
        echo '<guid isPermaLink="false">';
        echo 'tidalprediction' . date("dmy", strtotime("+" . $counter . " days")); 
        echo '</guid>';
        echo '</item>';
        $counter ++;
    }
    
    
}
$conn->close();

//if ($daylightsavingmessage) echo 'Not adjusted for BST (Displayed in GMT)';
?>
</channel></rss>