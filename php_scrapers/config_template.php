<?php

// Global Variables
$environment = ""; // enter "development", "staging", or "production"


// Database
$servername = ""; // Host IP; use 127.0.0.1 if localhost
$username = "";
$password = "";
$dbname = "";

// Timezone Settings
date_default_timezone_set('America/New_York');

// Weather Underground API
$wukey = "";

// Sentry Error Tracking
require_once ''; // Provide full path to /vendor/sentry/sentry/lib/Raven/Autoloader.php
Raven_Autoloader::register();
$sentryClient = new Raven_Client(''); // Input URL provide by Sentry account
$error_handler = new Raven_ErrorHandler($sentryClient);
$error_handler->registerExceptionHandler();
$error_handler->registerErrorHandler();
$error_handler->registerShutdownFunction();
$sentryClient->setEnvironment($environment);

?>