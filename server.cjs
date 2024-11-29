const { scrapeVinData } = require('./vin-bot/vinbot.js');
const nodemailer = require('nodemailer');
const dotenv = require('dotenv');

dotenv.config();

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

        await transporter.sendMail(mailOptions);
    } catch (error) {
        console.error('Error sending notification:', error.message);
        throw new Error('Failed to send notification email.');
    }
}

module.exports.handler = async (event) => {
    const corsHeaders = {
        'Access-Control-Allow-Origin': '*', // Adjust as needed
        'Access-Control-Allow-Methods': 'GET, POST, OPTIONS',
        'Access-Control-Allow-Headers': 'Content-Type',
    };

    if (event.httpMethod === 'OPTIONS') {
        return {
            statusCode: 204,
            headers: corsHeaders,
        };
    }

    try {
        if (event.httpMethod === 'POST' && event.path === '/submit-car') {
            const body = JSON.parse(event.body);
            const { fullName, email, phone, vin, carDetails } = body;

            if (!fullName || !email || !phone || !vin || !carDetails) {
                return {
                    statusCode: 400,
                    headers: corsHeaders,
                    body: JSON.stringify({ success: false, message: 'All fields are required.' }),
                };
            }

            await sendNotification(fullName, email, phone, vin, carDetails);
            return {
                statusCode: 200,
                headers: corsHeaders,
                body: JSON.stringify({ success: true, message: 'Submission successful!' }),
            };
        }

        if (event.httpMethod === 'GET' && event.path === '/api/vin') {
            const vin = new URLSearchParams(event.queryStringParameters).get('vin');
            if (!vin) {
                return {
                    statusCode: 400,
                    headers: corsHeaders,
                    body: JSON.stringify({ success: false, message: 'VIN is required.' }),
                };
            }

            const carData = await scrapeVinData(vin);
            return {
                statusCode: 200,
                headers: corsHeaders,
                body: JSON.stringify(carData),
            };
        }

        return {
            statusCode: 404,
            headers: corsHeaders,
            body: JSON.stringify({ success: false, message: 'Endpoint not found.' }),
        };
    } catch (error) {
        console.error('Unhandled error:', error.message);
        return {
            statusCode: 500,
            headers: corsHeaders,
            body: JSON.stringify({ success: false, message: 'Internal server error.' }),
        };
    }
};
