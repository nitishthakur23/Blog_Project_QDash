<?php
include 'config/database.php';

if (!isset($_POST['following_id']) || !isset($_SESSION['user-id'])) {
  echo json_encode(['follow' => 'Missing required parameter']);
}
if (isset($_POST['following_id']) || isset($_SESSION['user-id'])) {
$following_id = mysqli_real_escape_string($connection, $_POST['following_id']);
$user_id = $_SESSION['user-id'];

$sql = "INSERT INTO followers (user_id, follower_id) VALUES (?, ?)";
$stmt = mysqli_stmt_init($connection);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  echo json_encode(['follow' => 'SQL error']);

}

mysqli_stmt_bind_param($stmt, "ii", $following_id, $user_id);
if (!mysqli_stmt_execute($stmt)) {
  echo json_encode(['follow' => 'Database error']);

}

$_SESSION['follow-success']= "You are Following.";
header('location:' . ROOT_URL . 'User_profile.php?id='.$following_id);
die();
}else{
header('location:' . ROOT_URL . 'User_profile.php?id='.$following_id);
die();
}
?>

