<?php

// To Remove unwanted errors
// error_reporting(0);

// Add your connection Code
require 'config/database.php';
// Important Files
require "../PHPMailer-master/src/PHPMailer.php";
require "../PHPMailer-master/src/SMTP.php";
require "../PHPMailer-master/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query_latest_post = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 1";
    $result_latest_post = mysqli_query($connection, $query_latest_post);
    $latest_post = mysqli_fetch_assoc($result_latest_post);

    // Step 2: Retrieve the list of email subscribers
    $query_subscribers = "SELECT subscriber_mail,name FROM subscribers where id=$id limit 1";
    $result_subscribers = mysqli_query($connection, $query_subscribers);
    $subscriber = mysqli_fetch_assoc($result_subscribers);
    $to = $subscriber['subscriber_mail'];
    $name = $subscriber['name'];
}

// Function to get category name by category id
function getCategoryName($category_id)
{
    global $connection; // Declare $connection as global within the function
    $query = "SELECT title FROM categories WHERE id = $category_id";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        // Query execution failed
        echo "Error: " . mysqli_error($connection);
        return "Unknown";
    }
    if (mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
        return $category['title'];
    } else {
        return "Unknown";
    }
}


// Function to get author name by author id
function getAuthorName($author_id)
{
    global $connection; // Declare $connection as global within the function
    $query = "SELECT CONCAT(firstname, ' ', lastname) AS author_name  FROM users WHERE id = $author_id";
    $result = mysqli_query($connection, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $author = mysqli_fetch_assoc($result);
        return $author['author_name'];
    } else {
        return "Unknown";
    }
}
function update_history($id, $name, $to)
{
    global $connection;

    // Get the current date
    $date = date("Y-m-d H:i:s");

    // Prepare SQL statement using prepared statement to prevent SQL injection
    $sql = "INSERT INTO email_history (subscriber_id, name, email, sent_date) VALUES (?, ?, ?, ?)";

    // Prepare and bind parameters
    if ($stmt = mysqli_prepare($connection, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "isss", $id, $name, $to, $date);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Email history updated successfully!";
        } else {
            echo "Failed to update email history: " . mysqli_error($connection);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

function sendMailupdate($id, $send_to, $name_email, $latest_post)
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
        // Compose the email
        $message = "Hello,\n" . $name_email . "\n";
        $message .= "We are excited to share our latest blog post with you:\n\n";
        $message .= "Title: " . $latest_post['title'] . "\n";
        $message .= "Category: " . getCategoryName($latest_post['category_id']) . "\n";
        $message .= "Author: " . getAuthorName($latest_post['author_id']) . "\n";
        $message .= "Date: " . date("M d, Y", strtotime($latest_post['date_time'])) . "\n\n";
        $message .= "Read more at: " . ROOT_URL . "post.php?id=" . $latest_post['id'] . "\n\n";
        $message .= "Thank you for subscribing!\n\n";
        $message .= "Best regards,\nYour Blog Team";

        $mail->Body = $message;
        // Attach thumbnail
        // $mail->addAttachment($thumbnailPath);
        // Send email
        $mail->send();
        update_history($id, $name_email, $send_to);
        return true; // Email sent successfully
    } catch (Exception $e) {
        // Log or handle the error
        error_log('Error sending email: ' . $e->getMessage());
        return false; // Email sending failed
    }
}
sendmailupdate($id, $to, $name, $latest_post);
