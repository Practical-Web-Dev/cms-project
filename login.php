<?php
//Start the session
session_start();
?>
<?php $page_title = "Login"; ?>
<?php include 'includes/head.php' ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/config.php' ?>
<main class="main-content-container">
  <h1 class="page-header">Login</h1>
  <?php
  //Check if the user is already logged in, and if they are, let them know and ask if they want to go back to the members area
  if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    echo "<p>You are already logged in.</p>";
    echo "<p><a href='members.php'>Go to members area</a></p>";
    echo "<p><a href='logout.php'>Logout</a></p>";
  } else {
  ?>
  <form class="login-form" action="auth.php" method="POST">
    <div class="input-container">
      <input class="login-input" type="text" name="username" placeholder="Username">
    </div>
    <div class="input-container">
      <input class="login-input" type="password" name="password" placeholder="Password">
    </div>
    <div class="input-container">
      <input class="submit-input" type="submit" value="Login">
    </div>
  </form>

  <?php
  //If the user logged in with the wrong credentials, get that information from the query string set in auth.php and display the appropriate error message
  if(isset($_GET['error']) && $_GET['error'] === 'bad') {
    echo "<p class='error-message'>Invalid username or password</p>";
  }

  // This code will activate if the user tries to get to the members page by clicking the members link without being logged in
  if(isset($_GET['error']) && $_GET['error'] === 'blocked') {
    echo "<p class='error-message'>Access denied. Please log in.</p>";
  }

}
  ?>
</main>
<?php include 'includes/footer.php' ?>