/**
 * FL511 Alert Data Scraper
 * 
 */


const puppeteer = require('puppeteer');
const Sentry = require('@sentry/node');
Sentry.init({ dsn: 'https://5efc48f4384c4ccbbfd4813d074a5cf4@sentry.io/1298345' });

let scrape = async () => {
    const browser = await puppeteer.launch({headless: true});
	const page = await browser.newPage();

	await page.goto('https://fl511.com/List/Alerts');

    const result = await page.evaluate(() => {
		let requestDatetime = new Date().toISOString().slice(0, 19).replace('T', ' ')
		let data = []; // Create an empty array that will store our data
		let elements = document.querySelectorAll('#AlertsPage > div > table > tbody > tr'); // Select all alerts
		let regex = /(?=.*?\bSKYWAY\b).*/;
		;

        for (var element of elements){ // Loop through each alert
            let region = element.childNodes[1].innerText; // Select the region
			let county = element.childNodes[3].innerText; // Select the county
			let message = element.childNodes[5].innerText; // Select the message
			let lastUpdated = element.childNodes[7].innerText; // Select the last updated dt
			let active = 1; // Set boolean field to indicate alert is active
			
			if(message !=='' && message.match(regex)) {
				data.push({region, county, message, lastUpdated, requestDatetime, active}); // Push an object with the data onto our array
			};


        };

        return data; // Return our data array
    });

    browser.close();
    return result; // Return the data
};

try {
	scrape().then((value) => {
		var config = require('config');
		var dbConfig = config.get('MySQL.dbConfig');
		var mysql      = require('mysql');
		var connection = mysql.createConnection({
			host     : dbConfig.host,
			user     : dbConfig.user,
			password : dbConfig.password,
			database : dbConfig.database
		});
		
		// Checks if array does not exist, is not an array, or is empty 
		if (!Array.isArray(value) || !value.length) {
			
			// Remove any active statuses
			connection.connect();
			connection.query({
				sql: 'UPDATE fl511_log SET active = 0 WHERE active = 1',
			}, function (error) {
					if (error) Sentry.captureException(error);
			});
			connection.end();

		} else {
			// Reformat array of objects to array of arrays
			var reformattedArray = [];
			value.forEach(function(obj){
				reformattedArray.push(Object.values(obj))
			});

			
			connection.connect();
			
			// Remove existing active status(es)
			connection.query({
				sql: 'UPDATE fl511_log SET active = 0 WHERE active = 1',
			}, function (error) {
					if (error) Sentry.captureException(error);
			});

			// Add new active status(es)
			connection.query({
				sql: 'INSERT INTO fl511_log (region, county, message, last_updated, request_datetime, active) VALUES ?',
				values: [reformattedArray]
			}, function (error) {
					if (error) Sentry.captureException(error);
			});
			
			connection.end();
		}
	});
}
catch(error) {
	Sentry.captureException(error);
}