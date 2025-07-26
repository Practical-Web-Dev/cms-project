<?php 
require_once 'includes/config.php';

$post_id = $_GET['id'] ?? null;

if(!$post_id) {
  die("Post not Found");
}

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
  die("Post not found");
}

$post = $result->fetch_assoc();

?>
<?php $page_title = "Post Title"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<main class="main-content-container">
  <h1 class="page-header">Blog</h1>
  <div class="blog-post">
    <h2 class="post-heading"><?php echo htmlspecialchars($post['title']);?></h2>
    <?php if (!empty($post['featured_image'])): ?>
    <img class="featured-img m-bottom" src="<?php echo htmlspecialchars($post['featured_image']);?>" alt="blog post image">
    <?php endif; ?>
    <p class="blog-text">
      <?php echo nl2br($post['content']);?>
    </p>
    <a class="btn-link purple-bg" href="blog.php">Back to Blog</a>
  </div>
</main>
<?php include 'includes/footer.php' ?>