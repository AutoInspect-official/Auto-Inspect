const { scrapeVinData } = require('./vin-bot/vinbot.js');
const cors = require('cors');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');
const dotenv = require('dotenv');

dotenv.config();

// Initialize CORS middleware
const corsMiddleware = cors({
    origin: '*', // Adjust this to restrict origins if necessary
    methods: ['GET', 'POST'],
});

// Middleware for parsing JSON
const bodyParserMiddleware = bodyParser.json();

async function sendNotification(fullName, email, phone, vin, carDetails) {
    try {
        const transporter = nodemailer.createTransport({
            service: 'gmail',
            auth: {
                user: process.env.EMAIL_USER,
                pass: process.env.EMAIL_PASS,
            },
        });

        const mailOptions = {
            from: `"${fullName}" <${email}>`,
            to: process.env.ADMIN_EMAIL || process.env.EMAIL_USER,
            subject: 'New Car Sale Request',
            text: `A new car sale request has been submitted:
            Name: ${fullName}
            Email: ${email}
            Phone: ${phone}
            VIN: ${vin}
            Car Details: ${JSON.stringify(carDetails)}`,
        };

        const info = await transporter.sendMail(mailOptions);
        console.log('Notification email sent successfully:', info.response);
    } catch (error) {
        console.error('Error in sendNotification:', error.message);
        throw new Error('Failed to send notification email.');
    }
}

async function handleCarSaleSubmission(event) {
    let formData;
    try {
        formData = JSON.parse(event.body);
    } catch (error) {
        console.error('Invalid JSON body:', error.message);
        return {
            statusCode: 400,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ success: false, message: 'Invalid JSON body.' }),
        };
    }

    const { fullName, email, phone, vin, carDetails } = formData;

    if (!fullName || !email || !phone || !vin || !carDetails) {
        console.error('Missing required fields.');
        return {
            statusCode: 400,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ success: false, message: 'All fields are required.' }),
        };
    }

    try {
        console.log(`Received form submission: ${fullName}, ${email}, ${phone}, VIN: ${vin}`);
        await sendNotification(fullName, email, phone, vin, carDetails);

        return {
            statusCode: 200,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                success: true,
                message: 'Details submitted successfully! The report will be sent to your email.',
            }),
        };
    } catch (error) {
        console.error('Error processing submission:', error.message);
        return {
            statusCode: 500,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ success: false, message: 'Failed to process form submission.' }),
        };
    }
}

async function handleVinDataRequest(event) {
    const queryParams = new URLSearchParams(event.queryStringParameters || {});
    const vin = queryParams.get('vin');
    if (!vin) {
        return {
            statusCode: 400,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ success: false, message: 'VIN is required.' }),
        };
    }

    try {
        const carData = await scrapeVinData(vin);
        return {
            statusCode: 200,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(carData),
        };
    } catch (error) {
        console.error('Error fetching VIN data:', error.message);
        return {
            statusCode: 500,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ success: false, message: 'Failed to fetch VIN data.' }),
        };
    }
}

module.exports.handler = async (event, context) => {
    console.log(`Incoming request: ${event.httpMethod} ${event.path}`);
    console.log('Event object:', JSON.stringify(event, null, 2));

    try {
        // Apply CORS and body parsing middleware
        await new Promise((resolve, reject) =>
            corsMiddleware(event, {}, (err) => (err ? reject(err) : resolve()))
        );

        if (event.httpMethod === 'POST' && event.path === '/submit-car') {
            return await handleCarSaleSubmission(event);
        }

        if (event.httpMethod === 'GET' && event.path === '/api/vin') {
            return await handleVinDataRequest(event);
        }

        // Default 404 for unsupported routes
        return {
            statusCode: 404,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ success: false, message: 'Endpoint not found.' }),
        };
    } catch (error) {
        console.error('Unhandled error:', error.message);
        return {
            statusCode: 500,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ success: false, message: 'Internal server error.' }),
        };
    }
};
