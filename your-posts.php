<?php
session_start();
require_once 'includes/config.php';


//Check if user is logged in
if(!isset($_SESSION['is_logged_in'])) {
  header("Location: login.php");
  exit;
}

$success_message = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

//Fetch Posts By User That is Logged in
$role = $_SESSION['role'] ?? 'user';
if ($role === 'admin') {
  //Admin can see all posts
  $stmt = $conn->prepare("SELECT posts.id, posts.title, posts.created_at, cms_users.username
   FROM posts 
   JOIN cms_users 
   ON posts.user_id = cms_users.id 
   ORDER BY created_at DESC");
} else {
  //Author only see own posts
    $stmt = $conn->prepare("SELECT posts.id, posts.title, posts.created_at, cms_users.username
   FROM posts 
   JOIN cms_users 
   ON posts.user_id = cms_users.id 
   WHERE posts.user_id = ?
   ORDER BY created_at DESC");
   $stmt->bind_param("i", $_SESSION['user_id']);
}

$stmt->execute();
$result = $stmt->get_result();

?>
<?php $page_title = "Your Posts"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<main class="main-content-container">
  <h1 class="page-header">Your Posts</h1>
  <!-- Success Message Display -->
  <?php if ($success_message): ?>
  <div class="success-message">
    <?php echo htmlspecialchars($success_message); ?>
  </div>
  <?php endif; ?>
  <!-- Error message display -->
  <?php if (!empty($_SESSION['error_message'])): ?>
  <div class="error-message">
    <?php echo htmlspecialchars($_SESSION['error_message']); ?>
  </div>
  <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>
  <section class="dashboard-container">
    <div class="admin-sidebar-container">
      <nav class="admin-nav">
        <ul class="admin-nav-menu">
          <li class="admin-nav-li">
            <a class="admin-nav-link" href="admin.php">Create Post</a>
          </li>
          <li class="admin-nav-li">
            <a class="admin-nav-link active-link" href="your-posts.php">Your Posts</a>
          </li>
          <li class="admin-nav-li">
            <a class="admin-nav-link" href="manage-posts.php">Manage Posts</a>
          </li>
          <li class="admin-nav-li">
            <a class="admin-nav-link" href="blog.php">View Blog</a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="admin-main-page-container">
      <table class="db-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($post = $result->fetch_assoc()): ?>
          <tr>
            <td class="post-title-table">
              <?php echo htmlspecialchars($post['title']); ?>
            </td>
            <td>
              <?php echo $post['created_at']; ?>
            </td>
            <td>
              <a href="view-post.php?id=<?php echo $post['id']; ?>">View</a> |
              <a href="edit-post.php?id=<?php echo $post['id']; ?>">Edit</a> |
              <a href="delete-post.php?id=<?php echo $post['id']; ?>">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </section>
</main>
<?php include 'includes/footer.php' ?>