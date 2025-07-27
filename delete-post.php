

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
$user_id = $_SESSION['user_id'];

if(!$post_id) {
  $_SESSION['error_message'] = "Invalid post ID";
  header("Location: your-posts.php");
  exit;
}

//Check if post exists and belongs to the logged in user
$stmt = $conn->prepare("SELECT featured_image FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
  $_SESSION['error_message'] = "Post not found or permission denied";
   header("Location: your-posts.php");
  exit;
}

$post = $result->fetch_assoc();
$image_path = $post['featured_image'] ?? null;

//Delete Post
$delete_stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$delete_stmt->bind_param("ii", $post_id, $user_id);

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
