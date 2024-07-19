<?php
include 'config/database.php';

// Check if the post ID is received via POST request
if(isset($_POST['postId'])) {
    // Check if user is logged in
    if(isset($_SESSION['user-id'])) {
        $current_user_id = $_SESSION['user-id'];
        // Sanitize the post ID to prevent SQL injection
        $postId = intval($_POST['postId']);

        // Delete like from the database
        $query_delete_like = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt_delete_like = mysqli_prepare($connection, $query_delete_like);
        mysqli_stmt_bind_param($stmt_delete_like, 'ii', $postId, $current_user_id);
        mysqli_stmt_execute($stmt_delete_like);

        // Return updated like count for the post
        $query_get_like_count = "SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?";
        $stmt_get_like_count = mysqli_prepare($connection, $query_get_like_count);
        mysqli_stmt_bind_param($stmt_get_like_count, 'i', $postId);
        mysqli_stmt_execute($stmt_get_like_count);
        $result_get_like_count = mysqli_stmt_get_result($stmt_get_like_count);
        $row_get_like_count = mysqli_fetch_assoc($result_get_like_count);
        $likeCount = $row_get_like_count['like_count'];

        echo json_encode(['likeCount' => $likeCount]);
    } else {
        echo json_encode(['error' => 'User not logged in']);
    }
} else {
    // If post ID is not received, return error message or handle accordingly
    echo json_encode(['error' => 'Post ID not received']);
}
?>