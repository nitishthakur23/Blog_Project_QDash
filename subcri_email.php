<?php

// To Remove unwanted errors
error_reporting(0);

// Add your connection Code
require 'config/database.php';
// Important Files
require "./PHPMailer-master/src/PHPMailer.php";
require "./PHPMailer-master/src/SMTP.php";
require "./PHPMailer-master/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Email From Form Input
$send_to_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$send_to_email_lower = strtolower($send_to_email);
$name=$_POST['name'];
// Check if email is already subscribed
$stmt = "SELECT * FROM subscribers WHERE subscriber_mail='$send_to_email'";
$query = mysqli_query($connection, $stmt);
if (mysqli_num_rows($query)) {
    echo "already_subscribed"; // Send this response to indicate that the email is already subscribed
} else {
    sendMail($send_to_email, $name);
    $stmt = "INSERT INTO subscribers (subscriber_mail, name) VALUES ('$send_to_email_lower','$name')";
    $query = mysqli_query($connection, $stmt);
    echo "success"; // Send this response to indicate successful subscription
}
function sendMail($send_to, $name_email)
{
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Enter your email ID
        $mail->Username = "SMTP_HOST";
        $mail->Password = "SMTP_PASS";

        // Your email ID and Email Title
        $mail->setFrom("Your_email", "QDash");

        $mail->addAddress($send_to);

        // You can change the subject according to your requirement!
        $mail->Subject = "Email Subscription";

        // You can change the Body Message according to your requirement!
        $mail->Body = "Hello,\n{$name_email}\nThank you for subscribing to our email updates! We're excited to have you on board.\n\nYour account's email subscription has been successfully activated. From now on, you'll receive the latest news, offers, and updates straight to your inbox.\n\nIf you have any questions or need assistance, feel free to reach out to our support team.\n\nBest regards,\nQDASH";

        // Send email
        $mail->send();

        return true; // Email sent successfully
    } catch (Exception $e) {
        // Log or handle the error
        error_log('Error sending email: ' . $e->getMessage());
        return false; // Email sending failed
    }
}
