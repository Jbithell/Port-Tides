<?php 
date_default_timezone_set('Europe/London');
require 'simple_html_dom.php';
function failmsg() {
    $output = '<div id="Error Message" style="width: 100%; background-color:#FFD700;"><center><h3 style="padding: 0px; margin: 0px;">We are currently experiencing issues with our site - Tidal Predictions may not be accurate.</h3></center></div>';
    $fh = fopen("errormessage.html", 'r+') or die("Major Error");
    if (flock($fh, LOCK_EX))
    {
        ftruncate($fh, 0);
        fwrite($fh, "$output") or die("Major Error");
        flock($fh, LOCK_UN);
    }
    fclose($fh);
    echo "Major Error - Activated error message system";
    die('<br><br>This page will refresh every 5 mins to try to solve the probelm!<meta http-equiv="refresh" content="300">');
}


//Today
$html = file_get_html("http://www.tidetimes.org.uk/porthmadog-tide-times-" . date("Ymd")) or failmsg(); 
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
    failmsg();
}


//Tomorrow - 2nd Day
$html = file_get_html("http://www.tidetimes.org.uk/porthmadog-tide-times-" . date("Ymd", strtotime('+1 day'))) or failmsg(); 
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
    failmsg();
}
//DayafterTomorrow - 3rd Day
$html = file_get_html("http://www.tidetimes.org.uk/porthmadog-tide-times-" . date("Ymd", strtotime('+2 day'))) or failmsg(); 
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
    failmsg();
}

//4th Day
$html = file_get_html("http://www.tidetimes.org.uk/porthmadog-tide-times-" . date("Ymd", strtotime('+3 day'))) or failmsg(); 
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
    failmsg();
}
//5th Day
$html = file_get_html("http://www.tidetimes.org.uk/porthmadog-tide-times-" . date("Ymd", strtotime('+4 day'))) or failmsg(); 
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
    failmsg();
}
//6th Day
$html = file_get_html("http://www.tidetimes.org.uk/porthmadog-tide-times-" . date("Ymd", strtotime('+5 day'))) or failmsg(); 
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
    failmsg();
}
//7th Day
$html = file_get_html("http://www.tidetimes.org.uk/porthmadog-tide-times-" . date("Ymd", strtotime('+6 day'))) or failmsg(); 
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
    failmsg();
}
//echo "<br>";
//Final Outputs
echo $output;
echo "<br>";
$fh = fopen("tidetimesdata-andoutputs/tidetimes.txt", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  //fseek($fh, 0, SEEK_END);
  //file_put_contents($fh, "$output") or die("Could not write to file");
  ftruncate($fh, 0);
  fwrite($fh, "$output") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "File 'tidetimes.txt' successfully updated";
if ($notoneortwotableelements == "true") {
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
echo "<br/>There were not one or two elements which is an ERROR. You need to find out why this has happened - Maybe dick dolby changed the formatting!";
$message = ("Dear James Bithell, There has been a major error on a automated php script - One or more request from the tide times online server has come back saying there is unexpected formatting. This page is at:  " .  curPageURL());
$wrappedmessage = wordwrap($message, 70);
$from = "errors@web-tides.com";
mail("james@bithell.com","PHP Script Error - Has tide times online changed formatting?",$wrappedmessage,"From: $from\n");
failmsg();
}

//Converted to SQL 13/11/2014

/*

//Begin Section 2 - Update the vertical HTML File based on output
date_default_timezone_set('Europe/London');
$html = file_get_html('tidetimesdata-andoutputs/tidetimes.txt')->plaintext; 
//Today;
$tide1time = substr($html, 0, 5);
$tide1height = substr($html, 5, 5);
$output = ("<html><head><style>h3{    padding: 0px;    margin: 0px;}</style></head><body><center><h3>" . date("l") . "</h3><p>");
$output .= ($tide1time . " (" . $tide1height . ")<br/>");
$tide2time = substr($html, 10, 5);
$tide2height = substr($html, 15, 5);
if ($tide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($tide2time . " (" . $tide2height . ")<p>");
}

//Tomorrow;
$tomorrowtide1time = substr($html, 20, 5);
$tomorrowtide1height = substr($html, 25, 5);
$output .= ("<h3>" . date("l", strtotime("+1 days")) . "</h3><p>");
$output .= ($tomorrowtide1time . " (" . $tomorrowtide1height . ")<br/>");
$tomorrowtide2time = substr($html, 30, 5);
$tomorrowtide2height = substr($html, 35, 5);
if ($tomorrowtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($tomorrowtide2time . " (" . $tomorrowtide2height . ")<p>");
}
//3rd Day;
$thirdtide1time = substr($html, 40, 5);
$thirdtide1height = substr($html, 45, 5);
$output .= ("<h3>" . date("l", strtotime("+2 days")) . "</h3><p>");
$output .= ($thirdtide1time . " (" . $thirdtide1height . ")<br/>");
$thirdtide2time = substr($html, 50, 5);
$thirdtide2height = substr($html, 55, 5);
if ($thirdtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($thirdtide2time . " (" . $thirdtide2height . ")<p>");
}
//4th Day;
$fourthtide1time = substr($html, 60, 5);
$fourthtide1height = substr($html, 65, 5);
$output .= ("<h3>" . date("l", strtotime("+3 days")) . "</h3><p>");
$output .= ($fourthtide1time . " (" . $fourthtide1height . ")<br/>");
$fourthtide2time = substr($html, 70, 5);
$fourthtide2height = substr($html, 75, 5);
if ($fourthtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($fourthtide2time . " (" . $fourthtide2height . ")<p>");
}
//5th Day;
$fifthtide1time = substr($html, 80, 5);
$fifthtide1height = substr($html, 85, 5);
$output .= ("<h3>" . date("l", strtotime("+4 days")) . "</h3><p>");
$output .= ($fifthtide1time . " (" . $fifthtide1height . ")<br/>");
$fifthtide2time = substr($html, 90, 5);
$fifthtide2height = substr($html, 95, 5);
if ($fifthtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($fifthtide2time . " (" . $fifthtide2height . ")<p>");
}
//6th Day;
$sixthtide1time = substr($html, 100, 5);
$sixthtide1height = substr($html, 105, 5);
$output .= ("<h3>" . date("l", strtotime("+5 days")) . "</h3><p>");
$output .= ($sixthtide1time . " (" . $sixthtide1height . ")<br/>");
$sixthtide2time = substr($html, 110, 5);
$sixthtide2height = substr($html, 115, 5);
if ($sixthtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($sixthtide2time . " (" . $sixthtide2height . ")<p>");
}
//7th Day;
$seventhtide1time = substr($html, 120, 5);
$seventhtide1height = substr($html, 125, 5);
$output .= ("<h3>" . date("l", strtotime("+6 days")) . "</h3><p>");
$output .= ($seventhtide1time . " (" . $seventhtide1height . ")<br/>");
$seventhtide2time = substr($html, 130, 5);
$seventhtide2height = substr($html, 135, 5);
if ($seventhtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($seventhtide2time . " (" . $seventhtide2height . ")<p>");
}
//Closing Tags;
$output .= ("</center></body></html>");
//echo $output;
$fh = fopen("tidetimesdata-andoutputs/tidetimes-7days-vertical.html", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  ftruncate($fh, 0);
  fwrite($fh, "$output") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "<br>File 'tidetimes-7days-vertical.html' successfully updated";

//Begin Section 3 - Update the 2 coloumns HTML file;
//Today + Tomorrow;
$tide1time = substr($html, 0, 5);
$tide1height = substr($html, 5, 5);
$output = ('<html><head><style>h3{    padding: 0px;    margin: 0px;}</style></head><body><center><table allign="center" border="0" cellpadding="5"><tr><th><h3>' . date("l") . '</h3></th><th><h3>' . date("l", strtotime("+1 days")) . "</h3></th></tr><tr><td>");
$output .= ($tide1time . " (" . $tide1height . ")<br/>");
$tide2time = substr($html, 10, 5);
$tide2height = substr($html, 15, 5);
if ($tide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($tide2time . " (" . $tide2height . ")</td>");
}
$tomorrowtide1time = substr($html, 20, 5);
$tomorrowtide1height = substr($html, 25, 5);
$output .= ("<td>" . $tomorrowtide1time . " (" . $tomorrowtide1height . ")<br/>");
$tomorrowtide2time = substr($html, 30, 5);
$tomorrowtide2height = substr($html, 35, 5);
if ($tomorrowtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($tomorrowtide2time . " (" . $tomorrowtide2height . ")</td>");
}
//3rd + 4th Day;
$thirdtide1time = substr($html, 40, 5);
$thirdtide1height = substr($html, 45, 5);
$output .= ("<tr><th><h3>" . date("l", strtotime("+2 days")) . "</h3></th><th><h3>" . date("l", strtotime("+3 days")) . "</h3></th></tr><tr><td>");
$output .= ($thirdtide1time . " (" . $thirdtide1height . ")<br/>");
$thirdtide2time = substr($html, 50, 5);
$thirdtide2height = substr($html, 55, 5);
if ($thirdtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($thirdtide2time . " (" . $thirdtide2height . ")</td>");
}
$fourthtide1time = substr($html, 60, 5);
$fourthtide1height = substr($html, 65, 5);
$output .= ("<td>" . $fourthtide1time . " (" . $fourthtide1height . ")<br/>");
$fourthtide2time = substr($html, 70, 5);
$fourthtide2height = substr($html, 75, 5);
if ($fourthtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($fourthtide2time . " (" . $fourthtide2height . ")</td>");
}
//5th + 6th Day;
$fifthtide1time = substr($html, 80, 5);
$fifthtide1height = substr($html, 85, 5);
$output .= ("<tr><th><h3>" . date("l", strtotime("+4 days")) . "</h3></th><th><h3>" . date("l", strtotime("+5 days")) . "</h3></th></tr><tr><td>");
$output .= ($fifthtide1time . " (" . $fifthtide1height . ")<br/>");
$fifthtide2time = substr($html, 90, 5);
$fifthtide2height = substr($html, 95, 5);
if ($fifthtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($fifthtide2time . " (" . $fifthtide2height . ")</td>");
}
$sixthtide1time = substr($html, 100, 5);
$sixthtide1height = substr($html, 105, 5);
$output .= ("<td>" . $sixthtide1time . " (" . $sixthtide1height . ")<br/>");
$sixthtide2time = substr($html, 110, 5);
$sixthtide2height = substr($html, 115, 5);
if ($sixthtide2time == "ONE--") {
$output .= ("</td></tr></table>");
}
else
{
$output .= ($sixthtide2time . " (" . $sixthtide2height . ")</td></tr></table>");
}
//7th Day;
$seventhtide1time = substr($html, 120, 5);
$seventhtide1height = substr($html, 125, 5);
$output .= ('<table allign="center" border="0" cellpadding="5"><tr><th><h3>' . date("l", strtotime("+6 days")) . "</h3></th></tr><tr><td>");
$output .= ($seventhtide1time . " (" . $seventhtide1height . ")<br/>");
$seventhtide2time = substr($html, 130, 5);
$seventhtide2height = substr($html, 135, 5);
if ($seventhtide2time == "ONE--") {
$output .= ("</td></tr></table>");
}
else
{
$output .= ($seventhtide2time . " (" . $seventhtide2height . ")</td><tr></table>");
}
//Closing Tags;
$output .= ("</center></body></html>");
//echo $output;
$fh = fopen("tidetimesdata-andoutputs/tidetimes-7days-2col.html", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  ftruncate($fh, 0);
  fwrite($fh, "$output") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "<br/>";
echo "File 'tidetimes-7days-2col.html' successfully updated";
$renewdate = "07-9";
if (date(m-d) == $renewdate) {
echo "RENEW LICENCE ASAP";
$from = "tides@web-tides.com";
$subject = "RENEW LICENCE";
$message = "Please renew UKHO Licence for Web Tides and Port Tides";
$message = wordwrap($message, 70);
mail("james@bithell.com",$subject,$message,"From: $from\n");
failmsg();
}


//Section 4 - Update MySQL Database
echo "<br>Section4 - MY SQL";
require_once 'login.php';
require_once 'simple_html_dom.php';
date_default_timezone_set('Europe/London');
$html = file_get_html('tidetimesdata-andoutputs/tidetimes.txt')->plaintext; 
//Today;
$tide1time = substr($html, 0, 5);
$tide1height = substr($html, 5, 5);
$tide2time = substr($html, 10, 5);
$tide2height = substr($html, 15, 5);
//Tomorrow;
$tomorrowtide1time = substr($html, 20, 5);
$tomorrowtide1height = substr($html, 25, 5);
$tomorrowtide2time = substr($html, 30, 5);
$tomorrowtide2height = substr($html, 35, 5);
//3rd Day;
$thirdtide1time = substr($html, 40, 5);
$thirdtide1height = substr($html, 45, 5);
$thirdtide2time = substr($html, 50, 5);
$thirdtide2height = substr($html, 55, 5);
//4th Day;
$fourthtide1time = substr($html, 60, 5);
$fourthtide1height = substr($html, 65, 5);
$fourthtide2time = substr($html, 70, 5);
$fourthtide2height = substr($html, 75, 5);
//5th Day;
$fifthtide1time = substr($html, 80, 5);
$fifthtide1height = substr($html, 85, 5);
$fifthtide2time = substr($html, 90, 5);
$fifthtide2height = substr($html, 95, 5);
//6th Day;
$sixthtide1time = substr($html, 100, 5);
$sixthtide1height = substr($html, 105, 5);
$sixthtide2time = substr($html, 110, 5);
$sixthtide2height = substr($html, 115, 5);
//7th Day;
$seventhtide1time = substr($html, 120, 5);
$seventhtide1height = substr($html, 125, 5);
$seventhtide2time = substr($html, 130, 5);
$seventhtide2height = substr($html, 135, 5);
$seventhdate = date("Y-m-d", strtotime('+6 day'));


//Connect to server
$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());

//Get yesterday's date
$yesterdaysdate = date("Y-m-d", strtotime('-1 day'));



//Add to archive table (Delete just in case!);
$query = "SELECT * FROM archive WHERE date='$yesterdaysdate'";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)
{
	$row = mysql_fetch_row($result);
	for ($k = 0 ; $k < 1 ; ++$k) $yesterdaydatefromarchive .= "$row[$k]";
}
if ($yesterdaydatefromarchive == $yesterdaysdate) {
}
else {
//Get yesterday's tide times from current table
$query = "SELECT * FROM current WHERE date='$yesterdaysdate'";

$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);

for ($j = 0 ; $j < $rows ; ++$j)
{
	$row = mysql_fetch_row($result);
	for ($k = 0 ; $k < 5 ; ++$k) $yesterdaytoarchive .= "$row[$k]";
  //echo $yesterdaytoarchive;
}
//Finish off the archive data
$yesterdaydate = date("Y-m-d", strtotime('-1 day'));
$yesterdaytide1time = substr($yesterdaytoarchive, 10, 5);
$yesterdaytide2time = substr($yesterdaytoarchive, 15, 5);
$yesterdaytide1height = substr($yesterdaytoarchive, 20, 5);
$yesterdaytide2height = substr($yesterdaytoarchive, 25, 5);
//echo "<br>";
//echo $yesterdaytide1time;
//echo "<br>";
//echo $yesterdaytide2time;
//echo "<br>";
//echo $yesterdaytide1height;
//echo "<br>";
//echo $yesterdaytide2height;
//echo "<br>";
$query = "INSERT INTO archive VALUES('$yesterdaydate', '$yesterdaytide1time', '$yesterdaytide2time', '$yesterdaytide1height', '$yesterdaytide2height')";

$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
}
//Delete data from table
$query = "DELETE FROM current WHERE date='$yesterdaysdate'";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());

//Insert tide time 7 days from now. (Delete Just in case!);
$query = "DELETE FROM current WHERE date='$seventhdate'";$result = mysql_query($query);if (!$result) die ("Database access failed: " . mysql_error());
$query = "INSERT INTO current VALUES('$seventhdate', '$seventhtide1time', '$seventhtide2time', '$seventhtide1height', '$seventhtide2height')";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());

$query = "SELECT * FROM current";

$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);

echo "<table border='1' allign='center'><tr> <th>Date</th> <th>Tide 1 Time</th>
	<th>Tide 2 Time</th><th>Tide 1 Height</th><th>Tide 2 Height</th></tr>";

for ($j = 0 ; $j < $rows ; ++$j)
{
	$row = mysql_fetch_row($result);
	echo "<tr>";
	for ($k = 0 ; $k < 5 ; ++$k) echo "<td>$row[$k]</td>";
	echo "</tr>";
}
echo "</table>";


mysql_close($db_server);
//End Section 4



//Begin Section 5 - Update widget 1
date_default_timezone_set('Europe/London');
$html = file_get_html('tidetimesdata-andoutputs/tidetimes.txt')->plaintext; 
//Today;
$tide1time = substr($html, 0, 5);
$tide1height = substr($html, 5, 5);
$output = ("<html><head><title>Porthmadog Tide Times</title> <style> body { width: 150px; height: 76px; } </style></head><body><div id='tidetimes'><center>Porthmadog Tide Times<p>");
$output .= ($tide1time . " (" . $tide1height . ")<br/>");
$tide2time = substr($html, 10, 5);
$tide2height = substr($html, 15, 5);
if ($tide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($tide2time . " (" . $tide2height . ")</p></center></div>");
}
$fh = fopen("widgets/1.html", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  //fseek($fh, 0, SEEK_END);
  //file_put_contents($fh, "$output") or die("Could not write to file");
  ftruncate($fh, 0);
  fwrite($fh, "$output") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
$fh = fopen("tidetimesdata-andoutputs/tidetimes-today-simple.html", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  //fseek($fh, 0, SEEK_END);
    //file_put_contents($fh, "$output") or failmsg();
  ftruncate($fh, 0);
  fwrite($fh, "$output") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "File 'tidetimes-today-simple.html' WIDGET 1 successfully updated";

//Begin Section 6 - update widget 2
date_default_timezone_set('Europe/London');
$html = file_get_html('tidetimesdata-andoutputs/tidetimes.txt')->plaintext; 
//Today;
$tide1time = substr($html, 0, 5);
$tide1height = substr($html, 5, 5);
$output = ("<html><head><style>h3{    padding: 0px;    margin: 0px;}</style></head><body><center><h3>" . date("l") . "</h3><p>");
$output .= ($tide1time . " (" . $tide1height . ")<br/>");
$tide2time = substr($html, 10, 5);
$tide2height = substr($html, 15, 5);
if ($tide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($tide2time . " (" . $tide2height . ")<p>");
}

//Tomorrow;
$tomorrowtide1time = substr($html, 20, 5);
$tomorrowtide1height = substr($html, 25, 5);
$output .= ("<h3>" . date("l", strtotime("+1 days")) . "</h3><p>");
$output .= ($tomorrowtide1time . " (" . $tomorrowtide1height . ")<br/>");
$tomorrowtide2time = substr($html, 30, 5);
$tomorrowtide2height = substr($html, 35, 5);
if ($tomorrowtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($tomorrowtide2time . " (" . $tomorrowtide2height . ")<p>");
}
//3rd Day;
$thirdtide1time = substr($html, 40, 5);
$thirdtide1height = substr($html, 45, 5);
$output .= ("<h3>" . date("l", strtotime("+2 days")) . "</h3><p>");
$output .= ($thirdtide1time . " (" . $thirdtide1height . ")<br/>");
$thirdtide2time = substr($html, 50, 5);
$thirdtide2height = substr($html, 55, 5);
if ($thirdtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($thirdtide2time . " (" . $thirdtide2height . ")<p>");
}
//4th Day;
$fourthtide1time = substr($html, 60, 5);
$fourthtide1height = substr($html, 65, 5);
$output .= ("<h3>" . date("l", strtotime("+3 days")) . "</h3><p>");
$output .= ($fourthtide1time . " (" . $fourthtide1height . ")<br/>");
$fourthtide2time = substr($html, 70, 5);
$fourthtide2height = substr($html, 75, 5);
if ($fourthtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($fourthtide2time . " (" . $fourthtide2height . ")<p>");
}
//5th Day;
$fifthtide1time = substr($html, 80, 5);
$fifthtide1height = substr($html, 85, 5);
$output .= ("<h3>" . date("l", strtotime("+4 days")) . "</h3><p>");
$output .= ($fifthtide1time . " (" . $fifthtide1height . ")<br/>");
$fifthtide2time = substr($html, 90, 5);
$fifthtide2height = substr($html, 95, 5);
if ($fifthtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($fifthtide2time . " (" . $fifthtide2height . ")<p>");
}
//6th Day;
$sixthtide1time = substr($html, 100, 5);
$sixthtide1height = substr($html, 105, 5);
$output .= ("<h3>" . date("l", strtotime("+5 days")) . "</h3><p>");
$output .= ($sixthtide1time . " (" . $sixthtide1height . ")<br/>");
$sixthtide2time = substr($html, 110, 5);
$sixthtide2height = substr($html, 115, 5);
if ($sixthtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($sixthtide2time . " (" . $sixthtide2height . ")<p>");
}
//7th Day;
$seventhtide1time = substr($html, 120, 5);
$seventhtide1height = substr($html, 125, 5);
$output .= ("<h3>" . date("l", strtotime("+6 days")) . "</h3><p>");
$output .= ($seventhtide1time . " (" . $seventhtide1height . ")<br/>");
$seventhtide2time = substr($html, 130, 5);
$seventhtide2height = substr($html, 135, 5);
if ($seventhtide2time == "ONE--") {
$output .= ("<p>");
}
else
{
$output .= ($seventhtide2time . " (" . $seventhtide2height . ")<p>");
}
//Closing Tags;
$output .= ("</center></body></html>");
//echo $output;
$fh = fopen("widgets/2.html", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  ftruncate($fh, 0);
  fwrite($fh, "$output") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "<br>File 'widgets/2.html' Widget 2 successfully updated";

//Begin Section 7 - Update widget 3
//Today + Tomorrow;
$tide1time = substr($html, 0, 5);
$tide1height = substr($html, 5, 5);
$output = ('<html><head><style>h3{    padding: 0px;    margin: 0px;}</style></head><body><center><table allign="center" border="0" cellpadding="5"><tr><th><h3>' . date("l") . '</h3></th><th><h3>' . date("l", strtotime("+1 days")) . "</h3></th></tr><tr><td>");
$output .= ($tide1time . " (" . $tide1height . ")<br/>");
$tide2time = substr($html, 10, 5);
$tide2height = substr($html, 15, 5);
if ($tide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($tide2time . " (" . $tide2height . ")</td>");
}
$tomorrowtide1time = substr($html, 20, 5);
$tomorrowtide1height = substr($html, 25, 5);
$output .= ("<td>" . $tomorrowtide1time . " (" . $tomorrowtide1height . ")<br/>");
$tomorrowtide2time = substr($html, 30, 5);
$tomorrowtide2height = substr($html, 35, 5);
if ($tomorrowtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($tomorrowtide2time . " (" . $tomorrowtide2height . ")</td>");
}
//3rd + 4th Day;
$thirdtide1time = substr($html, 40, 5);
$thirdtide1height = substr($html, 45, 5);
$output .= ("<tr><th><h3>" . date("l", strtotime("+2 days")) . "</h3></th><th><h3>" . date("l", strtotime("+3 days")) . "</h3></th></tr><tr><td>");
$output .= ($thirdtide1time . " (" . $thirdtide1height . ")<br/>");
$thirdtide2time = substr($html, 50, 5);
$thirdtide2height = substr($html, 55, 5);
if ($thirdtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($thirdtide2time . " (" . $thirdtide2height . ")</td>");
}
$fourthtide1time = substr($html, 60, 5);
$fourthtide1height = substr($html, 65, 5);
$output .= ("<td>" . $fourthtide1time . " (" . $fourthtide1height . ")<br/>");
$fourthtide2time = substr($html, 70, 5);
$fourthtide2height = substr($html, 75, 5);
if ($fourthtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($fourthtide2time . " (" . $fourthtide2height . ")</td>");
}
//5th + 6th Day;
$fifthtide1time = substr($html, 80, 5);
$fifthtide1height = substr($html, 85, 5);
$output .= ("<tr><th><h3>" . date("l", strtotime("+4 days")) . "</h3></th><th><h3>" . date("l", strtotime("+5 days")) . "</h3></th></tr><tr><td>");
$output .= ($fifthtide1time . " (" . $fifthtide1height . ")<br/>");
$fifthtide2time = substr($html, 90, 5);
$fifthtide2height = substr($html, 95, 5);
if ($fifthtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($fifthtide2time . " (" . $fifthtide2height . ")</td>");
}
$sixthtide1time = substr($html, 100, 5);
$sixthtide1height = substr($html, 105, 5);
$output .= ("<td>" . $sixthtide1time . " (" . $sixthtide1height . ")<br/>");
$sixthtide2time = substr($html, 110, 5);
$sixthtide2height = substr($html, 115, 5);
if ($sixthtide2time == "ONE--") {
$output .= ("</td></tr></table>");
}
else
{
$output .= ($sixthtide2time . " (" . $sixthtide2height . ")</td></tr></table>");
}
//7th Day;
$seventhtide1time = substr($html, 120, 5);
$seventhtide1height = substr($html, 125, 5);
$output .= ('<table allign="center" border="0" cellpadding="5"><tr><th><h3>' . date("l", strtotime("+6 days")) . "</h3></th></tr><tr><td>");
$output .= ($seventhtide1time . " (" . $seventhtide1height . ")<br/>");
$seventhtide2time = substr($html, 130, 5);
$seventhtide2height = substr($html, 135, 5);
if ($seventhtide2time == "ONE--") {
$output .= ("</td></tr></table>");
}
else
{
$output .= ($seventhtide2time . " (" . $seventhtide2height . ")</td><tr></table>");
}
//Closing Tags;
$output .= ("</center></body></html>");
//echo $output;
$fh = fopen("widgets/3.html", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  ftruncate($fh, 0);
  fwrite($fh, "$output") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "<br/>";
echo "Widget 3 successfully updated";


*/
//Section 7 - Update RSS Feed

$rssoutput = '<';
$rssoutput .= '?xml version="1.0" encoding="UTF-8" ';
$rssoutput .= '?';
$rssoutput .= '><rss version="2.0"><channel>  <title>Porthmadog Tide Times</title><description>Free tidal predictions for Porthmadog</description><link>http://port-tides.com</link><item>';
$rssoutput .= '<title>' . date("l") . '</title><description>';
if ($tide2time == 'ONE--') { $rssoutput .= ($tide1time . ' (' . $tide1height . ')</description><link>http://port-tides.com</link></item><item><title>Tomorrow</title><description>'); }
else { $rssoutput .= ($tide1time . ' (' . $tide1height . ') and ' . $tide2time . ' (' . $tide2height . ')</description><link>http://port-tides.com</link></item><item><title>Tomorrow</title><description>'); }
if ($tomorrowtide2time == 'ONE--') { $rssoutput .= ($tomorrowtide1time . ' (' . $tomorrowtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+2 days")) . '</title><description>'); }
else { $rssoutput .= ($tomorrowtide1time . ' (' . $tomorrowtide1height . ') and ' . $tomorrowtide2time . ' (' . $tomorrowtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+2 days")) . '</title><description>'); }
if ($thridtide2time == 'ONE--') { $rssoutput .= ($thirdtide1time . ' (' . $thirdtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+3 days")) . '</title><description>'); }
else { $rssoutput .= ($thirdtide1time . ' (' . $thirdtide1height . ') and ' . $thirdtide2time . ' (' . $thirdtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+3 days")) . '</title><description>'); }
if ($fourthtide2time == 'ONE--') { $rssoutput .= ($fourthtide1time . ' (' . $fourthtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+4 days")) . '</title><description>'); }
else { $rssoutput .= ($fourthtide1time . ' (' . $fourthtide1height . ') and ' . $fourthtide2time . ' (' . $fourthtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+4 days")) . '</title><description>'); }
if ($fifthtide2time == 'ONE--') { $rssoutput .= ($fifthtide1time . ' (' . $fifthtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+5 days")) . '</title><description>'); }
else { $rssoutput .= ($fifthtide1time . ' (' . $fifthtide1height . ') and ' . $fifthtide2time . ' (' . $fifthtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+5 days")) . '</title><description>'); }
if ($sixthtide2time == 'ONE--') { $rssoutput .= ($sixthtide1time . ' (' . $sixthtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+6 days")) . '</title><description>'); }
else { $rssoutput .= ($sixthtide1time . ' (' . $sixthtide1height . ') and ' . $sixthtide2time . ' (' . $sixthtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+6 days")) . '</title><description>'); }
if ($seventhtide2time == 'ONE--') { $rssoutput .= ($seventhtide1time . ' (' . $seventhtide1height . ')</description><link>http://port-tides.com</link></item></channel></rss>'); }
else { $rssoutput .= ($seventhtide1time . ' (' . $seventhtide1height . ') and ' . $seventhtide2time . ' (' . $seventhtide2height . ')</description><link>http://port-tides.com</link></item></channel></rss>'); }
//echo $output;
$fh = fopen("tides.rss", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  ftruncate($fh, 0);
  fwrite($fh, "$rssoutput") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "<br/>";
echo "RSS successfully updated";

//Section 8 - Update RSS Feed Public

$rssoutput = '<';
$rssoutput .= '?xml version="1.0" encoding="UTF-8" ';
$rssoutput .= '?';
$rssoutput .= '><rss version="2.0"><channel>  <title>Porthmadog Tide Times</title><description>Free tidal predictions for Porthmadog</description><link>http://port-tides.com</link><item>';
$rssoutput .= '<title>' . date("l") . '</title><description>';
if ($tide2time == 'ONE--') { $rssoutput .= ($tide1time . ' (' . $tide1height . ')</description><link>http://port-tides.com</link></item><item><title>Tomorrow</title><description>'); }
else { $rssoutput .= ($tide1time . ' (' . $tide1height . ') and ' . $tide2time . ' (' . $tide2height . ')</description><link>http://port-tides.com</link></item><item><title>Tomorrow</title><description>'); }
if ($tomorrowtide2time == 'ONE--') { $rssoutput .= ($tomorrowtide1time . ' (' . $tomorrowtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+2 days")) . '</title><description>'); }
else { $rssoutput .= ($tomorrowtide1time . ' (' . $tomorrowtide1height . ') and ' . $tomorrowtide2time . ' (' . $tomorrowtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+2 days")) . '</title><description>'); }
if ($thridtide2time == 'ONE--') { $rssoutput .= ($thirdtide1time . ' (' . $thirdtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+3 days")) . '</title><description>'); }
else { $rssoutput .= ($thirdtide1time . ' (' . $thirdtide1height . ') and ' . $thirdtide2time . ' (' . $thirdtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+3 days")) . '</title><description>'); }
if ($fourthtide2time == 'ONE--') { $rssoutput .= ($fourthtide1time . ' (' . $fourthtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+4 days")) . '</title><description>'); }
else { $rssoutput .= ($fourthtide1time . ' (' . $fourthtide1height . ') and ' . $fourthtide2time . ' (' . $fourthtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+4 days")) . '</title><description>'); }
if ($fifthtide2time == 'ONE--') { $rssoutput .= ($fifthtide1time . ' (' . $fifthtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+5 days")) . '</title><description>'); }
else { $rssoutput .= ($fifthtide1time . ' (' . $fifthtide1height . ') and ' . $fifthtide2time . ' (' . $fifthtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+5 days")) . '</title><description>'); }
if ($sixthtide2time == 'ONE--') { $rssoutput .= ($sixthtide1time . ' (' . $sixthtide1height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+6 days")) . '</title><description>'); }
else { $rssoutput .= ($sixthtide1time . ' (' . $sixthtide1height . ') and ' . $sixthtide2time . ' (' . $sixthtide2height . ')</description><link>http://port-tides.com</link></item><item><title>' . date("l", strtotime("+6 days")) . '</title><description>'); }
if ($seventhtide2time == 'ONE--') { $rssoutput .= ($seventhtide1time . ' (' . $seventhtide1height . ')</description><link>http://port-tides.com</link></item></channel></rss>'); }
else { $rssoutput .= ($seventhtide1time . ' (' . $seventhtide1height . ') and ' . $seventhtide2time . ' (' . $seventhtide2height . ')</description><link>http://port-tides.com</link></item></channel></rss>'); }
//echo $output;
$fh = fopen("widgets/tides.rss", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  ftruncate($fh, 0);
  fwrite($fh, "$rssoutput") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "<br/>";
echo "RSS Widget successfully updated";

//Begin Section 9 - update rss email
//Today + Tomorrow;
$tide1time = substr($html, 0, 5);
$tide1height = substr($html, 5, 5);
$output = '<';
$output .= '?xml version="1.0" encoding="UTF-8" ';
$output .= '?';
$output .= '><rss version="2.0"><channel><title>Porthmadog Tide Times</title><link>http://port-tides.com</link><description>Free tidal predictions for Porthmadog</description><item><title>Porthmadog Tide Times</title><link>http://port-tides.com</link><description><![CDATA[';
$output .= ('<style>h3{    padding: 0px;    margin: 0px;}</style><center><table allign="center" border="0" cellpadding="5"><tr><th><h3>' . date("l") . '</h3></th><th><h3>' . date("l", strtotime("+1 days")) . "</h3></th></tr><tr><td>");
$output .= ($tide1time . " (" . $tide1height . ")<br/>");
$tide2time = substr($html, 10, 5);
$tide2height = substr($html, 15, 5);
if ($tide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($tide2time . " (" . $tide2height . ")</td>");
}
$tomorrowtide1time = substr($html, 20, 5);
$tomorrowtide1height = substr($html, 25, 5);
$output .= ("<td>" . $tomorrowtide1time . " (" . $tomorrowtide1height . ")<br/>");
$tomorrowtide2time = substr($html, 30, 5);
$tomorrowtide2height = substr($html, 35, 5);
if ($tomorrowtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($tomorrowtide2time . " (" . $tomorrowtide2height . ")</td>");
}
//3rd + 4th Day;
$thirdtide1time = substr($html, 40, 5);
$thirdtide1height = substr($html, 45, 5);
$output .= ("<tr><th><h3>" . date("l", strtotime("+2 days")) . "</h3></th><th><h3>" . date("l", strtotime("+3 days")) . "</h3></th></tr><tr><td>");
$output .= ($thirdtide1time . " (" . $thirdtide1height . ")<br/>");
$thirdtide2time = substr($html, 50, 5);
$thirdtide2height = substr($html, 55, 5);
if ($thirdtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($thirdtide2time . " (" . $thirdtide2height . ")</td>");
}
$fourthtide1time = substr($html, 60, 5);
$fourthtide1height = substr($html, 65, 5);
$output .= ("<td>" . $fourthtide1time . " (" . $fourthtide1height . ")<br/>");
$fourthtide2time = substr($html, 70, 5);
$fourthtide2height = substr($html, 75, 5);
if ($fourthtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($fourthtide2time . " (" . $fourthtide2height . ")</td>");
}
//5th + 6th Day;
$fifthtide1time = substr($html, 80, 5);
$fifthtide1height = substr($html, 85, 5);
$output .= ("<tr><th><h3>" . date("l", strtotime("+4 days")) . "</h3></th><th><h3>" . date("l", strtotime("+5 days")) . "</h3></th></tr><tr><td>");
$output .= ($fifthtide1time . " (" . $fifthtide1height . ")<br/>");
$fifthtide2time = substr($html, 90, 5);
$fifthtide2height = substr($html, 95, 5);
if ($fifthtide2time == "ONE--") {
$output .= ("</td>");
}
else
{
$output .= ($fifthtide2time . " (" . $fifthtide2height . ")</td>");
}
$sixthtide1time = substr($html, 100, 5);
$sixthtide1height = substr($html, 105, 5);
$output .= ("<td>" . $sixthtide1time . " (" . $sixthtide1height . ")<br/>");
$sixthtide2time = substr($html, 110, 5);
$sixthtide2height = substr($html, 115, 5);
if ($sixthtide2time == "ONE--") {
$output .= ("</td></tr></table>");
}
else
{
$output .= ($sixthtide2time . " (" . $sixthtide2height . ")</td></tr></table>");
}
//7th Day;
$seventhtide1time = substr($html, 120, 5);
$seventhtide1height = substr($html, 125, 5);
$output .= ('<table allign="center" border="0" cellpadding="5"><tr><th><h3>' . date("l", strtotime("+6 days")) . "</h3></th></tr><tr><td>");
$output .= ($seventhtide1time . " (" . $seventhtide1height . ")<br/>");
$seventhtide2time = substr($html, 130, 5);
$seventhtide2height = substr($html, 135, 5);
if ($seventhtide2time == "ONE--") {
$output .= ("</td></tr></table>");
}
else
{
$output .= ($seventhtide2time . " (" . $seventhtide2height . ")</td><tr></table>");
}
//Closing Tags;
$output .= ("</center>]]></description></item></channel></rss>");
//echo $output;
$fh = fopen("email.rss", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
  ftruncate($fh, 0);
  fwrite($fh, "$output") or failmsg();
	flock($fh, LOCK_UN);
}
fclose($fh);
echo "<br />RSS Email successfully updated";
$output = '';
$fh = fopen("errormessage.html", 'r+') or failmsg();
if (flock($fh, LOCK_EX))
{
    ftruncate($fh, 0);
    fwrite($fh, "$output") or failmsg();
    flock($fh, LOCK_UN);
}
fclose($fh);
?>