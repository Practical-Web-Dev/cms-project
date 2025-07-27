<?php
require_once 'includes/config.php';
 $result = $conn->query("SELECT posts.*, cms_users.username FROM posts JOIN cms_users ON posts.user_id = cms_users.id ORDER BY posts.created_at DESC");
?>
<?php $page_title = "Blog"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<main class="main-content-container">
  <h1 class="page-header">Blog</h1>
  <?php while ($post = $result->fetch_assoc()):?>
  <div class="blog-post">
    <h2 class="post-heading"><?php echo htmlspecialchars($post['title']);?></h2>
    <p class="post-meta"><?php echo "Written by: " . htmlspecialchars($post['username']); ?></p>
    <?php if (!empty($post['featured_image'])): ?>
    <img class="featured-img m-bottom" src="<?php echo htmlspecialchars($post['featured_image']);?>" alt="blog post image">
    <?php endif; ?>
    <p class="blog-text">
      <?php echo substr(strip_tags($post['content']),0,200) . '...';?>
    </p>
    <a class="btn-link purple-bg" href="blog-post.php?id=<?php echo $post['id']; ?>">Read More</a>
  </div>
  <?php endwhile; ?>
</main>
<?php include 'includes/footer.php' ?>


