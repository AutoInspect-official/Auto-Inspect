import { scrapeVinData } from './vin-bot/vinbot.js'; // Ensure to add .js extension
import cors from 'cors';
import nodemailer from 'nodemailer';
import bodyParser from 'body-parser';
import dotenv from 'dotenv';
import path from 'path';

dotenv.config();

// Initialize CORS and Body Parser as middleware
const corsMiddleware = cors();
const bodyParserMiddleware = bodyParser.json();

// Function to send a notification email when a new form is submitted
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
        console.log('Notification email sent:', info.response);
    } catch (error) {
        console.error('Error sending email:', error);
        throw error;
    }
}

// Netlify serverless function handler
export const handler = async (event, context) => {
    // Handle POST request for form submission
    if (event.httpMethod === 'POST' && event.path === '/submit-payment') {
        const { fullName, email, phone, vin } = JSON.parse(event.body);

        try {
            // Save form data (you would implement your DB logic here)
            console.log(`Saving form data: ${fullName}, ${email}, ${phone}, VIN: ${vin}`);

            // Send notification to admin
            await sendNotification(fullName, email, phone, vin);

            // Return success response with transaction details for payment
            return {
                statusCode: 200,
                body: JSON.stringify({
                    success: true,
                    message: 'Form data saved. Redirecting to payment...',
                    transactionDetails: {
                        amount: 45,
                        description: 'Premium Plan for Detailed Car History'
                    }
                })
            };
        } catch (error) {
            console.error('Error handling form submission:', error);
            return {
                statusCode: 500,
                body: JSON.stringify({ success: false, message: 'Failed to process form submission' })
            };
        }
    }

    // Handle GET request for VIN scraping
    if (event.httpMethod === 'GET' && event.path.startsWith('/api/vin/')) {
        const vin = event.path.split('/').pop(); // Extract VIN from path
        try {
            const carData = await scrapeVinData(vin);
            return {
                statusCode: 200,
                body: JSON.stringify(carData)
            };
        } catch (error) {
            console.error('Error fetching VIN data:', error.message);
            return {
                statusCode: 500,
                body: JSON.stringify({ error: 'Unable to retrieve car information at the moment. Please try again later.' })
            };
        }
    }

    // Default 404 handler for unsupported paths
    return {
        statusCode: 404,
        body: JSON.stringify({ message: 'Not Found' })
    };
};
