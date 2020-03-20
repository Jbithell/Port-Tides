<html>
<?php
//Kick off the dock
require_once 'login.php';
require_once 'simple_html_dom.php';
date_default_timezone_set('Europe/London');

//Connect to sql
$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());

//Check startdate status
if (empty($_GET)) {
    die("No start date<br>Dates to be given in this format: " . date("Y-m-d") . " in the URL like this ?date=" . date("Y-m-d"));
}
//Get start date
$datebeingproccessed = ($_GET["date"]);
$dateinput = strtotime($_GET["date"]);
$datetoarchive = date('Ymd',$dateinput);

//Get the tide times for that date
$html = file_get_html("http://www.tidetimes.org.uk/porthmadog-tide-times-" . $datetoarchive); 
if (count($html->find('td[class=low-tide]')) == 1) {
    foreach ($html->find('td[class=low-tide]') as $element) {
         $tide1 = $element;
         $tide1string = str_replace("<span>","",$tide1);
         $tide1string1 = str_replace("</span>","",$tide1string);
         $tide1string2 = str_replace("<td class=","",$tide1string1);
         $tide1string3 = str_replace("</td>","",$tide1string2);
         $tide1time = substr($tide1string3, 11, 5);
         $tide1height = substr($tide1string3, 18, 5);
         //echo $tide1time;
         //echo $tide1height;
         $output .= $tide1time;
         $output .= $tide1height;
         $output .= "ONE--";
         $output .= "-TIDE";
         }
}
elseif (count($html->find('td[class=low-tide]')) == 2) {
$counter = 1;
    foreach ($html->find('td[class=low-tide]') as $element) {
        if($counter==1){
            $tide1 = $element;
		}
		elseif($counter==2) {
		    $tide2 = $element;
		}
        $counter++;
    }

$tide1string = str_replace("<span>","",$tide1);
$tide1string1 = str_replace("</span>","",$tide1string);
$tide1string2 = str_replace("<td class=","",$tide1string1);
$tide1string3 = str_replace("</td>","",$tide1string2);
$tide1time = substr($tide1string3, 11, 5);
$tide1height = substr($tide1string3, 18, 5);
//echo $tide1time;
//echo $tide1height;
$output .= $tide1time;
$output .= $tide1height;

//echo "<br>";

$tide2string = str_replace("<span>","",$tide2);
$tide2string1 = str_replace("</span>","",$tide2string);
$tide2string2 = str_replace("<td class=","",$tide2string1);
$tide2string3 = str_replace("</td>","",$tide2string2);
$tide2time = substr($tide2string3, 11, 5);
$tide2height = substr($tide2string3, 18, 5);
//echo $tide2time;
//echo $tide2height;
$output .= $tide2time;
$output .= $tide2height;

}
else
{
    $notoneortwotableelements = true;
}
if ($notoneortwotableelements == "true") {
die("The page either has a different format or was not found. <br>" . "You can visit the offending page here:  " . "http://www.tidetimes.org.uk/porthmadog-tide-times-" . $datetoarchive);
}

//echo $output;
//Get today
$html = file_get_html('tidetimes.txt')->plaintext; 
$todaytide1time = substr($html, 0, 5);


if ($todaytide1time == $tide1time){
die("All finished");
}
//SQL Update Archive
$query = "DELETE FROM porttides_archive WHERE date='$datebeingproccessed'";$result = mysql_query($query);if (!$result) die ("Database access failed: " . mysql_error());
$query = "INSERT INTO porttides_archive VALUES('$datebeingproccessed', '$tide1time', '$tide2time', '$tide1height', '$tide2height')";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());

//echo ("http://www.tidetimes.org.uk/porthmadog-tide-times-" . $datetoarchive);

//Redirect to do next date
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
$pageurl = substr_replace(curPageURL(),"",-16);
$nextdate = date("Y-m-d",strtotime($datebeingproccessed . " -1 day"));
$nexturl = ($pageurl . "?date=" . $nextdate);
//echo $nexturl;
echo ('<script>window.location.href = "' . $nexturl . '";</script>');

?>
</html>