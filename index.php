<?php
require_once __DIR__ . "/config.php";
//First released by James Bithell 30 June 2014
if (isset($_GET['lang']) and $_GET['lang'] == "cy") $WELSH = true;
else $WELSH = false;

$APIURL = "//port-tides.com/api/v3/";
if ($WELSH) $APIAPPEND = "lang=cy";
else $APIAPPEND = "lang=en";


//TODO Refactor
$backgrounds=array(array("img/backgrounds/harbour.jpg",'By Skinsmoke (Own work) [<a href="//creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a> or <a href="//www.gnu.org/copyleft/fdl.html">GFDL</a>], <a href="//commons.wikimedia.org/wiki/File%3APorthmadog_-_Harbour.JPG">via Wikimedia Commons</a>'),
array("img/backgrounds/Blanche_at_Harbour_Station.JPG", 'By Skinsmoke (Own work) [<a href="//creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a> or <a href="//www.gnu.org/copyleft/fdl.html">GFDL</a>], <a href="//commons.wikimedia.org/wiki/File%3APorthmadog_-_Blanche_at_Harbour_Station.JPG">via Wikimedia Commons</a>')
,array("img/backgrounds/Afon_Glaslyn.jpg",'OLU [<a href="//creativecommons.org/licenses/by-sa/2.0">CC BY-SA 2.0</a>], <a href="//commons.wikimedia.org/wiki/File%3AAfon_Glaslyn_-_geograph.org.uk_-_221533.jpg">via Wikimedia Commons</a>')
,array('img/backgrounds/Black_Rock_Sands.JPG','By DanielR235 (Own work) [<a href="//creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a>], <a href="//commons.wikimedia.org/wiki/File%3ABlack_Rock_Sands.JPG">via Wikimedia Commons</a>')
,array('img/backgrounds/Cei_Ballast.jpg','David Medcalf [<a href="//creativecommons.org/licenses/by-sa/2.0">CC BY-SA 2.0</a>], <a href="//commons.wikimedia.org/wiki/File%3ACei_Ballast%2C_Porthmadog_-_geograph.org.uk_-_84796.jpg">via Wikimedia Commons</a>')
,array('img/backgrounds/PorthmadogLB09.JPG','By Lesbardd (Own work) [<a href="//creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a>], <a href="//commons.wikimedia.org/wiki/File%3APorthmadogLB09.JPG">via Wikimedia Commons</a>')
,array('img/backgrounds/PorthmadogLB15.JPG','By Lesbardd (Own work) [<a href="//creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a>], <a href="//commons.wikimedia.org/wiki/File%3APorthmadogLB15.JPG">via Wikimedia Commons</a>')
,array('img/backgrounds/PorthmadogLB17.JPG','By Lesbardd (Own work) [<a href="//creativecommons.org/licenses/by-sa/3.0">CC BY-SA 3.0</a>], <a href="//commons.wikimedia.org/wiki/File%3APorthmadogLB17.JPG">via Wikimedia Commons</a>')
);
?>
<!DOCTYPE html>
<html lang="<?=(!$WELSH ? "en" : "cy")?>" xml:lang="<?=(!$WELSH ? "en" : "cy")?>">
 	<head>
 		<meta charset="utf-8">
 		<meta http-equiv="X-UA-Compatible" content="IE=edge">
 		<meta name="viewport" content="width=device-width, initial-scale=1">
 		<meta name="description" content="Free Tidal Predictions for the Seaside Town of Porthmadog and its beautiful estuary.">
 		<meta name="author" content="James Bithell">
 		<title>Porthmadog Tide Times</title>

		<!--Jquery--->
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>

 		<!--Bootstrap-->
 		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous" />
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>

 		<!-- Custom Fonts -->
 		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" integrity="sha256-AIodEDkC8V/bHBkfyxzolUMw57jeQ9CauwhVW6YJ9CA=" crossorigin="anonymous" />
 		<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">


 		<!--Backstrech - Background Slide Show-->
 		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js" integrity="sha256-V52dl3OFjoY+fYAkifhLJ7f1V7mZAKPGCQoWzoQxrEU=" crossorigin="anonymous"></script>

		<!--Bootbox-->
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js" integrity="sha256-4F7e4JsAJyLUdpP7Q8Sah866jCOhv72zU5E8lIRER4w=" crossorigin="anonymous"></script>

 		<!-- Link for extension -->
 		<link rel="chrome-webstore-item" href="//chrome.google.com/webstore/detail/ogjgofppefhhffefpehhjefihihihinb">
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
		<!--End Chrome Extension Stuff-->
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
 			?>], {duration: 4500, fade: 1000});
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
		<!--Google AdSense-->
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-3867183390021876",
    enable_page_level_ads: true
  });
</script>
		<!--End Google AdSense-->

 	</head>
 	<body>
 	<div class="container">
 		<div id="box" class="box" style="text-align: center">
			 <div class="row">
				 <div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<center>
								<h1>
									<?=($WELSH ? "Tide Amseroedd Porthmadog" : "Porthmadog Tide Times")?>
								</h1>
							</center>
						</div>
					</div>
 					<h3><?=(!$WELSH ? "<i>Free</i> Tidal Predictions for the Seaside Town of Porthmadog and its beautiful estuary." : "Rhagfynegiadau llanw <i>am ddim</i> i Lan y Môr Tref Porthmadog ac mae'n aber hardd.")?></h3>
 				</div>
 			</div>
 			<div class="row">
 				<div class="col-lg-12">
 					<center>
						 <ul class="list-inline" id="next7daystides">
						 </ul>
					 </center>
 				</div>

 				<div class="col-lg-12">
					<center><h2><?=(!$WELSH ? 'Monthly Tide Tables' : "Tablau Llanw Misol")?></h2></center>
 					<center id="monthspdftides">

 					</center>
 				</div>
 				<div class="col-lg-12">
 					<center>
 						<!--<h2><?=(!$WELSH ? 'Mobile Apps' : "Ceisiadau")?></h2>
 						<ul class="list-inline intro-social-buttons">
 							<li>
 								<a href="//play.google.com/store/apps/details?id=com.PortTides"><img src="img\appbadges\googleplay.png" style="height: 45px;" alt="Android App on Google Play" /></a>
 							</li>-->
 							<!--<li>
 								<a href="//www.windowsphone.com/s?appid=3a9d6921-f974-4a16-afba-2c4344625417"><img src="img\appbadges\windowsphone2.png" style="height: 45px;" alt="Available for Windows Phone" /></a>
 							</li>-->
 							<!--<li>
 								<a href="//www.amazon.co.uk/Bithell-Studios-Porthmadog-Tide-Times/dp/B00M66E79G/"><img src="img\appbadges\amazon.png" style="height: 45px;" alt="Android App on Amazon" /></a>
 							</li>
 							<li>
 								<a href="//chrome.google.com/webstore/detail/ogjgofppefhhffefpehhjefihihihinb" class="js-chrome-install"><img src="img\appbadges\chrome.png" style="height: 45px;" alt="Available for Google Chrome as an Extension" /></a>
 							</li>
 						</ul>-->
            <!--Ads cant be displayed due to licence restrictions-->
            <!--<br/><br/><div style="text-align: right; width: 100% padding-left: 10px; padding-right: 20px; ">
              <i><a href="https://blog.jbithell.com/ads-on-my-sites/">Why the Ads?</a></i>
            </div>-->
 					</center>
 				</div>
 			</div>
 			<div class="row">
 				<div class="col-lg-12">
 					<hr/>
 					<div class="footer" id="footer">
 						<div style="text-align: left" id="copyright">

 						</div>
						<div style="text-align: right">[<a href="?<?=($WELSH ? 'lang=en' : "lang=cy")?>"><?=($WELSH ? 'English' : "Cymraeg")?></a>] [<a href="//weather.port-tides.com"><?=($WELSH ? 'Tywydd Byw Porthmadog' : "Porthmadog Live Weather")?></a>] [<a href="javascript:void(0);" onclick="photoinfo();"><?=(!$WELSH ? 'Background Photograph Information' : "Gwybodaeth Gefndir Llun")?></a>] [<a href="javascript:void(0);" onclick="helpinfobox();"><?=(!$WELSH ? 'Help &amp; Contact' : "Help a Chyswllt")?></a>]</div>
 					</div>
 				</div>
 			</div>
 		</div>
						
		<!--Tidal Data-->
		<script>
		<?=(!isset($_GET['debug']) ? 'console.log = function() {} ' . "\n\n" : '')?>
		$.ajax({
			url: '<?=$APIURL?>predictions?<?=$APIAPPEND?>&format=json',
			cache : false,
			success: function (result) {
				output = "";
				$.each(result, function( index, value ) {
					output += ("<li><center><h4>" + value.DAYNAME + "</h4><p>");
					$.each(value.TIDES, function( index, value ) {
						output += (value.TIME + "(" + value.HEIGHT + "m) <br/>");
					});

					if (Object.keys(value.TIDES).length <2) output += "<br/>"; //It just makes it a bit prettier

					output += ("</p></center></li>");
				});
				$("#next7daystides").html(output);
				console.log(result);
			}, error: function(jqXHR, textStatus, errorThrown) {
				console.log("Connection Error");
				bootbox.alert("We seem to have some trouble connecting to the Port-Tides network - please check you're internet connection and try again");
			}
		});
		$.ajax({
			url: '<?=$APIURL?>predictions/monthlyavailability/?<?=$APIAPPEND?>',
			cache : false,
			success: function (result) {
				output = "";
				$.each(result, function( index, value ) {
					output += ('<a style="opacity: 1;" class="btn btn-default" href="<?=$APIURL?>predictions/?<?=$APIAPPEND?>&format=pdf&month=' + value.MONTH + '&year=' + value.YEAR + '">' + value.MONTHNAME + " " + value.YEAR + '</a>');
				});
				$("#monthspdftides").html(output);
				console.log(result);
			}, error: function(jqXHR, textStatus, errorThrown) {
				console.log("Connection Error");
				bootbox.alert("We seem to have some trouble connecting to the Port-Tides network - please check you're internet connection and try again");
			}
		});
		$.ajax({
			url: '<?=$APIURL?>copyright?<?=$APIAPPEND?>',
			cache : false,
			success: function (result) {
				output = "";
				$.each(result, function( index, value ) {
					output += ('<span style="font-weight: bold;">' + index + ':</span> ' + value + '<br/>');
				});
				$("#copyright").html(output);
				console.log(result);
			}, error: function(jqXHR, textStatus, errorThrown) {
				console.log("Connection Error");
				bootbox.alert("We seem to have some trouble connecting to the Port-Tides network - please check you're internet connection and try again");
			}
		});
		var helpinfo = "Sorry we encountered a serious error - please try again later";
		$.ajax({
			url: '<?=$APIURL?>contact?<?=$APIAPPEND?>',
			cache : false,
			success: function (result) {
				helpinfo = result;
			}, error: function(jqXHR, textStatus, errorThrown) {
				console.log("Connection Error");
				bootbox.alert("We seem to have some trouble connecting to the Port-Tides network - please check you're internet connection and try again");
			}
		});
		function helpinfobox() {
			bootbox.alert(helpinfo);
		}
		</script>


 		<?php
 		$message = '<table border="0" padding="20px">';
 		for($x = 0; $x < count($backgrounds); $x++) {
 				$message .= '<tr><td><img src="';
 				$message .= $backgrounds[$x][0];
 				$message .= '" height="100px" width="100px" /></td><td>';
 				$message .= $backgrounds[$x][1];
 				$message .= '</td></tr>';
 		}
 		$message .= '</table><br/><a href="//srobbin.com/jquery-plugins/backstretch/">' . (!$WELSH ? "Background Slideshow by Scott Robbin" : "Sioe sleidiau Cefndir gan Scott Robbin") . '</a>';
 		?>
 		<script>
 		//Photograph Information
 		function photoinfo() {
 			bootbox.dialog({
 			  title: "<?=(!$WELSH ? "Background Photograph Information" : "Gwybodaeth Gefndir Llun")?>",
 			  message: '<?=$message?>'
 			});
 		}
 		</script>
 		<!--Gooogle Analytics Tracking Code-->
 		<script>
 		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
 		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 		  ga('create', 'UA-60502159-1', 'auto');
 		  ga('send', 'pageview');

 		</script>
	<!--JBITHELL.COM FLEET UPTIME TRACKING-->
	<!--qeGxNE4qjgqHdmGFE2AbcNMG6xFyJ4pSzk4fWQVcH7XmUYhCtj-->
	<!--END JBITHELL.COM FLEET UPTIME TRACKING-->
 	</body>
 </html>
