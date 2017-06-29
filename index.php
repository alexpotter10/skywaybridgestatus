<?php 

require 'fetch-status-data.php';
require 'fetch-weather-data.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SkywayBridgeStatus.com | Is the Sunshine Skyway Bridge closed?</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="sunshine skyway bridge, sunshine skyway bridge, skyway bridge, skyway bridge status, skyway bridge closure, sunshine skyway, skyway bridge closed, is the skyway bridge closed, sunshine skyway bridge closure, sunshine skyway bridge closed, skyway bridge open or closed, skyway bridge news, skyway bridge traffic, skyway bridge crash, sunshine skyway bridge open">
    <meta name="Description" content="">
    <?php //TODO: ADD DESCRIPTION CONTENT ?>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://use.fontawesome.com/d726da7372.js"></script>
</head>
<body>

<div class="header">
    <div class="container">
        <div class="navbar row">
            <div class="navbar__logo col-4">SkywayBridgeStatus.com</div>
            <div class="navbar__social-icons col-8">
                <ul>
                    <a href="https://twitter.com/SkywayStatus" title="Skyway Bridge Status on Twitter" alt="Skyway Bridge Status Twitter link"><li class="fa fa-twitter-square" aria-hidden="true"></li></a>
                    <a href="#" title="Skyway Bridge Status on GitHub" alt="Skyway Bridge Status GitHub link"><li class="fa fa-github-square" aria-hidden="true"></li></a>
                <ul>    
            </div>
        </div>
    </div>
</div>

<div class="main">
    <div class="container">
        <section class="status row">
            <h1>The Sunshine Skyway Bridge is curently 
            <br/>
            <span class="status--<?php echo $fl511_status_modifier;?>"><?php echo $fl511_status_string;?></span></h1>
            <p><a href=".">Refresh this page</a> for the latest data.</p>
            <p class="status__data-refreshed">(Data last refreshed: <?php echo $fetch_datetime;?>)</p>
        </section>

        <section class="data-sources row">
            <div class="data-sources__status col-6">
                <h2>Status by Data Source</h2>
                <div class="status-source"><!-- FL511 ALERTS -->
                    <img class="status-source__image" src="images/fl511-logo.png" title="FL511 Traffic and Commuter Information" alt="FL511 logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--<?php echo $fl511_status_modifier;?>"><?php echo $fl511_status_string;?></span>
                        <br/>
                        <a href="https://fl511.com/List/Alerts" title="fl511.com Alerts Page" alt="Link to fl511.com alerts page" target="_new">Get more info on fl511.com ></a>
                    </div>
                </div>
                <div class="status-source"><!-- FLHSMV LIVE FEED -->
                    <img class="status-source__image" src="images/flhsmv-logo.png" title="Florida Department of Highway Stafety and Motor Vehicles" alt="FLHSMV Logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--error">Data coming soon</span>
                        <br/>
                        <a href="https://flhsmv.gov/fhp/traffic/live_traffic_feed.html" title="flhsmv.gov Live Traffic Feed" alt="Link to flhsmv.gov live traffic page" target="_new">Get more info on flhsmv.gov ></a>
                    </div>
                </div>
                <div class="status-source"><!-- FDOT MYTBI -->
                    <img class="status-source__image" src="images/fdot-logo.png" title="FL511 Traffic and Commuter Information" alt="FL511 logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--error">Data coming soon</span>
                        <br/>
                        <a href="http://www.mytbi.com/projects/projects.asp?roadID=9" title="mytbi.com Skyway Page" alt="Link to mytbi.com Skyway page" target="_new">Get more info on mytbi.com ></a>
                    </div>
                </div>
            </div>
            <div class="data-sources__weather col-6">
                <h2>Current Weather from <img src="images/wunderground-logo.png" /></h2>
                
                <?php
                for ($row = 0; $row < 2; $row++) {
                echo "<div class=\"weather-source\">";
                echo "<h3>".$weather_logs[$row]["city"]."</h3>";
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
                <p>The Sunshine Skyway bridge is a fantastic structure. Spanning Tampa Bay for over 4 miles, the cable-stayed main span connects St. Petersburg in Pinellas County and Terra Ceia in Manatee County. As the bridge is around 430 tall, it is succeptable to closures due to high-winds, fog, rain, and other causes.</p>
                <p>SkywayBridgeStatus.com is an open-source initiative aimed at helping Tampa Bay commuters plan for unexpected closures of the Sunshine Skyway Bridge. We are actively collecting real-time weather and traffic data from reputable sources, and our intent is to use that historical data to create a closure prediction model, which will be publically available to Tampa regional commuters.</p>
            </div>
            <div class="project-information__contribute col-4">
                <h2>Contribute</h2>
                <p>We’re always looking for great contributers to help us improve SkywayBridgeStatus.com. If you’re interested in contributing to this projct, please visit our <a href="#">GitHub page</a>, or email us at <a href="mailto:contribute@skywaybridgestatus.com">contribute@skywaybridgestatus.com</a>.</p>
                <p>We're also looking for strategic partners and sponsors to help keep this project going. <a href="mailto:contribute@skywaybridgestatus.com">Contact us</a> to learn more.</p>
            </div>
        </section>

        <section class="footer row">
            <div class="footer__copyright center">
                <p>SkywayBridgeStatus.com &copy; <?php echo date('Y');?> <a href="http://www.iannerney.com">Ian Nerney</a></p>
                <p>This project is available for use and modification under the <a href="/LICENSE">MIT License</a>.</p>
            </div>
        </section>
    </div>
</div>
</body>
</html>