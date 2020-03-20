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
    while($row = $result->fetch_assoc()) {
        if ($counter == 0) {
        echo '<html><head><style>h3{    padding: 0px;    margin: 0px;}</style></head><body><center><table allign="center" border="0" cellpadding="5">';
        echo "<tr><th><h3>";
        echo date("l"); 
        echo '</h3></th><th><h3>';
        echo date("l", strtotime("+1 days")); 
        echo '</h3></th></tr><tr><td>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        echo '</td>';
        } elseif ($counter == 1) {
        echo '<td>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        echo '</td></tr>';
        } elseif ($counter == 2) {
        echo "<tr><th><h3>";
        echo date("l", strtotime("+2 days")); 
        echo '</h3></th><th><h3>';
        echo date("l", strtotime("+3 days")); 
        echo '</h3></th></tr><tr><td>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        echo '</td>';
        } elseif ($counter == 3) {
        echo '<td>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        echo '</td></tr>';
        } elseif ($counter == 4) {
        echo "<tr><th><h3>";
        echo date("l", strtotime("+4 days")); 
        echo '</h3></th><th><h3>';
        echo date("l", strtotime("+5 days")); 
        echo '</h3></th></tr><tr><td>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        echo '</td>';
        } elseif ($counter == 5) {
        echo '<td>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        echo '</td></tr></table>';
        } elseif ($counter == 6) {
        echo '<table allign="center" border="0" cellpadding="5"><tr><th><h3>';
        echo date("l", strtotime("+6 days")); 
        echo '</h3></th></tr><tr><td>';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")";
        echo '</td><tr></table>';
        }
        $counter ++;
        
    }
    
    
}
$conn->close();

if ($daylightsavingmessage) echo '<i>Not adjusted for BST (Displayed in GMT)</i>';
echo '</center></body></html>';
                            ?>