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
    <?php include 'template-parts/styles-and-fonts.php';?>
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
                <div class="fb-like" data-href="https://www.skywaybridgestatus.com" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>
                <style>.bmc-button img{width: 20px !important;margin-bottom: 1px !important;box-shadow: none !important;border: none !important;vertical-align: middle !important;}.bmc-button{    line-height:24px !important;height: 27px !important;top: 7px;position: relative; !important;text-decoration: none !important;display:inline-flex !important;color:#000000 !important;background-color:#FFFFFF !important;border-radius: 3px !important;border: 1px solid transparent !important;padding: 0px 6px !important;font-size: 14px !important;letter-spacing:-0.08px !important;;box-shadow: 0px 1px 2px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;margin: 0 1px !important;font-family:'Roboto', sans-serif !important;-webkit-box-sizing: border-box !important;box-sizing: border-box !important;-o-transition: 0.3s all linear !important;-webkit-transition: 0.3s all linear !important;-moz-transition: 0.3s all linear !important;-ms-transition: 0.3s all linear !important;transition: 0.3s all linear !important;}.bmc-button:hover, .bmc-button:active, .bmc-button:focus {-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;text-decoration: none !important;box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;opacity: 0.85 !important;color:#000000 !important;}</style><a class="bmc-button"  href="https://www.buymeacoffee.com/iannerney" target="_blank" rel="noopener"><img src="https://www.buymeacoffee.com/assets/img/BMC-btn-logo.svg" alt="Coffee icon"><span style="margin-left:5px;margin-right:5px;">Buy me a coffee</span></a>
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

        <section class="data-sources row">
            <div class="data-sources__status col-6">
                <h2>Status by Data Source</h2>
                <div class="status-source"><!-- FL511 ALERTS -->
                    <img class="status-source__image" src="assets/img/fl511-logo.png" title="FL511 Traffic and Commuter Information" alt="FL511 logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--<?php echo $fl511_status_modifier;?>"><?php echo $fl511_status_string;?></span>
                        <br/>
                        <a href="https://fl511.com/List/Alerts" title="fl511.com Alerts Page" alt="Link to fl511.com alerts page" target="_blank" rel="noopener">Get more info on fl511.com ></a>
                    </div>
                </div>
                <div class="status-source"><!-- FLHSMV LIVE FEED -->
                    <img class="status-source__image" src="assets/img/flhsmv-logo.png" title="Florida Department of Highway Stafety and Motor Vehicles" alt="FLHSMV Logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--error">Data coming soon</span>
                        <br/>
                        <a href="https://flhsmv.gov/fhp/traffic/live_traffic_feed.html" title="flhsmv.gov Live Traffic Feed" alt="Link to flhsmv.gov live traffic page" target="_blank" rel="noopener">Get more info on flhsmv.gov ></a>
                    </div>
                </div>
                <div class="status-source"><!-- FDOT MYTBI -->
                    <img class="status-source__image" src="assets/img/fdot-logo.png" title="FL511 Traffic and Commuter Information" alt="FL511 logo" align="left"/>
                    <div class="status-source__content">
                        <span class="status-source-status--error">Data coming soon</span>
                        <br/>
                        <a href="http://www.mytbi.com/projects/projects.asp?roadID=9" title="mytbi.com Skyway Page" alt="Link to mytbi.com Skyway page" target="_blank" rel="noopener">Get more info on mytbi.com ></a>
                    </div>
                </div>
            </div>
            <div class="data-sources__weather col-6">
                <h2>Current Weather from <img src="assets/img/wunderground-logo.png" alt="Weather Underground" title="Weather Underground" description="Weather Underground logo"/></h2>
                
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
                <h2>About This Project</h2>
                <p>SkywayBridgeStatus.com is an open-source initiative aimed at helping Tampa Bay commuters plan for unexpected closures of the Sunshine Skyway Bridge. This web application actively collects real-time weather and traffic data from reputable sources. My goal is to use this historical data to create a closure prediction model available to the public.</p>
            </div>
            <div class="project-information__contribute col-4">
                <h2>Contribute</h2>
                <p>If you’re interested in contributing to, or sponsoring this project, please visit our <a href="https://github.com/SkywayBridgeStatus">GitHub page</a>, or <a href="mailto:contribute@skywaybridgestatus.com">email us</a>.</p>
            </div>
        </section>

        <?php include 'template-parts/footer.php';?>

    </div>
</div>
</body>
</html>