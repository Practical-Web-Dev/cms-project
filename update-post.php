<?php
session_start();
require_once 'includes/config.php';

//Check is the user is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
header("Location: admin.php");
exit;
}

//Grab form inputs and sanitize. If input is empty it is set to null
$post_id = $_POST['post_id'] ?? null;
$title = trim($_POST['post-title'] ?? null);
$content = trim($_POST['post-content'] ?? null);
$user_id = $_SESSION['user_id'] ?? null;


//Validate Inputs
if(!$post_id || !$title || !$content || !$user_id) {
  $_SESSION['error_message'] = 'All fields are required';
  header("Location: edit-post.php?id=" . urlencode($post_id));
  exit;
}


//Check of the post belongs to the user
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

//If the post ID and user ID don't match or don't exist
if ($result->num_rows === 0) {
  $_SESSION['error_message'] = 'Post not found or access denied';
  header("Location admin.php");
  exit;
}

$post = $result->fetch_assoc();
$image_path = $post['featured-image'];

//Handle New Featured Image Upload (if the user uploads a new image)
if (isset($_FILES['featured-image']) && $_FILES['featured-image']['error']=== UPLOAD_ERR_OK) {

$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$file_type = $_FILES['featured-image']['type'];

if(in_array($file_type, $allowed_types)) { 
  $upload_dir = 'uploads/';
  $new_image_name = uniqid('img_') . '_' . basename($_FILES['featured-image'] ['name']);
  $upload_path = $upload_dir . $new_image_name;

if(move_uploaded_file($_FILES['featured-image'] ['tmp_name'], $upload_path)){
  $image_path = $upload_path;
} else {
  $_SESSION['error_message'] = 'Image upload failed.';
  header("Location: edit-post.php?id=" . urldecode($post_id));
  exit;
}

} else {
  $_SESSION['error_message'] = "Invalid image file type detected. Image must be jpeg, png, or gif";
  header("Location: edit-post.php?id=" . urldecode($post_id));
  exit;
}

}


//Insert into Database
$stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, featured_image = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("sssii", $title, $content, $image_path, $post_id, $user_id);

if($stmt->execute()) {
  $_SESSION['success_message'] = "Post was successfully updated";
  header("Location: your-posts.php");
  exit;
} else {
   header("Location: edit-post.php?id=" . urlencode($post_id));
  exit;
}

$stmt->close();
$conn->close();


?>

