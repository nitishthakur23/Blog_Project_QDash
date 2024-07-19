<?php
include 'config/database.php';

// Check if the post ID is received via POST request
if(isset($_POST['postId'])) {
    // Check if user is logged in
    if(isset($_SESSION['user-id'])) {
        $current_user_id = $_SESSION['user-id'];
        // Sanitize the post ID to prevent SQL injection
        $postId = intval($_POST['postId']);

        // Delete save from the database
        $query_delete_save = "DELETE FROM saved_posts WHERE post_id = ? AND user_id = ?";
        $stmt_delete_save = mysqli_prepare($connection, $query_delete_save);
        mysqli_stmt_bind_param($stmt_delete_save, 'ii', $postId, $current_user_id);
        mysqli_stmt_execute($stmt_delete_save);

        echo json_encode(['success' => 'Unsaved Post']);
    } else {
        echo json_encode(['error' => 'User not logged in']);
    }
} else {
    // If post ID is not received, return error message or handle accordingly
    echo json_encode(['error' => 'Post ID not received']);
}
?>