<?php
session_start();
require_once 'includes/config.php';

//Check is the user is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
  header("Location: login.php");
  exit;
}

?>