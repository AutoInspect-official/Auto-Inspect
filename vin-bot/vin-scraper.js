const axios = require('axios');
const cheerio = require('cheerio');

// Function to scrape VIN details
async function scrapeVinData(vin) {
    const url = `https://www.vinfreecheck.com/vin/${vin}`; // Updated URL to use the saved VIN directly

    try {
        const response = await axios.get(url);
        const html = response.data;

        // Load HTML into Cheerio
        const $ = cheerio.load(html);

        // Scrape specific data based on HTML structure
        const carData = {
        year: $('td:contains("Year")').next().text().trim() || "N/A",
        make: $('td:contains("Make")').next().text().trim() || "N/A",
        model: $('td:contains("Model")').next().text().trim() || "N/A",
        trimLevel: $('td:contains("Trim Level")').next().text().trim() || "N/A",
        style: $('td:contains("Style")').next().text().trim() || "N/A",
        madeIn: $('td:contains("Made In")').next().text().trim() || "N/A",
        vehicleSpec: $('td:contains("Vehicle Specification")').next().text().trim() || "N/A",
        accidentRecords: $('td:contains("Accident Records")').next().text().trim() || "N/A",
        floodRecords: $('td:contains("Flood Records")').next().text().trim() || "N/A",
        salvageRecords: $('td:contains("Salvage/Lemon Title Records")').next().text().trim() || "N/A",
        previousOwners: $('td:contains("Number of previous owner")').next().text().trim() || "N/A",
        odometerRecords: $('td:contains("Odometer Records")').next().text().trim() || "N/A",
        lienLoanRecords: $('td:contains("Lien/Loan Records")').next().text().trim() || "N/A",
        };

        return carData; // Return scraped data
    } catch (error) {
        console.error('Error scraping VIN data:', error);
        return null;
    }
}

// Export the scraping function
module.exports = { scrapeVinData };
