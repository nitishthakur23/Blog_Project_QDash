<?php
// Include the database configuration file
include 'config/database.php';

// Check if the request method is GET and if postId parameter is set
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['postId'])) {
    // Sanitize the postId parameter to ensure it contains only integers
    $post_id = filter_input(INPUT_GET, 'postId', FILTER_SANITIZE_NUMBER_INT);

    // Prepare SQL query to fetch comments associated with the given postId
    $comments_query = "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC";

    // Prepare the SQL statement for execution
    $stmt = mysqli_prepare($connection, $comments_query);

    // Bind postId parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, 'i', $post_id);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result set from the executed statement
    $comments_result = mysqli_stmt_get_result($stmt);



    // Output comments as HTML
    while ($comment = mysqli_fetch_assoc($comments_result)) {
        $users_query = "SELECT avatar,username FROM users WHERE  id=?";
        // Prepare the SQL statement for execution
        $stmt = mysqli_prepare($connection, $users_query);

        // Bind postId parameter to the prepared statement
        mysqli_stmt_bind_param($stmt, 'i', $comment['user_id']);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Get the result set from the executed statement
        $users_result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($users_result);
        // Output HTML for each comment
        echo '<div class="comments">';
        echo'<div class="post__author"> ';
        echo'      <div class="post__author-avatar">        ';
        echo'<img src="./images/'. htmlspecialchars( $user['avatar']).'">';
        echo '</div>';
        echo'<div class="post__author-info">';
        echo' <h5>By: '. htmlspecialchars($user['username']).'</h5>' ;
        echo '<small>' . ' on ' . date("M d, Y", strtotime($comment['created_at'])) . '</small>';
        echo '</div>';
        echo'</div>';
        echo '<p>' . htmlspecialchars($comment['comment_content']) . '</p>'; // Sanitize output
        echo '</div>';
    }
}
