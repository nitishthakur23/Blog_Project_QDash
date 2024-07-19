<?php
require 'config/database.php';
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $deletesave_post_query = "DELETE FROM saved_posts WHERE post_id=$id LIMIT 1";
    $deletesave_post_result = mysqli_query($connection, $deletesave_post_query);
    if (!mysqli_errno($connection)) {
        $_SESSION['delete-saved-post-success'] = "Save Post deleted successfully";
    }
}
header('location:' . ROOT_URL . 'admin/saved_posts.php');
die();
