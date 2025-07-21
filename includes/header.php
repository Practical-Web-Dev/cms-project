<header>
  <div class="mobile-menu-btn">
    <i class="fa-solid fa-bars"></i>
  </div>
  <div class="mobile-logo-container">
    logo
  </div>
  <nav class="main-nav">
    <div class="logo-container">
      logo
    </div>
    <ul class="main-nav-menu">
      <li class="nav-li">
        <a href="http://localhost:8888/cms-project/" class="nav-link">Home</a>
      </li>
      <li class="nav-li">
        <a href="http://localhost:8888/cms-project/about.php" class="nav-link">About</a>
      </li>
      <li class="nav-li">
        <a href="http://localhost:8888/cms-project/blog.php" class="nav-link">Blog</a>
      </li>
      <!-- Show these links only if the user is logged in -->
      <?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
      <li class="nav-li">
        <a href="http://localhost:8888/cms-project/admin.php" class="nav-link">Admin</a>
      </li>
      <li class="nav-li">
        <a href="logout.php" class="nav-link">Logout</a>
      </li>
      <?php else: ?>
      <!-- Login/Register linkes Only vidible if not logged in -->
      <li class="nav-li">
        <a href="http://localhost:8888/cms-project/login.php" class="nav-link">Login</a>
      </li>
      <li class="nav-li">
        <a href="http://localhost:8888/cms-project/register.php" class="nav-link">Register</a>
      </li>
      <?php endif;?>
    </ul>
    <?php if (isset($_SESSION['is_logged_in']) && isset($_SESSION['username'])): ?>
    <p class="logged-in-info">Logged in as: <?php echo htmlspecialchars($_SESSION['username']);?></p>
    <?php endif; ?>
  </nav>
</header>