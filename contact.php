<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Email configuration
    $to = "info@proactiveict.co.za"; // Replace with your email
    $email_subject = "New Contact Form Submission: $subject";
    
    // Email content
    $email_message = "
    <html>
    <head>
        <title>Contact Form Submission</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .header { background: #150f64; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .detail { margin-bottom: 10px; }
            .label { font-weight: bold; color: #150f64; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>New Contact Form Submission - Ezulwini Stay</h2>
        </div>
        <div class='content'>
            <div class='detail'><span class='label'>Name:</span> $name</div>
            <div class='detail'><span class='label'>Email:</span> $email</div>
            <div class='detail'><span class='label'>Subject:</span> $subject</div>
            <div class='detail'><span class='label'>Message:</span><br>$message</div>
            <div class='detail'><span class='label'>Submission Time:</span> " . date('Y-m-d H:i:s') . "</div>
        </div>
    </body>
    </html>
    ";
    
    // Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Ezulwini Stay Website <noreply@proactiveict.co.za>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    
    // Send email
    if (mail($to, $email_subject, $email_message, $headers)) {
        // Send confirmation email to customer
        $customerSubject = "Message Received - Ezulwini Stay";
        $customerMessage = "
        <html>
        <head>
            <title>Message Confirmation</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .header { background: #150f64; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .footer { background: #f8f5f0; padding: 15px; text-align: center; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>Thank You for Contacting Us!</h2>
            </div>
            <div class='content'>
                <p>Dear $name,</p>
                <p>We have received your message and will get back to you within 24 hours.</p>
                <p><strong>Your Message:</strong><br>$message</p>
                <p>If you need immediate assistance, please call us at +27 72 554 0757.</p>
                <p>Best regards,<br>Ezulwini Stay Team</p>
            </div>
            <div class='footer'>
                <p>Ezulwini Stay | 70 Charl Cilliers, Standerton | info@proactiveict.co.za</p>
            </div>
        </body>
        </html>
        ";
        
        $customerHeaders = "MIME-Version: 1.0" . "\r\n";
        $customerHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $customerHeaders .= "From: Ezulwini Stay <info@proactiveict.co.za>" . "\r\n";
        
        mail($email, $customerSubject, $customerMessage, $customerHeaders);
        
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully! We will get back to you within 24 hours.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error sending your message. Please try again or contact us directly.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>