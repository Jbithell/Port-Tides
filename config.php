<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/


$PROJECT = 4;
require_once __DIR__ . "/../../../config.php";
$MAXDISPLAY = 365; //The maximum number of days to display (due to licence)
$SQLTIDESTABLE = "porttides_ukho_adjusted";
/*
To get this to work you need to install the welsh language pack
Works on Ubuntu:
sudo locale-gen cy_GB
sudo locale-gen cy_GB.UTF-8
sudo update-locale
locale -a
*/
?>
