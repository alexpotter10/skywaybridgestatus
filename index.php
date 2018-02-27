<?php 

require 'fetch-status-data.php';
require 'fetch-weather-data.php';
require 'fetch-planned-closures.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Skyway Bridge Status | Is the Sunshine Skyway Bridge open?</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="sunshine skyway bridge, sunshine skyway bridge, skyway bridge, skyway bridge status, skyway bridge closure, sunshine skyway, skyway bridge closed, is the skyway bridge closed, sunshine skyway bridge closure, sunshine skyway bridge closed, skyway bridge open or closed, skyway bridge news, skyway bridge traffic, skyway bridge crash, sunshine skyway bridge open">
    <meta name="Description" content="Want to know if the Sunshine Skyway Bridge is open or closed? You've come to the right place! We pull and report the Skyway Bridge status every 5 minutes.">
    <link rel="canonical" href="https://www.skywaybridgestatus.com" />
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://use.fontawesome.com/d726da7372.js"></script>
    <!-- GOOGLE ANALYTICS -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-101848302-1', 'auto');
    ga('send', 'pageview');

    </script>
</head>
<body>

<div class="header">
    <div class="container">
        <div class="navbar row">
            <div class="navbar__logo col-6">
                Skyway Bridge Status
            </div>
            <div class="navbar__navigation col-6">
                <a href="mailto:info@skywaybridgestatus.com" title="Contact" alt="Contact Link">Contact</a>
            </div>
        </div>
    </div>
</div>

<div class="main">
    <div class="container">

        <section class="status row">
            <div class="status__header col-12">
                <h1>The Sunshine Skyway Bridge is currently 
                <br/>
                <span class="status--<?php echo $global_status_modifier;?>"><?php echo $global_status_string;?></span></h1>
                <p><a href=".">Refresh this page</a> for the latest data.</p>
                <p class="status__data-refreshed">(Data last refreshed: <?php echo date_format($fetch_datetime,'F jS, Y \a\t g:ia');?>)</p>
            </div>
        </section>

        <section class="announcements col-12">
            <div class="announcements-box">
                <?php
                // Pull announcement information
                for ($row = 0; $row < 1; $row++) {
                // Store new date variables
                $start_date = date_create($planned_closure[$row]["start_datetime"]);
                $end_date = date_create($planned_closure[$row]["end_datetime"]);
                // Display announcement
                echo "<b>PLANNED CLOSURE ALERT:</b> ".$planned_closure[$row]["closed_direction"]." traffic on the Skyway Bridge will be suspended from ".date_format($start_date,'g:ia \o\n l F jS, Y')." to ".date_format($end_date,'g:ia \o\n l F jS, Y')." for ".$planned_closure[$row]["reason"].".";
                    // Display URL if field is not null
                    if (isset($planned_closure[$row]["url"])) {
                        echo " <a href=\"".$planned_closure[$row]["url"]."\">Learn more.</a>";
                    }
                }
                ?>
            </div>
        </section>

        <section class="data-sources row">
            <div class="data-sources__status col-6">
                <h2>Status by Data Source</h2>
                <div class="status-source"><!-- FL511 ALERTS -->
                    <img class="status-source__image" src="assets/img/fl511-logo.png" title="FL511 Traffic and Commuter Information" alt="FL511 logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--<?php echo $fl511_status_modifier;?>"><?php echo $fl511_status_string;?></span>
                        <br/>
                        <a href="https://fl511.com/List/Alerts" title="fl511.com Alerts Page" alt="Link to fl511.com alerts page" target="_new">Get more info on fl511.com ></a>
                    </div>
                </div>
                <div class="status-source"><!-- FLHSMV LIVE FEED -->
                    <img class="status-source__image" src="assets/img/flhsmv-logo.png" title="Florida Department of Highway Stafety and Motor Vehicles" alt="FLHSMV Logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--error">Data coming soon</span>
                        <br/>
                        <a href="https://flhsmv.gov/fhp/traffic/live_traffic_feed.html" title="flhsmv.gov Live Traffic Feed" alt="Link to flhsmv.gov live traffic page" target="_new">Get more info on flhsmv.gov ></a>
                    </div>
                </div>
                <div class="status-source"><!-- FDOT MYTBI -->
                    <img class="status-source__image" src="assets/img/fdot-logo.png" title="FL511 Traffic and Commuter Information" alt="FL511 logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--error">Data coming soon</span>
                        <br/>
                        <a href="http://www.mytbi.com/projects/projects.asp?roadID=9" title="mytbi.com Skyway Page" alt="Link to mytbi.com Skyway page" target="_new">Get more info on mytbi.com ></a>
                    </div>
                </div>
            </div>
            <div class="data-sources__weather col-6">
                <h2>Current Weather from <img src="assets/img/wunderground-logo.png" /></h2>
                
                <?php
                for ($row = 0; $row < 2; $row++) {
                echo "<div class=\"weather-source\">";
                echo "<h3>".$weather_logs[$row]["name"]."</h3>";
                echo "<ul>";
                echo "<li>Current Conditions: ".$weather_logs[$row]["temp_f"]."ºF and ".$weather_logs[$row]["weather"]."</li>";
                echo "<li>Wind: ".$weather_logs[$row]["wind_mph"]." MPH from the ".$weather_logs[$row]["wind_dir"]."</li>";
                echo "<li>Visibility: ".$weather_logs[$row]["visibility_mi"]." Miles</li>";
                echo "</ul>";
                echo "</div>";
                }
                ?>

            </div>
        </section>

        <section class="project-information row">
            <div class="project-information__about col-8">
                <h2>About this Project</h2>
                <p>SkywayBridgeStatus.com is an open-source initiative aimed at helping Tampa Bay commuters plan for unexpected closures of the Sunshine Skyway Bridge. We are actively collecting real-time weather and traffic data from reputable sources, and our intent is to use that historical data to create a closure prediction model, which will be publicly available to Tampa regional commuters.</p>
            </div>
            <div class="project-information__contribute col-4">
                <h2>Contribute</h2>
                <p>We’re always looking for great contributors and sponsors. If you’re interested in contributing to this project, please visit our <a href="https://github.com/SkywayBridgeStatus">GitHub page</a>, or <a href="mailto:contribute@skywaybridgestatus.com">email us</a>.</p>
            </div>
        </section>

        <section class="footer row">
            <div class="footer__copyright center col-12">
                <p>SkywayBridgeStatus.com &copy; <?php echo date('Y');?> <a href="http://www.iannerney.com">Ian Nerney</a></p>
                <p>This project is available for use and modification under the <a href="/LICENSE">MIT License</a>.</p>
                <ul class="footer__social-icons">
                    <a href="https://twitter.com/SkywayStatus" title="Skyway Bridge Status on Twitter" alt="Skyway Bridge Status Twitter link"><li class="fa fa-twitter-square" aria-hidden="true"></li></a>
                    <a href="https://github.com/SkywayBridgeStatus" title="Skyway Bridge Status on GitHub" alt="Skyway Bridge Status GitHub link"><li class="fa fa-github-square" aria-hidden="true"></li></a>
                <ul>    
            </div>
        </section>
    </div>
</div>
</body>
</html>