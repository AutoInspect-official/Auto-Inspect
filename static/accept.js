const express = require('express');
const nodemailer = require('nodemailer');
const multer = require('multer');
const upload = multer({ dest: 'uploads/' }); // For handling file uploads

const app = express();
app.use(express.urlencoded({ extended: true }));

// Configure nodemailer
const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: '',
        pass: ''
    }
});

// Endpoint to handle form submission
app.post('/YOUR_SERVER_ENDPOINT', upload.array('images'), (req, res) => {
    const { make, condition, model, year, price, mileage, description } = req.body;

    // Prepare email
    const mailOptions = {
        from: 'YOUR_EMAIL@gmail.com',
        to: 'YOUR_EMAIL@gmail.com',
        subject: 'New Car Submission',
        text: `Make: ${make}\nCondition: ${condition}\nModel: ${model}\nYear: ${year}\nPrice: ${price}\nMileage: ${mileage}\nDescription: ${description}`
    };

    // Send email
    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            return res.status(500).send('Error sending email: ' + error);
        }
        res.send('Email sent: ' + info.response);
    });
});

// Start the server
app.listen(3000, () => {
    console.log('Server is running on http://localhost:3000');
});
