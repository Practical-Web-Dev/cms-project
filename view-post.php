<?php 
session_start();
require_once 'includes/config.php';

//Check if user is logged in - If Not, go back to login page
if(!isset($_SESSION['is_logged_in'])) {
  header("Location: login.php");
  exit;
}

$post_id = $_GET['id'] ?? null;

if(!$post_id) {
  die("Post not Found");
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

?>
<?php $page_title = "View Post"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<main class="main-content-container">
  <h1 class="page-header">
    <?php echo htmlspecialchars($post['title']); ?>
  </h1>


  <?php if (!empty($post['featured_image'])): ?>
  <img class="featured-img m-bottom" src="<?php echo htmlspecialchars($post['featured_image']);?>"
    alt="blog post image">
  <?php endif; ?>

  <p class="blog-text">
    <?php echo nl2br($post['content']);?>
  </p>

  <p><strong>Created At:</strong>
    <?php echo $post['created_at']; ?>
  </p>

  <ul class="crud-nav">
    <li class="crud-nav-link">
      <a class="crud-link" href="edit-post.php?id=<?php echo $post['id']; ?>">Edit</a> |
      <a class="crud-link" href="delete-post.php?id=<?php echo $post['id']; ?>">Delete</a> |
      <a class="crud-link" href="your-posts.php">Back to Your Posts</a>
    </li>
  </ul>

</main>
<?php include 'includes/footer.php' ?>