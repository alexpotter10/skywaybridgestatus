# Skyway Bridge Status

## Summary
This project is aimed at helping Tampa Bay commuters plan for unexpected closures of the Sunshine Skyway Bridge. This web application collects real-time weather and traffic data from reputable sources, and displays that data on a front-facing website (SkywayBridgeStatus.com).

The eventual goal of this project is to create a closure prediction model that is available to the public.

## Project Roadmap
1. Data collection and compiling – ACTIVE, ONGOING SINCE JUNE 2017
2. Near real-time reporting on front facing website (SkywayBridgeStatus.com) – ACTIVE, ONGOING SINCE JUNE 2017
3. Automated status updates to commuters via various channels (email, text, social, etc.) – IN DEVELOPMENT
4. Closure prediction forecasting and reporting – QUEUED

## Contributers
I certainly welcome other contributers to this project! If you'd like to discuss contributing please email me at ian@skywaybridgestatus.com, or submit a pull request for any documented issue.

## Project Setup
1. Clone the repo to your environment
2. Deploy a MySQL instance and import the table schema found in the `schema.sql` file.
3. Copy `/public/config_template.php` and rename to `/public/config.php` for the front-end config.
4. Copy `/app/data_scraper/php_scrapers/config_template.php` and rename to `/app/data_scraper/php_scrapers/config.php` for the data scraper config.
5. Add in the required parameters to both config files (let me know if you have any questions)
6. Point your web server to use `/public` as the web root
7. Execute data scraper jobs via the command line to gather data and store to MySQL.

That's it, you're ready to roll!