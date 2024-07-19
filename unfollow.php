<?php
include 'config/database.php';


if (isset($_POST['following_id'])) {
  $following_id = mysqli_real_escape_string($connection, $_POST['following_id']);
  $user_id = $_SESSION['user-id'];

  $sql = "DELETE FROM followers WHERE user_id=? AND follower_id=?";
  $stmt = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
  echo json_encode(['unfollow' => 'SQL error']);
  }
  mysqli_stmt_bind_param($stmt, "ii", $following_id, $user_id);
  mysqli_stmt_execute($stmt);
  $_SESSION['un-follow']= "You are Unfollowing.";
  header('location:' . ROOT_URL . 'User_profile.php?id='.$following_id);
  die();
} else {
    header('location:' . ROOT_URL . 'User_profile.php?id='.$following_id);
  die();
}