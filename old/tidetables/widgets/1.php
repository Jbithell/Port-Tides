<?php
                            require_once (dirname(__FILE__)."/../login.php");
                           date_default_timezone_set('Europe/London');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
    die("SQL Connection Error");
} 

$sql = "SELECT * FROM ukhoporthmadogdata WHERE date = '" . date('Y-m-d') . "'";
$result = $conn->query($sql);

$daylightsavingmessage = false;
if ($result->num_rows > 0) {
    echo '<html><head><title>Porthmadog Tide Times</title> <style> body { width: 150px; height: 76px; } </style></head><body><div id=\'tidetimes\'><center>Porthmadog Tide Times<p>';
    while($row = $result->fetch_assoc()) {
        echo "<h3>";
        if (date("I") == 1) $daylightsavingmessage = true;
        echo '</h3><p>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        else echo $row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        
    }
    
    
}
$conn->close();
echo '</p>';
if ($daylightsavingmessage) echo '<i>Not adjusted for BST (Displayed in GMT)</i>';
echo '</div></body></html>';
                            ?>