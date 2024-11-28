import { scrapeVinData } from './vin-bot/vinbot.js';
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
 */
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
        console.error('Error in sendNotification:', error.stack || error.message);
        throw new Error('Failed to send notification email.');
    }
}

/**
 * Handle the POST request to submit car sale data.
 */
async function handleCarSaleSubmission(event) {
    let formData;
    try {
        formData = JSON.parse(event.body);
    } catch (error) {
        console.error('Error in handleCarSaleSubmission (parsing request body):', error.stack || error.message);
        return {
            statusCode: 400,
            body: JSON.stringify({ success: false, message: 'Invalid JSON body.' }),
        };
    }

    const { fullName, email, phone, vin, carDetails } = formData;

    if (!fullName || !email || !phone || !vin || !carDetails) {
        console.error('Error in handleCarSaleSubmission: Missing required fields.');
        return {
            statusCode: 400,
            body: JSON.stringify({ success: false, message: 'All fields are required.' }),
        };
    }

    try {
        console.log(`Received form submission: ${fullName}, ${email}, ${phone}, VIN: ${vin}`);
        await sendNotification(fullName, email, phone, vin, carDetails);

        return {
            statusCode: 200,
            body: JSON.stringify({
                success: true,
                message: 'Details submitted successfully! The report would be provided soon on your email.',
            }),
        };
    } catch (error) {
        console.error('Error in handleCarSaleSubmission (processing submission):', error.stack || error.message);
        return {
            statusCode: 500,
            body: JSON.stringify({ success: false, message: 'Failed to process form submission.' }),
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
        try {
            corsMiddleware({}, {}, () => {});
            bodyParserMiddleware({}, {}, () => {});
        } catch (middlewareError) {
            console.error('Error in handler (middleware initialization):', middlewareError.stack || middlewareError.message);
            throw new Error('Middleware initialization failed.');
        }

        // Route handling
        if (event.httpMethod === 'POST' && event.path === '/submit-car') {
            return await handleCarSaleSubmission(event);
        }

        // Default 404 for unsupported routes
        return {
            statusCode: 404,
            body: JSON.stringify({ success: false, message: 'Endpoint not found.' }),
        };
    } catch (error) {
        console.error('Unhandled server error in handler:', error.stack || error.message);
        return {
            statusCode: 500,
            body: JSON.stringify({ success: false, message: 'Internal server error.' }),
        };
    }
};
