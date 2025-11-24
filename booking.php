<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $checkIn = htmlspecialchars(trim($_POST['checkIn']));
    $checkOut = htmlspecialchars(trim($_POST['checkOut']));
    $roomType = htmlspecialchars(trim($_POST['roomType']));
    $guests = htmlspecialchars(trim($_POST['guests']));
    $specialRequests = htmlspecialchars(trim($_POST['specialRequests']));
    $newsletter = isset($_POST['newsletter']) ? 'Yes' : 'No';
    
    // Email configuration
    $to = "info@ezulwinistay.co.za"; // Replace with your email
    $subject = "New Booking Request - Ezulwini Stay";
    
    // Email content
    $message = "
    <html>
    <head>
        <title>New Booking Request</title>
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
            <h2>New Booking Request - Ezulwini Stay</h2>
        </div>
        <div class='content'>
            <div class='detail'><span class='label'>Name:</span> $firstName $lastName</div>
            <div class='detail'><span class='label'>Email:</span> $email</div>
            <div class='detail'><span class='label'>Phone:</span> $phone</div>
            <div class='detail'><span class='label'>Check-in Date:</span> $checkIn</div>
            <div class='detail'><span class='label'>Check-out Date:</span> $checkOut</div>
            <div class='detail'><span class='label'>Room Type:</span> $roomType</div>
            <div class='detail'><span class='label'>Number of Guests:</span> $guests</div>
            <div class='detail'><span class='label'>Special Requests:</span> $specialRequests</div>
            <div class='detail'><span class='label'>Newsletter Subscription:</span> $newsletter</div>
            <div class='detail'><span class='label'>Submission Time:</span> " . date('Y-m-d H:i:s') . "</div>
        </div>
    </body>
    </html>
    ";
    
    // Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Ezulwini Stay <noreply@ezulwinistay.co.za>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    
    // Send email
    if (mail($to, $subject, $message, $headers)) {
        // Send confirmation email to customer
        $customerSubject = "Booking Request Received - Ezulwini Stay";
        $customerMessage = "
        <html>
        <head>
            <title>Booking Confirmation</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .header { background: #150f64; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .footer { background: #f8f5f0; padding: 15px; text-align: center; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>Thank You for Your Booking Request!</h2>
            </div>
            <div class='content'>
                <p>Dear $firstName $lastName,</p>
                <p>We have received your booking request and will process it within 24 hours.</p>
                <p><strong>Booking Details:</strong></p>
                <p>Check-in: $checkIn<br>
                   Check-out: $checkOut<br>
                   Room Type: $roomType<br>
                   Guests: $guests</p>
                <p>If you have any questions, please contact us at +27 72 554 0757.</p>
                <p>Best regards,<br>Ezulwini Stay Team</p>
            </div>
            <div class='footer'>
                <p>Ezulwini Stay | 70 Charl Cilliers, Standerton | info@ezulwinistay.co.za</p>
            </div>
        </body>
        </html>
        ";
        
        $customerHeaders = "MIME-Version: 1.0" . "\r\n";
        $customerHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $customerHeaders .= "From: Ezulwini Stay <info@ezulwinistay.co.za>" . "\r\n";
        
        mail($email, $customerSubject, $customerMessage, $customerHeaders);
        
        echo json_encode(['status' => 'success', 'message' => 'Booking request sent successfully! We will contact you within 24 hours.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error sending your booking request. Please try again or contact us directly.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>