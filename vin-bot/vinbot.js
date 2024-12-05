const axios = require('axios');

// Function to scrape VIN data from NHTSA API
export const scrapeVinData = async (vin) => {
    try {
        const response = await axios.get(`https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvalues/${vin}?format=json`);
        const data = response.data.Results[0];

        return {
            year: data.ModelYear || "N/A",
            make: data.Make || "N/A",
            model: data.Model || "N/A",
            style: data.BodyClass || "N/A",
            madeIn: data.Country || "N/A",
            fuelType: data.FuelType || "N/A",
            vehicleType: data.VehicleType || "N/A",
            trimLevel: data.Trim || "N/A",  // Adjust based on actual API response
            engineType: data.Engine || "N/A",  // Adjust based on actual API response
            transmissionType: data.Transmission || "N/A",  // Adjust based on actual API response
            bodyType: data.BodyType || "N/A",  // Adjust based on actual API response
            safetyRating: data.SafetyRating || "N/A",  // Adjust based on actual API response
        };
    } catch (error) {
        console.error('Error fetching VIN data:', error);
        throw error; // Allow server.mjs to handle this
    }
};
