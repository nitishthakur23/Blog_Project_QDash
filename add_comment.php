<?php
include 'config/database.php';
// Check if the request method is POST and if post_id and comment parameters are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    // Check if user is logged in
    if(isset($_SESSION['user-id'])) {
        // Validate and sanitize form inputs
        $post_id=$_POST['post_id'];;
        $comment = $_POST['comment']; // No need to sanitize for TEXT type column
        $current_user_id = $_SESSION['user-id'];
        
        // Insert comment into database
        $query = "INSERT INTO comments (post_id, user_id, comment_content) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iis', $post_id, $current_user_id, $comment);
            if (mysqli_stmt_execute($stmt)) {
                // Comment inserted successfully
                echo json_encode(['success' => 'Comment inserted successfully']);
            } else {
                // Error executing SQL statement
                echo json_encode(['error' => 'Error executing SQL statement: ' . mysqli_error($connection)]);
            }
        } else {
            // Error preparing SQL statement
            echo json_encode(['error' => 'Error preparing SQL statement: ' . mysqli_error($connection)]);
        }
    } else {
        // User not logged in
        echo json_encode(['error' => 'User not logged in']);
    }
} else {
    // If post ID or comment is not received, return error message
    echo json_encode(['error' => 'Invalid request: Post ID or comment not received']);
}
?>
