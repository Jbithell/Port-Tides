<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free Tidal Predictions for the Seaside Town of Porthmadog and its beautiful estuary.">
    <meta name="author" content="James Bithell">

    <title>Porthmadog Tide Times</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://www.port-tides.com">Port Tides</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form method="get" action="tidetables.php" target="_blank">
                <ul class="nav navbar-nav navbar-right">
                <!--<li style="margin-bottom : 2px; margin-top : 2px; vertical-align : text-middle; margin-left : 2px; margin-right : 2px;"><p><i>PDF&nbsp;Tide&nbsp;Tables:&nbsp;</i></p></li>-->
                   <li style="margin-bottom : 2px; margin-top : 2px; margin-left : 2px; margin-right : 2px;">
                        <select class="form-control" name="tidetableselectorforminput" id="tidetableselectorforminput" title='Select month...' style="height: 45px;">
                        
                            <?php
                            require_once 'tidetables/havewegotdata.php';
                            date_default_timezone_set("Europe/London");
                            $counter = 0;
                            $firstadd = true;
                            $currentyear = 0;
                            while($counter <= 11) {
                                $month = date('m', strtotime('+' . $counter . ' months'));
                                $year = date('Y', strtotime('+' . $counter . ' months'));
                                if (havewegotdata($month, $year)) {
                                    if ($currentyear != $year) {
                                    if ($firstadd) {
                                    $firstadd = false;
                                    } else echo '</optgroup>';
                                    $currentyear = $year;
                                    echo ' <optgroup label="' . $year . '">';
                                    }
                                    if ($month == date('m') and $year = date('y')) {
                                        echo '<option selected value="' . $month . $year . '">' . date('F', strtotime('01-' . $month . '-' . $year)) . '</option>';
                                    }
                                    else echo '<option value="' . $month . $year . '">' . date('F', strtotime('01-' . $month . '-' . $year)) . '</option>';
                                }
                                $counter ++;
                            }
                            ?>
                           </optgroup>
                        </select>
                      </li>
                       
                        <li style="margin-bottom : 2px; margin-top : 2px; margin-left : 2px; margin-right : 2px;">
                        <input type="submit" value="Print" name="print" onclick="this.form.action='http://www.port-tides.com/tidetables/redirectsystemforwebforms/print.php'; this.form.submit();" class="btn btn-default btn-lg">
                        </li>
                        <li style="margin-bottom : 2px; margin-top : 2px; margin-left : 2px; margin-right : 2px;">
                        <input type="submit" value="Download" name="download" onclick="this.form.action='http://www.port-tides.com/tidetables/redirectsystemforwebforms/download.php'; this.form.submit();" class="btn btn-default btn-lg">
                        </li>
                        <li style="margin-bottom : 2px; margin-top : 2px; margin-left : 2px; margin-right : 2px;">
                        <input type="submit" value="E-Mail" name="email" onclick="this.form.action='http://www.port-tides.com/tidetables/redirectsystemforwebforms/email.php'; this.form.submit();" class="btn btn-default btn-lg">
                        </li>
                        <!--<li>
                        
                        <script src="https://apis.google.com/js/platform.js" async defer></script>
                        <button style="height: 45px;" id="savetogoogledrive" class="btn btn-default btn-lg" />
                         <script>
                        gapi.savetodrive.render(
savetogoogledrive,
{ "src": ("tidetables.php?tidetableselectorforminput=" + document.getElementById("tidetableselectorforminput").options[document.getElementById("tidetableselectorforminput").selectedIndex].value + "&format=pdf"), "filename": "Porthmadog Tide Times for July 2015.pdf", "sitename": "Porthmadog Tide Times"}
)
</script>

                        
</li>-->
                   
                </ul></form>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header -->
    <div class="intro-header">

        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Porthmadog Tide Times</h1>
                        <h3><i>Free</i> Tidal Predictions for the Seaside Town of Porthmadog and its beautiful estuary.</h3>
                          <?php
                            require_once 'login.php';
                           date_default_timezone_set('Europe/London');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
$sql = "SELECT * FROM ukhoporthmadogdata WHERE date = '" . date('Y-m-d') . "'";
$result = $conn->query($sql);
$daylightsavingmessage = false;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if (date("I") == 1) $daylightsavingmessage = true;
        if ($row["tide1time"] != 'ONE--') echo "<h4>Tides today are at " . $row["tide1time"]."&nbsp;(".$row["tide1height"].") &amp; ".$row["tide2time"]."&nbsp;(".$row["tide2height"].")" . ($daylightsavingmessage ? ' - Not Adjusted for BST' : '') . "</h4>";
        else echo "<h4>Tide today is at " . $row["tide2time"]."&nbsp;(".$row["tide2height"].")" . ($daylightsavingmessage ? ' - Not Adjusted for BST' : '') . "</h4>";
    }}
$conn->close();
                            ?>
                      
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=appinventor.ai_tides.PortTides"><img src="img\appbadges\googleplay.png" style="height: 45px;" alt="Android App on Google Play" /></a><!--<a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>-->
                            </li>

                            <li>
                                <a href="http://www.windowsphone.com/s?appid=3a9d6921-f974-4a16-afba-2c4344625417"><img src="img\appbadges\windowsphone2.png" style="height: 45px;" alt="Available for Windows Phone" /></a>
                            </li>

                            <li>
                                <a href="http://www.amazon.co.uk/Bithell-Studios-Porthmadog-Tide-Times/dp/B00M66E79G/"><img src="img\appbadges\amazon.png" style="height: 45px;" alt="Android App on Amazon" /></a><!--<a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>-->
                            </li>
                            <li>
                                <a href="https://chrome.google.com/webstore/detail/porthmadog-tide-times/ogjgofppefhhffefpehhjefihihihinb?hl=en&gl=GB&authuser=1"><img src="img\appbadges\chrome.png" style="height: 45px;" alt="Available for Google Chrome as an Extension" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <!-- Page Content -->

    <div class="content-section-a">

        <div class="container">

            <div class="row" id="predictions">
                <div class="col-lg-12 col-sm-12">
                    <!--<hr class="section-heading-spacer">-->
                    <div class="clearfix"></div>
                    <center><h2 class="section-heading">Online Tidal Predicitons</h2></center>
                </div>
                <div class="col-lg-12 col-sm-12">
                    <center>
                        <ul class="list-inline">
                            <?php
                            require_once 'login.php';
                           date_default_timezone_set('Europe/London');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// Check connection
if ($conn->connect_error) {
    die("SQL Connection Error");
} 

$sql = "SELECT * FROM ukhoporthmadogdata WHERE date BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d', strtotime("+6 days"))  . "'";
$result = $conn->query($sql);
$daylightsavingmessage = false;
$counter = 0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<li><center><h3>";
        echo date("l", strtotime("+" . $counter . " days")); 
        if (date("I", strtotime("+" . $counter . " days")) == 1) $daylightsavingmessage = true;
        echo '</h3></center><br /><center><p class="lead">';
        if ($row["tide1time"] != 'ONE--') echo $row["tide1time"]."&nbsp;(".$row["tide1height"].")<br />".$row["tide2time"]."&nbsp;(".$row["tide2height"].")</p></center></li>";
        else echo "<br/>" . $row["tide2time"]."&nbsp;(".$row["tide2height"].")</p></center></li>";
        $counter ++;
    }
    
    
}
$conn->close();
                            ?>
                        
                        </ul>
                    </center>
                    <!--If one of the dates shown in BST...-->
                     <hr class="intro-divider">
                       <center><h2>Advance Predictions</h2></center>
                    
                        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
                        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
                        <form method="get" action="tidetables.php" target="_blank">
                        <select class="form-control" name="tidetableselectorforminput" id="tidetableselectorforminput" title='Select month...' data-width="75%">
                        
                            <?php
                            require_once 'tidetables/havewegotdata.php';
                            date_default_timezone_set("Europe/London");
                            $counter = 0;
                            $firstadd = true;
                            $currentyear = 0;
                            while($counter <= 11) {
                                $month = date('m', strtotime('+' . $counter . ' months'));
                                $year = date('Y', strtotime('+' . $counter . ' months'));
                                if (havewegotdata($month, $year)) {
                                    if ($currentyear != $year) {
                                    if ($firstadd) {
                                    $firstadd = false;
                                    } else echo '</optgroup>';
                                    $currentyear = $year;
                                    echo ' <optgroup label="' . $year . '">';
                                    }
                                    if ($month == date('m') and $year = date('y')) {
                                        echo '<option selected value="' . $month . $year . '">' . date('F', strtotime('01-' . $month . '-' . $year)) . '</option>';
                                    }
                                    else echo '<option value="' . $month . $year . '">' . date('F', strtotime('01-' . $month . '-' . $year)) . '</option>';
                                }
                                $counter ++;
                            }
                            ?>
                           </optgroup>
                        </select>
                       <br/>
                        <center><i>For tides beyond the coming week please select a month and year using the box above before clicking a button below!</i></center><br/>
                        <center><ul class="list-inline intro-social-buttons">
                        <li>
                        <input type="submit" value="Print" name="print" onclick="this.form.action='http://www.port-tides.com/tidetables/redirectsystemforwebforms/print.php'; this.form.submit();" class="btn btn-default btn-lg">
                        </li>
                        <li>
                        <input type="submit" value="Download" name="download" onclick="this.form.action='http://www.port-tides.com/tidetables/redirectsystemforwebforms/download.php'; this.form.submit();" class="btn btn-default btn-lg">
                        </li>
                        <li>
                        <input type="submit" value="E-Mail" name="email" onclick="this.form.action='http://www.port-tides.com/tidetables/redirectsystemforwebforms/email.php'; this.form.submit();" class="btn btn-default btn-lg">
                        </li>
                        <!--<li>
                        
                        <script src="https://apis.google.com/js/platform.js" async defer></script>
                        <button style="height: 45px;" id="savetogoogledrive" class="btn btn-default btn-lg" />
                         <script>
                        gapi.savetodrive.render(
savetogoogledrive,
{ "src": ("tidetables.php?tidetableselectorforminput=" + document.getElementById("tidetableselectorforminput").options[document.getElementById("tidetableselectorforminput").selectedIndex].value + "&format=pdf"), "filename": "Porthmadog Tide Times for July 2015.pdf", "sitename": "Porthmadog Tide Times"}
)
</script>

                        
</li>--></ul></center></form>
                    
                    <?php
                    if ($daylightsavingmessage) echo '<center><i class="lead">Tidal Predictions are displayed in GMT and are not adjusted for BST.</i></center>';
                    ?>
                    <hr />
                </div>
                

                    <div class="col-lg-5 col-sm-6">
                        <p class="lead"><b>Disclaimer: </b><i>Tidal Predictions are provided for use by all water users though the developers of this site can not be held accountable for the accuracy of this data or any accidents that result from the use of this data. </i></p>
                    </div>
                    <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                        <p class="lead"><b>Copyright Information:</b><i> All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty’s Stationery Office and the UK Hydrographic Office (<a href="http://www.ukho.gov.uk/">www.ukho.gov.uk</a>). No tidal data may be reproduced without the expressed permission of the ukho licencing department.</i></p>

                    </div>
                </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

    <div class="content-section-b">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                    
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Available as a Chrome Extension</h2>
                    <center><p class="lead">Download from the Google Chrome Store today! </p><a href="https://chrome.google.com/webstore/detail/porthmadog-tide-times/ogjgofppefhhffefpehhjefihihihinb?hl=en&gl=GB&authuser=1"><img src="img\appbadges\chrome.png" style="height: 100px;" alt="Available for Google Chrome as an Extension" /></a></center>
                </div>
                <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                    <img class="img-responsive" src="img/dog.png" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-b -->

    <div class="content-section-a">

        <div class="container">

            <div class="row" id="apps">
                <div class="col-lg-12 col-sm-6">
                   <div class="clearfix"></div>
                    <h2 class="section-heading">Available for <br>Android, Windows Phone &amp; Kindle Fire!</h2>
                    <p class="lead">Download our awesome mobile apps today!</p>
                   </div>
                <!--<div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="img/phones.png" alt="">
                </div>-->

                <style>
                    #downloadappslist {
                        text-align: center;
                    }

                        #downloadappslist ul li {
                            display: inline-block;
                        }
                </style>

                <div class="col-lg-12 col-sm-6" id="downloadappslist">
                    <center>
                        <ul class="list-inline banner-social-buttons">
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=appinventor.ai_tides.PortTides"><img src="img\appbadges\googleplay.png" style="height: 70px;" alt="Android App on Google Play" /></a>
                            </li>

                            <li>
                                <a href="http://www.windowsphone.com/s?appid=3a9d6921-f974-4a16-afba-2c4344625417"><img src="img\appbadges\windowsphone2.png" style="height: 70px;" alt="Available for Windows Phone" /></a>
                            </li>

                            <li>
                                <a href="http://www.amazon.co.uk/Bithell-Studios-Porthmadog-Tide-Times/dp/B00M66E79G/"><img src="img\appbadges\amazon.png" style="height: 70px;" alt="Android App on Amazon" /></a>
                            </li>

                        </ul>
                    </center>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

    <div class="banner">

        <div class="container">

            <div class="row">
                <div class="col-lg-6">
                    <h2>Download Today: </h2>
                </div>
                
                <div class="col-lg-6">
                    <ul class="list-inline banner-social-buttons">
                        <li>
                            <a href="https://play.google.com/store/apps/details?id=appinventor.ai_tides.PortTides"><img src="img\appbadges\googleplay.png" style="height: 45px;" alt="Android App on Google Play" /></a><!--<a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>-->
                        </li>

                        <li>
                            <a href="http://www.windowsphone.com/s?appid=3a9d6921-f974-4a16-afba-2c4344625417"><img src="img\appbadges\windowsphone2.png" style="height: 45px;" alt="Available for Windows Phone" /></a>
                        </li>

                        <li>
                            <a href="http://www.amazon.co.uk/Bithell-Studios-Porthmadog-Tide-Times/dp/B00M66E79G/"><img src="img\appbadges\amazon.png" style="height: 45px;" alt="Android App on Amazon" /></a><!--<a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>-->
                        </li>

                    </ul>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.banner -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!--<ul class="list-inline">
                        <li>
                            <a href="#home">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#about">About</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#services">Services</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li>
                    </ul>
                        -->
                    <center>
                        <p><b>Copyright Information:</b><i> All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty’s Stationery Office and the UK Hydrographic Office (<a href="http://www.ukho.gov.uk/">www.ukho.gov.uk</a>) <a href="licence.html">View Licence</a>. No tidal data may be reproduced without the expressed permission of the ukho licencing department.</i></p>
                    </center>
                    
                   <center> <p class="copyright text-muted small">Website &copy; James Bithell 2014. All Rights Reserved</p></center>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
