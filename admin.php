<?php $page_title = "Admin"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<?php

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
  $_SESSION['login_errors'] = ['Please login to access the admin page'];
  header("Location: login.php");
  exit;
}

?>
<main class="main-content-container">
  <!-- Show success Message on screen -->
  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="php-form-errors-container success-message">
      <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
  <?php endif; ?>
  <!-- Show Error message -->
     <?php if (isset($_SESSION['error_message'])): ?>
    <div class="php-form-errors-container error-message">
      <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
    </div>
  <?php endif; ?>
  <section class="dashboard-container">
    <div class="admin-sidebar-container">
      <nav class="admin-nav">
        <ul class="admin-nav-menu">
          <li class="admin-nav-li">
            <a class="admin-nav-link active-link" href="#">Create Post</a>
          </li>
          <li class="admin-nav-li">
            <a class="admin-nav-link" href="your-posts.php">Your Posts</a>
          </li>
          <li class="admin-nav-li">
            <a class="admin-nav-link" href="#">Manage Posts</a>
          </li>
          <li class="admin-nav-li">
            <a class="admin-nav-link" href="blog.php">View Blog</a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="admin-main-page-container">
      <form id="blog-post-form" action="create-post.php" method="POST" enctype="multipart/form-data" class="create-post-form">
        <div class="input-container">
          <label for="post-title">Post Title:</label>
          <input class="post-title-input" type="text" id="post-title" name="post-title" required>
        </div>
        <div class="input-container">
          <textarea name="post-content" id="post-content" rows="10"></textarea>
        </div>
        <div class="input-container">
          <label for="featured-image">Featured Image:</label>
          <input type="file" id="featured-image" name="featured-image" accept="image/*">
        </div>
        <div class="input-container">
          <button class="btn create-post-btn" type="submit">Create Post</button>
        </div>
      </form>
    </div>
  </section>
</main>
<?php include 'includes/footer.php' ?>