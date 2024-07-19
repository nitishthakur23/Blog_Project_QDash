<?php
function  LikeCount($connection, $post_id, $current_user_id) {
    $query_check_like = "SELECT COUNT(*) as like_count FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt_check_like = mysqli_prepare($connection, $query_check_like);
    mysqli_stmt_bind_param($stmt_check_like, 'ii', $post_id, $current_user_id);
    mysqli_stmt_execute($stmt_check_like);
    $result_check_like = mysqli_stmt_get_result($stmt_check_like);
    $row_check_like = mysqli_fetch_assoc($result_check_like);
    return $row_check_like['like_count'] > 0;
}


function Saved_post($connection,$post_id,$current_user_id){
$query_check_saved = "SELECT COUNT(*) as save_count FROM saved_posts WHERE post_id = ? AND user_id = ? limit 1";
$stmt_check_save = mysqli_prepare($connection, $query_check_saved);
mysqli_stmt_bind_param($stmt_check_save, 'ii', $post_id, $current_user_id);
mysqli_stmt_execute($stmt_check_save);
$result_check_save = mysqli_stmt_get_result($stmt_check_save);
$row_check_save = mysqli_fetch_assoc($result_check_save);
return $row_check_save['save_count'] > 0;
}
function Fetch_likes($connection,$post_id){
              //fetch likes from likes table
  $query_likes = "SELECT COUNT(*) as like_count FROM likes WHERE  post_id= $post_id";
  $result = mysqli_query($connection, $query_likes);
  $row = mysqli_fetch_assoc($result);
  return $row['like_count'];
}
function Fetch_views($connection,$post_id){
  //fetch views
  $sql = "SELECT views FROM posts WHERE id = $post_id";
  $result = mysqli_query($connection, $sql);
  $views_count = mysqli_fetch_assoc($result);
  return $views_count['views'];
}
?>