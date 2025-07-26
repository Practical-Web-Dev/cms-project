<?php
session_start();
require_once 'includes/config.php';

//Check is the user is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$title = trim($_POST['post-title']);
$content = $_POST['post-content'];
$user_id = $_SESSION['user_id'];
$image_path = null;

//Validate post content input
if (empty($content)) {
  $_SESSION['error_message'] = "Post content cannot be empty!";
  header("Location: admin.php");
  exit;
}

//Handle Featured Image Upload
if (!empty($_FILES['featured-image'] ['name'])) {
  $target_dir = "uploads/";
  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
  }

  //Disguise file path for featured image
  $image_name = basename($_FILES['featured-image'] ['name']);
  //Create final file upload path and time stamp it
  $target_file = $target_dir . time() . '_' . $image_name;

  //If a featured image exists, store the final file path in the $image_path variable
if(move_uploaded_file($_FILES["featured-image"]["tmp_name"], $target_file)) {
  $image_path = $target_file;
}

}

//Insert into Database
$stmt = $conn->prepare("INSERT INTO posts (title, content, featured_image, user_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $title, $content, $image_path, $user_id);

if($stmt->execute()) {
  $_SESSION['success_message'] = "Post was successfully created";
} else {
  $_SESSION['error_message'] = "Something went wrong. Please try again";
}

$stmt->close();
$conn->close();

header("Location: admin.php");
exit;
}
?>

