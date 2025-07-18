<?php
//Start the session
session_start();
?>
<?php $page_title = "Register"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/config.php' ?>
<main class="main-content-container">
  <h1 class="page-header">Register</h1>
    <form class="login-form" action="auth.php" method="POST">
    <div class="input-container">
      <input class="login-input" type="text" name="username" placeholder="Username">
    </div>
    <div class="input-container">
      <input class="login-input" type="text" name="email" placeholder="Email">
    </div>
    <div class="input-container">
      <input class="login-input" type="password" name="password" placeholder="Password">
    </div>
    <div class="input-container">
      <input class="login-input" type="password" name="confirm_password" placeholder="Confirm Password">
    </div>
    <div class="input-container">
      <input class="submit-input" type="submit" value="Register">
    </div>
  </form>
</main>
<?php include 'includes/footer.php' ?>