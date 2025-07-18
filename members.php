<?php
session_start();
// If the user tries to get into the members area without being logged in, kick them back to the login page and display error message
if(!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
  header('Location: login.php?error=blocked');
}
?>
<?php $page_title = "Members Only"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
  <h1>Welcome, VIP</h1>
  <p>You are in the members area.</p>
  <a href="logout.php">Logout</a>
<?php include 'includes/footer.php' ?>
