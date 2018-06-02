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
    <!-- Open Graph Meta Tags -->
    <meta property="og:url" content="https://www.skywaybridgestatus.com" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Skyway Bridge Status" />
    <meta property="og:description" content="Want to know if the Sunshine Skyway Bridge is open or closed? You've come to the right place! We pull and report the Skyway Bridge status every 5 minutes." />
    <meta property="og:image" content="/assets/img/skywaystatus-og.jpg" />
    <!-- External Assets -->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Libre+Franklin" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://use.fontawesome.com/d726da7372.js"></script>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?php include 'template-parts/tracking.php';?>
</head>
<body>

<?php include 'template-parts/header.php';?>

<div class="main">
    <div class="container">

        <section class="status row">
            <div class="status__header col-12">
                <h1>The Sunshine Skyway Bridge is currently 
                <br/>
                <span class="status--<?php echo $global_status_modifier;?>"><?php echo $global_status_string;?></span></h1>
                <p><a href="." onclick="ga('send', 'event', 'Status Refresh', 'Link Click', 'Homepage Refresh');">Refresh this page</a> for the latest data. We update our status every 5 minutes.</p>
                <p class="status__data-refreshed">(Status last updated: <?php echo date_format($fetch_datetime,'F jS, Y \a\t g:ia');?>)</p>
            </div>
            <div class="status__facebook-like-button">
                <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.skywaybridgestatus.com%2F&width=140&layout=button_count&action=like&size=large&show_faces=true&share=true&height=46&appId=1853913434627398" width="150" height="46" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
            </div>
        </section>

        <?php
        // Loop for annoucement – SQL limited to 1 result
        foreach($planned_closure as $planned_closure):
            
            // Store new date variables
            $start_date = date_create($planned_closure["start_datetime"]);
            $end_date = date_create($planned_closure["end_datetime"]);
        
        ?>

        <section class="announcements row">
            <div class="announcements__column col-12">
                <div class="announcements-box">
                    <b>PLANNED CLOSURE ALERT:</b> <?php echo $planned_closure["closed_direction"]; ?> traffic on the Skyway Bridge will be suspended from <?php echo date_format($start_date,'g:ia \o\n l F jS, Y'); ?> to <?php echo date_format($end_date,'g:ia \o\n l F jS, Y'); ?> for <?php echo $planned_closure["reason"]; ?>. <a href="<?php echo $planned_closure["url"]; ?>"> Learn more.</a>
                </div>
            </div>
        </section>

        <?php endforeach; ?>

        <section class="ad-main row">
            <div class="ad-main__content col-12">
                <div class="ad-main__mobile">
                    <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=12&l=ez&f=ifr&linkID=e2176811beea9c4c4b07f522188a0500&t=leewardintera-20&tracking_id=leewardintera-20" width="300" height="250" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
                </div>
                <div class="ad-main__desktop">
                    <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=48&l=ez&f=ifr&linkID=4aacc3c69fcb1f9af4ef0ab44bec70cf&t=leewardintera-20&tracking_id=leewardintera-20" width="728" height="90" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
                </div>
                <div class="ads__explanation">
                    <a href="/advertising-policy/">Why Ads?</a> | <a href="mailto:contact@skywaybridgestatus.com?subject=Advertising Information Request">Advertise With Us</a>
                </div>
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

        <?php include 'template-parts/footer.php';?>

    </div>
</div>
</body>
</html>