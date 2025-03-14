const mailgun = require('mailgun-js');

const DOMAIN = 'autoinspect.netlify.app'; // Replace with your Mailgun domain
const mg = mailgun({ apiKey: 'b7410ba21b7c1ab601762e75ecf353e4-623424ea-e60fdeb2', domain: DOMAIN });

exports.handler = async (event, context) => {
  const { email } = JSON.parse(event.body);

  const data = {
    from: 'zanecarter.9388@gmail.com', // Use your email address
    to: email,
    subject: 'Subscription Confirmation',
    text: `Thank you for subscribing to the AutoInspect newsletter! You have the option to unsubscribe at any time.`,
    html: `<p>Thank you for subscribing to the <strong>AutoInspect</strong> newsletter! You have the option to unsubscribe at any time.</p>`,
  };

  try {
    await mg.messages().send(data);
    return {
      statusCode: 200,
      body: JSON.stringify({ message: 'Subscription successful!' }),
    };
  } catch (error) {
    return {
      statusCode: error.statusCode || 500,
      body: JSON.stringify({ message: error.message }),
    };
  }
};
