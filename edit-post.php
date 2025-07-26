<?php
session_start();
require_once 'includes/config.php'; 

//Check if user is logged in
if(!isset($_SESSION['is_logged_in'])) {
  header("Location: login.php");
  exit;
}

//Get post ID from Database
$post_id = $_GET['id'] ?? null;

if (!$post_id) {
  die("Error: Post ID is missing");
}

//Fetch Posts from database uisng prepared statements
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
  die("Post not found");
}

$post = $result->fetch_assoc();

//Check post ownership
if ($_SESSION['user_id'] != $post['user_id']) {

  die("You are not authorized to edit this post!");
}

?>
<?php $page_title = "Edit Post"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<main class="main-content-container">
  <h1 class="page-header">Edit Post</h1>
  <div class="admin-main-page-container">
    <form id="blog-post-form" action="update-post.php" method="POST" enctype="multipart/form-data"
      class="create-post-form">
      <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
      <div class="input-container">
        <label for="post-title">Post Title:</label>
        <input class="post-title-input" type="text" id="post-title" name="post-title"
          value="<?php echo htmlspecialchars($post['title']); ?>" required>
      </div>
      <div class="input-container">
        <textarea name="post-content" id="post-content"
          rows="10"><?php echo htmlspecialchars($post['content']); ?> </textarea>
      </div>
      <div class="input-container">
        <?php if (!empty($post['featured_image'])): ?>
          <p>Current Featured Image:</p>
        <img class="featured-img m-bottom" src="<?php echo htmlspecialchars($post['featured_image']);?>">
        <?php endif; ?>
      </div>

         <div class="input-container">
          <label for="featured-image">Change Featured Image (Optional):</label>
          <input type="file" id="featured-image" name="featured-image" accept="image/*">
        </div>

      <div class="input-container">
        <button class="btn create-post-btn" type="submit">Update Post</button>
      </div>
    </form>
  </div>
  <ul class="crud-nav">
    <li class="crud-nav-link">
      <a class="crud-link" href="edit-post.php?id=<?php echo $post['id']; ?>">Edit</a> |
      <a class="crud-link" href="delete-post.php?id=<?php echo $post['id']; ?>">Delete</a> |
      <a class="crud-link" href="your-posts.php">Back to Your Posts</a>
    </li>
  </ul>
</main>
<?php include 'includes/footer.php' ?>