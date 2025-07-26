<!-- 
 


✅ Check login and post ownership
✅ Validate input fields
✅ Handle optional featured image upload
✅ Update the post in the database
✅ Redirect back to admin.php with a success or error message




-->

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
$post_id = $POST['post_id'] ?? null;
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
$image_path = $post['featured_image'];

//LEFT OFF HERE!

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

?>

