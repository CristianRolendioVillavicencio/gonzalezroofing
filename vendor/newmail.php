<?php

// Ensure the request is a POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form fields and remove unnecessary spaces and tags
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"), array(" ", " "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]); // Get the phone number
    $service = trim($_POST["service"]); // Get the selected service
    $message = trim($_POST["message"]);

    // Set the email subject as 'Website Lead'
    $subject = "New Website Lead";

    // Verify that the necessary data was sent and is valid
    if (empty($name) OR empty($message) OR empty($phone) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If not valid, send a HTTP 400 (Bad Request) response
        http_response_code(400);
        echo "Please fill all fields and try again.";
        exit;
    }

    // Email recipient address
    $recipient = "cristianvillavicencix@gmail.com";

    // Build the HTML email content
    $email_content = <<<EMAIL
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .email-container { background-color: #ffffff; width: 100%; max-width: 600px; margin: 20px auto; padding: 20px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        .header { background-color: #0046be; color: #ffffff; padding: 10px 20px; text-align: center; font-size: 24px; }
        .content { padding: 20px; line-height: 1.6; color: #333333; }
        .content p { margin: 10px 0; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">Congratulations, Cousins Painting LLC Team! 🎨</div>
        <div class="content">
            <p>Hello, $name:</p>
            <p>You have received a new potential client interested in your $service services. It's time to shine!</p>
            <p><strong>Potential Client Information:</strong></p>
            <ul>
                <li>Name: $name</li>
                <li>Email: $email</li>
                <li>Number: $phone</li>
                <li>Message: $message</li>
            </ul>
            <p><strong>Review the Details:</strong> Verify the information provided by the potential client.</p>
            <p><strong>Get in Touch:</strong> Do not miss the opportunity to turn this potential client into a successful sale. Call them or send them an email as soon as possible.</p> 
            <p><strong>Offer Value:</strong> Provide excellent customer service and highlight our unique services.</p>
        </div>
    </div>
</body>
</html>
EMAIL;

    // Build the email headers for HTML content
    $email_headers = "From: Cousins Painting Llc <info@cousinspaintingllc.com>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $email_headers .= "X-Mailer: PHP/" . phpversion();

    // Attempt to send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // If the email is sent successfully, send a HTTP 200 (OK) response
        http_response_code(200);
        echo "<div style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(0, 128, 0, 0.5); color: white; padding: 20px; border-radius: 10px; font-size: 24px; z-index: 10000;'>Thank You! Your message has been sent.</div>";
        echo "<script>setTimeout(function() { window.location = '/'; }, 1000);</script>";
    } else {
        // If sending fails, send a HTTP 500 (Internal Server Error) response
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // If the request is not POST, send a HTTP 403 (Forbidden) response
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}

?>