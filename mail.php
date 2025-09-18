<?php
// mail.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    // Email subject & message
    $subject = "Welcome to Our Application!";
    $message = "Hello " . htmlspecialchars($name) . ",\n\n";
    $message .= "Welcome to our application. We are glad to have you on board!\n\n";
    $message .= "Regards,\nTeam";

    // Headers
    $headers = "From: no-reply@yourapp.com\r\n";
    $headers .= "Reply-To: support@yourapp.com\r\n";

    // Send email
    if (mail($email, $subject, $message, $headers)) {
        echo "Welcome email sent successfully to " . htmlspecialchars($email);
    } else {
        echo "Failed to send welcome email.";
    }
}
?>
