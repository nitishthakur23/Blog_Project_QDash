<?php
include 'config/database.php';

// Check if the post ID is received via POST request
if (isset($_POST['postId'])) {
    // Check if user is logged in
    if (isset($_SESSION['user-id'])) {
        $current_user_id = $_SESSION['user-id'];
        // Sanitize the post ID to prevent SQL injection
        $postId = intval($_POST['postId']);

        // Check if the user has already saved the post
        $query_check_save = "SELECT COUNT(*) as save_count FROM saved_posts WHERE post_id = ? AND user_id = ?";
        $stmt_check_save = mysqli_prepare($connection, $query_check_save);
        mysqli_stmt_bind_param($stmt_check_save, 'ii', $postId, $current_user_id);
        mysqli_stmt_execute($stmt_check_save);
        $result_check_save = mysqli_stmt_get_result($stmt_check_save);
        $row_check_save = mysqli_fetch_assoc($result_check_save);
        $user_has_saved_post = $row_check_save['save_count'] > 0;

        // If the user has not already saved the post, insert save into the database
        if (!$user_has_saved_post) {
            // Insert save into the database
            $query_insert_save = "INSERT INTO saved_posts (post_id, user_id) VALUES (?, ?)";
            $stmt_insert_save = mysqli_prepare($connection, $query_insert_save);
            mysqli_stmt_bind_param($stmt_insert_save, 'ii', $postId, $current_user_id);
            mysqli_stmt_execute($stmt_insert_save);
        }

        echo json_encode(['userHasalreadysavedPost' => $user_has_saved_post]);
    } else {
        echo json_encode(['error' => 'User not logged in']);
    }
} else {
    // If post ID is not received, return error message or handle accordingly
    echo json_encode(['error' => 'Post ID not received']);
}
