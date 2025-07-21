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
  <h1 class="page-header">Admin</h1> 

</main>
<?php include 'includes/footer.php' ?>