
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

$user_id = $_SESSION['user_id'];

//Fetch Posts By User That is Logged in
$stmt = $conn->prepare("SELECT id, title, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<?php $page_title = "Post Title"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<main class="main-content-container">
  <h1 class="page-header">Your Posts</h1>
  <?php if ($success_message): ?>
    <div class="success-message">
      <?php echo htmlspecialchars($success_message); ?>
    </div>
  <?php endif; ?>
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
        <td class="post-title-table"><?php echo htmlspecialchars($post['title']); ?></td>
        <td><?php echo $post['created_at']; ?></td>
        <td>
          <a href="view-post.php?id=<?php echo $post['id']; ?>">View</a> |
          <a href="edit-post.php?id=<?php echo $post['id']; ?>">Edit</a> |
          <a href="delete-post.php?id=<?php echo $post['id']; ?>">Delete</a> 
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</main>
<?php include 'includes/footer.php' ?>