<?php
                            require_once (dirname(__FILE__)."/../login.php");
                           date_default_timezone_set('Europe/London');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
    die("SQL Connection Error");
} 

$sql = "SELECT * FROM porttides_ukhoporthmadogdata WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+6 days"))  . "'";
$result = $conn->query($sql);
$counter = 0;
$daylightsavingmessage = false;
if ($result->num_rows > 0) {
    echo '<html><head><style>h3{    padding: 0px;    margin: 0px;}</style></head><body><center>';
    while($row = $result->fetch_assoc()) {
        echo "<h3>";
        echo date("l", strtotime("+" . $counter . " days")); 
        if (date("I", strtotime("+" . $counter . " days")) == 1) $daylightsavingmessage = true;
        echo '</h3><p>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")</p>";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")</p>";
        $counter ++;
    }
    
    
}
$conn->close();

if ($daylightsavingmessage) echo '<i>Not adjusted for BST (Displayed in GMT)</i>';
echo '</center></body></html>';
                            ?>