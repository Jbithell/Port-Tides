<?php
if (isset($_GET["help"])) {
	if ($_GET['lang'] == 'cy' or isset($_GET['cy'])) {
		echo '<title>Port Tides Cymorth a Chyswllt</title><h1>Port-Tides.com Cymorth</h1><p>I gysylltu &acirc;\'n t&icirc;m cymorth e-bostiwch: <a href="mailto:tides@port-tides.com?Subject=Port-tides.com%20Support%20Request%20(url)">tides@port-tides.com</a>, gan gynnwys y wybodaeth isod <i>(Yn anffodus, nid yw\'n bosibl i gyfieithu gwybodaeth hwn)</i>:<br/><hr/>';
		echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
		echo '<hr/><a href="javascript:window.history.back()">Go Back</a>';
		die();
	} else {
		echo '<title>Port Tides Help & Contact</title><h1>Port-Tides.com Help</h1><p>To contact our support team please E-Mail: <a href="mailto:tides@port-tides.com?Subject=Port-tides.com%20Support%20Request%20(url)">tides@port-tides.com</a>, including the information below:<br/><hr/>';
		echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
		echo '<hr/><a href="javascript:window.history.back()">Go Back</a>';
		die();
	}
}
?>
<?php
//Settings
$adjusted = true;
$sqltablestoringtides = 'porttides_ukho_adjusted';
$lang = 'en'; //en = English & cy = Welsh
if (isset($_GET['cy'])) $lang = 'cy';
//Set to true if times are adjusted for GMT/BST!
//End Settings


//Open SQL Connection
require_once 'login.php';
date_default_timezone_set('Europe/London');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
	die(($lang == 'en' ? "SQL Connection Error" : "Gwall Cysylltiad SQL"));
} 
?>

<!DOCTYPE html>
<html lang="<?php echo ($lang == 'en' ? "en" : "cy"); ?>" xml:lang="<?php echo ($lang == 'en' ? "en" : "cy"); ?>">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Free Tidal Predictions for the Seaside Town of Porthmadog and its beautiful estuary.">
		<meta name="author" content="James Bithell">
		<title><?php echo ($lang == 'en' ? "Porthmadog Tide Times" : "Tide Amseroedd Porthmadog") ?></title>
		
		<!--Bootstrap-->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom Fonts -->
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" >
		<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
		
		<!--Jquery--->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		
		<!--Backstrech - Background Slide Show-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
		<!-- Link for extension -->
		<link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/ogjgofppefhhffefpehhjefihihihinb">
		<script>
		  // Ensure that the DOM has fully loaded
		  document.addEventListener('DOMContentLoaded', function() {
			// Support other browsers
			var chrome = window.chrome || {};
			if (chrome.app && chrome.webstore) {
			  // Fetch all install links
			  var links = document.querySelectorAll('.js-chrome-install');
			  // Create "click" event listener
			  var onClick = function(e) {
				var that = this;
				// Attempt to install the extension/app
				chrome.webstore.install(that.href, function() {
				  // Change the state of the button
				  that.classList.remove('js-chrome-install');
				  // Prevent any further clicks from attempting an install
				  that.removeEventListener('click', onClick);
				});
				// Prevent the opening of the Web Store page
				e.preventDefault();
			  };
			  // Bind "click" event listener to links
			  for (var i = 0; i < links.length; i++) {
				links[i].addEventListener('click', onClick);
			  }
			}
		  });
		</script>
		<?php
		$backgrounds=array(array("img/backgrounds/harbour.jpg",'By Skinsmoke (Own work) [<a href="https://creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a> or <a href="https://www.gnu.org/copyleft/fdl.html">GFDL</a>], <a href="https://commons.wikimedia.org/wiki/File%3APorthmadog_-_Harbour.JPG">via Wikimedia Commons</a>'),
		array("img/backgrounds/Blanche_at_Harbour_Station.JPG", 'By Skinsmoke (Own work) [<a href="http://creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a> or <a href="http://www.gnu.org/copyleft/fdl.html">GFDL</a>], <a href="http://commons.wikimedia.org/wiki/File%3APorthmadog_-_Blanche_at_Harbour_Station.JPG">via Wikimedia Commons</a>')
		,array("img/backgrounds/Afon_Glaslyn.jpg",'OLU [<a href="http://creativecommons.org/licenses/by-sa/2.0">CC BY-SA 2.0</a>], <a href="http://commons.wikimedia.org/wiki/File%3AAfon_Glaslyn_-_geograph.org.uk_-_221533.jpg">via Wikimedia Commons</a>')
		,array('img/backgrounds/Black_Rock_Sands.JPG','By DanielR235 (Own work) [<a href="http://creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a>], <a href="http://commons.wikimedia.org/wiki/File%3ABlack_Rock_Sands.JPG">via Wikimedia Commons</a>')
		,array('img/backgrounds/Cei_Ballast.jpg','David Medcalf [<a href="http://creativecommons.org/licenses/by-sa/2.0">CC BY-SA 2.0</a>], <a href="http://commons.wikimedia.org/wiki/File%3ACei_Ballast%2C_Porthmadog_-_geograph.org.uk_-_84796.jpg">via Wikimedia Commons</a>')
		,array('img/backgrounds/PorthmadogLB09.JPG','By Lesbardd (Own work) [<a href="http://creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a>], <a href="http://commons.wikimedia.org/wiki/File%3APorthmadogLB09.JPG">via Wikimedia Commons</a>')
		,array('img/backgrounds/PorthmadogLB15.JPG','By Lesbardd (Own work) [<a href="http://creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a>], <a href="http://commons.wikimedia.org/wiki/File%3APorthmadogLB15.JPG">via Wikimedia Commons</a>')
		,array('img/backgrounds/PorthmadogLB17.JPG','By Lesbardd (Own work) [<a href="http://creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a>], <a href="http://commons.wikimedia.org/wiki/File%3APorthmadogLB17.JPG">via Wikimedia Commons</a>')
		);
		?>
		<script>
		$( document ).ready(function() {
			$.backstretch([<?php
				shuffle($backgrounds);
				for($x = 0; $x < count($backgrounds); $x++) {
				echo '"';
				echo $backgrounds[$x][0];
				echo '"';
				if (count($backgrounds) -1 != $x) echo ",";
			}
			?>
			  ], {duration: 4500, fade: 1000});
		});
		</script>
		
		<!--Custom CSS-->
		<style>
			.modal-dialog {
				color: black;
			}
			body {
				/*background-image: url("img/backgrounds/harbour.jpg");*/
				background-repeat: no-repeat;
				background-size:cover;
			}
			.box {
				margin-top: 15px;
				margin-bottom: 15px;
				background-color: white;
				color: black;
				opacity: 0.8;
			}
			a:link {
				color: black;
			}
			a:visited {
				color: black;
			}
			a:hover {
				color: black;
			}
			a:active {
				color: black;
			}
			.footer {
				width: 100%;
				padding-top: 2px;
				padding-right: 5px;
				padding-bottom: 2px;
				padding-left: 5px;
			}
		</style>
	</head>
	<body>
		<?php
		//Announcements system!
		// Create connection
		$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		// Check connection
		
		if ($conn->connect_error) {
		die("Connection failed, please contact support");
		}
		$sql = "SELECT * FROM porttides_announcements WHERE visible=1";
		$result = $conn->query($sql);
		if (!$result) {
			die('Invalid query: ' . mysqli_error($conn));
		}
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo '<div class="alert alert-danger alert-dismissable"  style="margin-bottom: 0px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . ($lang == 'en' ? $row["text"] : $row["wtext"]) . ' ' . (empty($row["linktext"]) ? null : '<a href="' . $row["linkurl"] . '?lang=' . $lang . '" class="alert-link">' . ($lang == 'en' ? $row["linktext"] : $row["wlinktext"]). '</a>') . '</div>';
			}
		}
		?>
	<div class="container">
		<div id="box" class="box">
            <div class="row">
                <div class="col-lg-12">
					<center>
						<table border="0" style="width: 100%;"><tr style="width: 100%;"><td style="width: 100%;"><center><h1><?php echo ($lang == 'en' ? "Porthmadog Tide Times" : "Tide Amseroedd Porthmadog"); ?></h1></center></td><!--<td style="padding: 0px;"><a href="<?php echo ($lang == 'en' ? "?cy" : "/") ?>"><img id="langtoggle" src="<?php echo ($lang == 'en' ? "welsh.png" : "eng.png") ?>" title="<?php echo ($lang == 'en' ? "View in Welsh" : "View in English"); ?>" style="height: 30px"></a></td>--></tr></table>
						<h3><?php echo ($lang == 'en' ? "<i>Free</i> Tidal Predictions for the Seaside Town of Porthmadog and its beautiful estuary." : "Rhagfynegiadau llanw <i>am ddim</i> i Lan y Môr Tref Porthmadog ac mae'n aber hardd.") ?></h3>
						<?php
						//Get tide Times for Today
						$sql = "SELECT * FROM " . $sqltablestoringtides . " WHERE date = '" . date('Y-m-d') . "'";
						$result = $conn->query($sql);
						$daylightsavingmessage = false;
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								if (date("I") == 1) $daylightsavingmessage = true;
								if ($row["tide1time"] != 'ONE--') echo "<h4>" . ($lang == 'en' ? "High tides today are at " : "Llanw uchel heddiw mewn ") . $row["tide1time"]."&nbsp;(".$row["tide1height"]."m) &amp; ".$row["tide2time"]."&nbsp;(".$row["tide2height"]."m)";
								else echo "<h4>" . ($lang == 'en' ? "High tide today is at " : "Llanw uchel heddiw ar ") . $row["tide2time"]."&nbsp;(".$row["tide2height"]."m)";
								if ($daylightsavingmessage and !$adjusted) echo ($lang == 'en' ? ' - Not Adjusted for BST' : " - Heb ei addasu ar gyfer BST");
								echo "</h4>";
							}}
                        ?>
					</center>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<center>
                        <ul class="list-inline"><!--style="background-color: rgba(126,177,224,0.3);">-->	
                            <?php
                            $sql = "SELECT * FROM " . $sqltablestoringtides . " WHERE date BETWEEN '" . date('Y-m-d', strtotime("+1 day")) . "' AND '" . date('Y-m-d', strtotime("+7 days"))  . "'";
							$result = $conn->query($sql);
							$daylightsavingmessage = false;
							$counter = 1;
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo "<li><center><h4>";
									echo date("l", strtotime("+" . $counter . " days")); 
									if (date("I", strtotime("+" . $counter . " days")) == 1) $daylightsavingmessage = true;
									echo '</h4><p>';
									if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"]."m)<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")</p></center></li>";
									else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"]."m)</p></center></li>";
									$counter ++;
								}
							}
                            ?>
                        </ul>
                    </center>
				</div>
				
				<div class="col-lg-12">
					<center>
						<h2><?php echo ($lang == 'en' ? 'Monthly Tide Tables' : "Tablau Llanw Misol"); ?></h2>
						<?php
						$sql = "SELECT DISTINCT month(date), year(date) FROM `" . $sqltablestoringtides . "`";
						$result = $conn->query($sql);
						
						$counter = 0;
						$modals = array();
						$currentyear = null;//Initialize empty variable
						if ($result->num_rows > 0) {
							echo '<div class="col-lg-12"><center>';
							while($row = $result->fetch_assoc()) {
								if ($currentyear != $row["year(date)"] and $counter != 0) echo '</center></div><div class="col-lg-12"><center>';
								$currentyear = $row["year(date)"];
								
								$dateObj   = DateTime::createFromFormat('!m', $row["month(date)"]);
								//echo '<button type="button" class="btn btn-default" id="showmonth-month=' . $row["month(date)"] . '&year=' . $row["year(date)"] . '">' . $dateObj->format('F') . " " . $row["year(date)"] . '</button>';
								$modalname = 'modal' . $row["month(date)"] . $row["year(date)"];
								array_push($modals,$modalname);
								echo '<button type="button" style="opacity: 1;" class="btn btn-default" id="showmonth-month=' . $row["month(date)"] . '&year=' . $row["year(date)"] . '" data-toggle="modal" data-target="#' . $modalname . '" data-remote="https://port-tides.com/tidetables/popuphtml.php?month=' . $row["month(date)"] . '&year=' . $row["year(date)"] . '&lang=' . $lang . '">' . $dateObj->format('F') . " " . $row["year(date)"] . '</button>';
								
								if (($row["month(date)"]) == (date('m')-1) and ($row["year(date)"] -1) == date('Y')) break;//Do not display more than 12 months of data
								
								$counter ++;
							}
							echo '</center></div>';
						}
						?>
					</center>
				</div>
				<div class="col-lg-12">
					<center>
						<h2><?php echo ($lang == 'en' ? 'Mobile Apps' : "Ceisiadau"); ?></h2>
						<ul class="list-inline intro-social-buttons">
							<li>
								<a href="https://play.google.com/store/apps/details?id=com.PortTides"><img src="img\appbadges\googleplay.png" style="height: 45px;" alt="Android App on Google Play" /></a>
							</li>
							<li>
								<a href="https://www.windowsphone.com/s?appid=3a9d6921-f974-4a16-afba-2c4344625417"><img src="img\appbadges\windowsphone2.png" style="height: 45px;" alt="Available for Windows Phone" /></a>
							</li>
							<li>
								<a href="https://www.amazon.co.uk/Bithell-Studios-Porthmadog-Tide-Times/dp/B00M66E79G/"><img src="img\appbadges\amazon.png" style="height: 45px;" alt="Android App on Amazon" /></a>
							</li>
							<li>
								<a href="https://chrome.google.com/webstore/detail/ogjgofppefhhffefpehhjefihihihinb" class="js-chrome-install"><img src="img\appbadges\chrome.png" style="height: 45px;" alt="Available for Google Chrome as an Extension" /></a>
							</li>
						</ul>
					</center>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<hr/>
					<div class="footer" id="footer">
						<div style="text-align: left">
							<?php if ($lang == 'en') {
								echo '<span style="font-weight: bold;">Copyright Information:</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department. Website &copy;' . date('Y') . ' James Bithell<br/>';
								echo '<span style="font-weight: bold;">Disclaimer:</span> Tidal Predictions are provided for use by all water users though the developers of this site can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.<br/>';
								if (!$adjusted) echo '<span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT and are not adjusted for BST';
								else echo '<span style="font-weight: bold;">Time Zone Information: </span>All Tidal Predictions above are displayed in GMT/BST.';
								echo '<div style="text-align: right">[<a href="?cy">Cymraeg</a>] [<a href="javascript:void(0);" onclick="photoinfo();">Background Photograph Information</a>] [<a href="?help">Help &amp; Contact</a>]</div>';
							} else {
								echo '<span style="font-weight: bold;">Copyright Information (Mae ein trwydded yn gofyn i ni arddangos gwybodaeth hawlfraint yn Saesneg - Felly mae\'n cael ei arddangos yma yn Gymraeg a Saesneg):</span> All Tidal Data is &copy;Crown Copyright. Reproduced by permission of the Controller of Her Majesty\'s Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the ukho licencing department. Website &copy;' . date('Y') . ' James Bithell<br/>';
								echo '<span style="font-weight: bold;">Disclaimer (Ymwadiad harddangos yma yn Gymraeg a Saesneg):</span> Tidal Predictions are provided for use by all water users though the developers of this site can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.<br/>';
								
								echo '<span style="font-weight: bold;">Gwybodaeth Hawlfraint:</span> Data Pob Tidal yw &copy;Hawlfraint y Goron. Atgynhyrchwyd gyda chaniatâd Rheolwr Llyfrfa Ei Mawrhydi a\'r Swyddfa Hydrograffig y Deyrnas Unedig (www.ukho.gov.uk). Ni chaiff unrhyw ddata y llanw gael ei atgynhyrchu heb ganiatâd penodol yr adran drwyddedu UKHO. Gwefan &copy;' . date('Y') . ' James Bithell<br/>';
								echo '<span style="font-weight: bold;">Ymwadiad:</span> Rhagfynegiadau Llanw eu darparu ar gyfer eu defnyddio gan bob defnyddiwr dŵr er na all y datblygwyr y safle hwn yn cael ei gynnal yn atebol am gywirdeb y data hwn neu unrhyw ddamweiniau sy\'n deillio o ddefnyddio\'r data hwn.<br/>';
								if (!$adjusted) echo '<span style="font-weight: bold;">Parth Amser Gwybodaeth: </span>Pob Rhagfynegiadau Llanw uchod yn cael eu harddangos yn GMT ac nid yn cael eu haddasu ar gyfer BST.';
								else echo '<span style="font-weight: bold;">Parth Amser Gwybodaeth: </span>Pob Rhagfynegiadau Llanw uchod yn cael eu harddangos yn GMT/BST.';
								echo '<div style="text-align: right">[<a href="?en">English</a>] [<a href="javascript:void(0);" onclick="photoinfo();">Gwybodaeth Gefndir Llun</a>] [<a href="?help&lang=cy">Help a Chyswllt</a>]</div>';
							}
							?>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
		</div>
		
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js"></script>
		<?php
		$message = '<table border="0" padding="20px">';
		for($x = 0; $x < count($backgrounds); $x++) {
				$message .= '<tr><td><img src="';
				$message .= $backgrounds[$x][0];
				$message .= '" height="100px" width="100px" /></td><td>';
				$message .= $backgrounds[$x][1];
				$message .= '</td></tr>';
		}
		$message .= '</table><br/><a href="http://srobbin.com/jquery-plugins/backstretch/">' . ($lang == 'en' ? "Background Slideshow by Scott Robbin" : "Sioe sleidiau Cefndir gan Scott Robbin") . '</a>';
		?>
		<script>
		//Photograph Information
		function photoinfo() {
			bootbox.dialog({
			  title: "<?php echo ($lang == 'en' ? "Background Photograph Information" : "Gwybodaeth Gefndir Llun") ?>",
			  message: '<?php echo $message; ?>'
			});
		}
		</script>
		<?php
		for($x = 0; $x < count($modals); $x++) {
			echo '<div class="modal fade" id="' . $modals[$x] . '" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
				  <div class="modal-dialog modal-lg">
					<div class="modal-content">
					</div>
				  </div>
				</div>';
		}
		?>
		<!--Gooogle Analytics Tracking Code-->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-60502159-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>
<?php						
$conn->close();
?>