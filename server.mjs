import express from 'express';
import { scrapeVinData } from './vin-bot/vinbot.js'; // Ensure to add .js extension
import cors from 'cors';
import nodemailer from 'nodemailer';
import bodyParser from 'body-parser';
import dotenv from 'dotenv';
import path from 'path';

dotenv.config();

const app = express();
const PORT = process.env.PORT || 5500;

// Check for email configuration
if (!process.env.EMAIL_USER || !process.env.EMAIL_PASS) {
    console.error("Email configuration is missing in environment variables.");
    process.exit(1);
}

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Middleware to serve static files in the templates folder without the "/templates" prefix
app.use(express.static(path.join(process.cwd(), 'templates')));

// Middleware to handle requests to clean URLs and remove `/templates` from routes
app.use((req, res, next) => {
    // If the request URL starts with '/templates', remove it
    if (req.url.startsWith('/templates')) {
        req.url = req.url.replace('/templates', '');
    }

    // Ensure .html extension can be accessed without specifying it
    if (!path.extname(req.url)) {
        req.url += '.html';
    }

    next();
});

// Route to fetch car data by VIN
app.get('/api/vin/:vin', async (req, res) => {
    const vin = req.params.vin;
    try {
        const carData = await scrapeVinData(vin);
        res.json(carData);
    } catch (error) {
        console.error('Error fetching VIN data:', error.message);
        res.status(500).json({ error: 'Unable to retrieve car information at the moment. Please try again later.' });
    }
});

// Route to handle form submission and redirect to payment
app.post('/submit-payment', async (req, res) => {
    const { fullName, email, phone, vin } = req.body;

    try {
        // Save form data logic here
        await saveFormData(fullName, email, phone, vin);

        // Send notification to admin
        await sendNotification(fullName, email, phone, vin);

        // Send success response with transaction details for payment
        res.json({
            success: true,
            message: 'Form data saved. Redirecting to payment...',
            transactionDetails: {
                amount: 45,
                description: 'Premium Plan for Detailed Car History'
            }
        });
    } catch (error) {
        console.error('Error handling form submission:', error);
        res.status(500).json({ success: false, message: 'Failed to process form submission' });
    }
});

// Function to save form data (implement your own database logic)
async function saveFormData(fullName, email, phone, vin) {
    try {
        console.log(`Saving data: ${fullName}, ${email}, ${phone}, VIN: ${vin}`);
        // Database save logic here
    } catch (error) {
        console.error('Error saving form data:', error);
        throw error;
    }
}

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
        to: process.env.ADMIN_EMAIL || process.env.EMAIL_USER, // Send to admin email or user email if admin not set
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

// Start the server
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});

// Graceful shutdown
process.on('SIGINT', () => {
    console.log("Server shutting down gracefully...");
    process.exit();
});
