<?php $page_title = "Login"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/config.php' ?>
<main class="main-content-container">
  <h1 class="page-header">Login</h1>
   <!-- Display PHP Error Messages (If any) -->
   <?php if (!empty($_SESSION['login_errors'])): ?>
    <div class="php-form-errors-container">
      <ol>
        <?php foreach ($_SESSION['login_errors'] as $error): ?>
          <li class="php-error-li"><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
      </ol>
    </div>
  <?php unset($_SESSION['login_errors']); ?>
   <?php endif; ?>
   <!-- End Display PHP Error Messages -->
    <form id="login-form-page" class="login-form" action="login-process.php" method="POST">
    <div class="input-container">
      <input id="username-input" class="login-input" type="text" name="username" placeholder="Username" required>
      <p id="username-error" class="error-message"></p>
    </div>
    <div class="input-container">
      <input id="password-input"  class="login-input" type="password" name="password" placeholder="Password" required>
      <p id="password-error" class="error-message"></p>
    </div>
    <div class="input-container">
      <input class="submit-input" type="submit" value="Login">
    </div>
  </form>
</main>
<?php include 'includes/footer.php' ?>
