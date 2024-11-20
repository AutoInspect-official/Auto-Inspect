import { scrapeVinData } from '../vin-bot/vinbot.js'; // Adjust path as per your project structure
import cors from 'cors';
import nodemailer from 'nodemailer';
import bodyParser from 'body-parser';
import dotenv from 'dotenv';

dotenv.config();

// Middleware initialization
const corsMiddleware = cors();
const bodyParserMiddleware = bodyParser.json();

/**
 * Send notification email to the admin with form details.
 * @param {string} fullName - User's full name.
 * @param {string} email - User's email address.
 * @param {string} phone - User's phone number.
 * @param {string} vin - Vehicle Identification Number.
 */
async function sendNotification(fullName, email, phone, vin) {
    const transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
            user: process.env.EMAIL_USER,
            pass: process.env.EMAIL_PASS
        }
    });

    const mailOptions = {
        from: `"${fullName}" <${email}>`,
        to: process.env.ADMIN_EMAIL || process.env.EMAIL_USER,
        subject: 'New Premium Plan Request',
        text: `A new premium plan request has been submitted:
        Name: ${fullName}
        Email: ${email}
        Phone: ${phone}
        VIN: ${vin}`
    };

    try {
        const info = await transporter.sendMail(mailOptions);
        console.log('Notification email sent successfully:', info.response);
    } catch (error) {
        console.error('Error sending email:', error.message);
        throw new Error('Failed to send notification email.');
    }
}

/**
 * Handle the POST request to submit payment form data.
 * @param {object} event - The request event.
 */
async function handlePaymentSubmission(event) {
    const { fullName, email, phone, vin } = JSON.parse(event.body);

    if (!fullName || !email || !phone || !vin) {
        return {
            statusCode: 400,
            body: JSON.stringify({ success: false, message: 'All fields are required.' })
        };
    }

    try {
        console.log(`Received form submission: ${fullName}, ${email}, ${phone}, VIN: ${vin}`);

        // Notify the admin
        await sendNotification(fullName, email, phone, vin);

        return {
            statusCode: 200,
            body: JSON.stringify({
                success: true,
                message: 'Form data submitted successfully!',
                transactionDetails: {
                    amount: 45.50,
                    description: 'Premium Plan for Detailed Car History'
                }
            })
        };
    } catch (error) {
        console.error('Error processing form submission:', error.message);
        return {
            statusCode: 500,
            body: JSON.stringify({ success: false, message: 'Failed to process form submission.' })
        };
    }
}

/**
 * Handle GET request to scrape VIN data.
 * @param {object} event - The request event.
 */
async function handleVinScraping(event) {
    const vin = event.queryStringParameters?.vin;

    if (!vin) {
        return {
            statusCode: 400,
            body: JSON.stringify({ success: false, message: 'VIN parameter is required.' })
        };
    }

    try {
        const carData = await scrapeVinData(vin);
        return {
            statusCode: 200,
            body: JSON.stringify(carData)
        };
    } catch (error) {
        console.error('Error scraping VIN data:', error.message);
        return {
            statusCode: 500,
            body: JSON.stringify({ success: false, message: 'Failed to retrieve car information.' })
        };
    }
}

/**
 * Main serverless function handler.
 */
export const handler = async (event) => {
    console.log(`Incoming request: ${event.httpMethod} ${event.path}`);

    try {
        // Allow CORS
        corsMiddleware({}, {}, () => {});
        bodyParserMiddleware({}, {}, () => {});

        // Route handling
        if (event.httpMethod === 'POST' && event.path === '/submit-payment') {
            return await handlePaymentSubmission(event);
        }

        if (event.httpMethod === 'GET' && event.path === '/api/vin') {
            return await handleVinScraping(event);
        }

        // Default 404 for unsupported routes
        return {
            statusCode: 404,
            body: JSON.stringify({ success: false, message: 'Endpoint not found.' })
        };
    } catch (error) {
        console.error('Unhandled server error:', error.message);
        return {
            statusCode: 500,
            body: JSON.stringify({ success: false, message: 'Internal server error.' })
        };
    }
};
