<?php
// Add your connection Code
include "config/database.php";

$input1 = $_POST["input1"];
$input2 = $_POST["input2"];
$input3 = $_POST["input3"];
$input4 = $_POST["input4"];
$send_to_email = $_SESSION['send_to_email'];
$combinedString = $input1 . $input2 . $input3 . $input4;

if ($_SESSION['verification_otp'] == $combinedString) {
    // Properly escape the email address value and enclose it in single quotes
    $escaped_email = mysqli_real_escape_string($connection, $send_to_email);
    
    // Correct the SQL query syntax to include the email address value properly
    $insert_user_query = "INSERT INTO subscribers (verified, subscriber_mail) VALUES (1, '$escaped_email')";
    
    // Execute the query
    $insert_user_query = mysqli_query($connection, $insert_user_query);
    
    // Check if the query was executed successfully
    if ($insert_user_query) {
        unset($_SESSION['send_to_email']);
        unset($_SESSION['verification_otp']);
        echo "Email verified successfully.";
    } else {
        // Handle query execution failure
        echo "Error: " . mysqli_error($connection);
    }
}
?>
