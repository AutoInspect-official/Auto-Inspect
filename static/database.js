// Function to get the VIN from the URL query parameters
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Fetch car info from the JSON file based on VIN
function fetchCarInfo(vin) {
    fetch('../static/data.json')  // Ensure this path is correct relative to your HTML file
        .then(response => response.json())
        .then(data => {
            // Find the car with the matching VIN
            const car = data.find(car => car.vin === vin);

            if (car) {
                displayCarInfo(car); // Display the car info on the page
            } else {
                displayError('Car with this VIN not found');
            }
        })
        .catch(error => {
            console.error('Error fetching car data:', error);
        });
}

// Function to display car information on the page
function displayCarInfo(car) {
    const carInfoDiv = document.getElementById('carInfo');
    carInfoDiv.style.display = 'block'; // Show the car info section

    // Set the car details in the corresponding HTML elements
    document.getElementById('carVin').innerText = car.vin;
    document.getElementById('carModel').innerText = car.model;
    document.getElementById('carRecords').innerText = car.records;
    document.getElementById('carCountry').innerText = car.country;
    document.getElementById('carEngine').innerText = car.engine;
    document.getElementById('carManufacturer').innerText = car.manufacturer;
    document.getElementById('carAuctionSales').innerText = car.auction_sales;
    document.getElementById('carOdometer').innerText = car.odometer;
    document.getElementById('carAccidents').innerText = car.accidents;
    document.getElementById('carRecalls').innerText = car.recalls;
}

// Function to display an error message
function displayError(errorMessage) {
    const carInfoDiv = document.getElementById('carInfo');
    carInfoDiv.style.display = 'block'; // Show the car info section
    carInfoDiv.innerHTML = `<p style="color: red;">${errorMessage}</p>`;
}

// On window load, fetch car info based on the VIN from URL parameters
window.onload = function() {
    const vin = getQueryParam('vin');
    if (vin) {
        fetchCarInfo(vin); // Fetch car info for the VIN from URL parameters
    } else {
        displayError('No VIN provided');
    }
};
