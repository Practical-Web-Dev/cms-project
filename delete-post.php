<?php
session_start();
require_once 'includes/config.php';

//Check is the user is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
  header("Location: login.php");
  exit;
}

//Validate Post ID
$post_id = $_GET['id'] ?? null;
$current_user_id = $_SESSION['user_id'];
$current_user_role = $_SESSION['role'] ?? 'user';

if(!$post_id) {
  $_SESSION['error_message'] = "Invalid post ID";
  header("Location: your-posts.php");
  exit;
}

//Check if post exists and belongs to the logged in user
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
  $_SESSION['error_message'] = "Post not found or permission denied";
  header("Location: your-posts.php");
  exit;
}

$post = $result->fetch_assoc();
$image_path = $post['featured_image'] ?? null;

//Check permissions based on user role
if($current_user_role !== 'admin' && $post['user_id'] != $current_user_id) {
  $_SESSION['error_message'] = "You are not authorized to delete this post";
  header("Location: your-posts.php");
  exit;
}

//Delete Post
$delete_stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$delete_stmt->bind_param("i", $post_id);

if ($delete_stmt->execute()) {
  //Delete image from server if it exists
  if($image_path && file_exists($image_path)) {
    unlink($image_path);
  }

$_SESSION['success_message'] = "Post successfully deleted";

} else {
  $_SESSION['error_message'] = "Failed to delete post";
}


$delete_stmt->close();
$conn->close();

  header("Location: your-posts.php");
  exit;

?>
