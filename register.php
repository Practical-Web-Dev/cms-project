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
    <form class="login-form" method="POST">
    <div class="input-container">
      <input id="username-input" class="login-input" type="text" name="username" placeholder="Username" required>
      <p id="username-error" class="error-message"></p>
    </div>
    <div class="input-container">
      <input id="email-input"  class="login-input" type="text" name="email" placeholder="Email" required>
      <p id="email-error" class="error-message"></p>
    </div>
    <div class="input-container">
      <input id="password-input"  class="login-input" type="password" name="password" placeholder="Password" required>
      <p id="password-error" class="error-message"></p>
    </div>
    <div class="input-container">
      <input id="confirm-password-input"  class="login-input" type="password" name="confirm_password" placeholder="Confirm Password" required>
      <p id="confirm-password-error" class="error-message"></p>
    </div>
    <div class="input-container">
      <input class="submit-input" type="submit" value="Register">
    </div>
  </form>
</main>
<?php include 'includes/footer.php' ?>