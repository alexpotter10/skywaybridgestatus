<!DOCTYPE html>
<html lang="en">
<head>
    <title>Status Widget | Skyway Bridge Status</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="skyway bridge status, widget, status widget">
    <meta name="Description" content="Want to report the bridge status on your website? We offer an embeddable widget that you use to display the latest status.">
    <link rel="canonical" href="https://www.skywaybridgestatus.com/widget/" />
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Libre+Franklin" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://use.fontawesome.com/d726da7372.js"></script>
    <!-- FAVICONS -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?php include 'template-parts/tracking.php';?>
</head>
<body>

<?php include 'template-parts/header.php';?>

<div class="main">
    <div class="container">
        <section class="widget-info col-12">
            <h1>Status Widget</h1>
            <p>The embeddable status widget allows for website owners to place a small snippet of code on their website and display the current global status of the Sunshine Skyway bridge.</p>
            <div id="sbs-widget" style="max-width:600px; margin: 0 auto; text-align:center;"></div>
            <p>&nbsp;</p>
            <p>To display the widget on your website, you just need a few lines of HTML. First, add the following script tag before the closing body tag of your HTML page.
            <xmp><script src="https://www.skywaybridgestatus.com/widget/v1/sbs-widget.js"></script></xmp>
            <p>Next, insert the following div anywhere on your page where you would like the widget to appear.</p>
            <xmp><div id="sbs-widget"></div></xmp>
            <p><b>Recommended:</b> You can then customize the display size and positioning by styling the div. Here's an example of a centered div with a maximum width of 600px.</p>
            <xmp><div id="sbs-widget" style="max-width:600px; margin: 0 auto; text-align:center;"></div></xmp>
            <p>That's it! You now have your status widget implemented on your website. 
            <p>&nbsp;</p>

            <h2>Display Requirements</h2>
            <p>To use the embeddable status widget, there are just a few requirements that must be adhered to:</p>
            <ol>
                <li>The Skyway Bridge Status logo must be visible, and displayed as shown in the example status widget above. The JavaScript snippet will handle this for you by default.</li>
                <li>The widget must be linked back to skywaybridgestatus.com, to provide data attribution and a link for additional notices (if necessary). The JavaScript snippet will handle this for you by default.</li>
            </ol>
            <p>&nbsp;</p>

            <h2>Questions or Help</h2>
            <p>If you have any questions or issues, please contact me via email at <a href="mailto:ian@skywaybridgestatus.com">ian@skywaybridgestatus.com</a> – I'd be happy to assist.</p>

        </section>

        <?php include 'template-parts/footer.php';?>

    </div>
</div>

<script src="/widget/v1/sbs-widget.js"></script>
</body>
</html>