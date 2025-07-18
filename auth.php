<?php
//Start the session
session_start();

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if($username === 'vip123' && $password === 'vip123') {
  $_SESSION['isLoggedIn'] = true;
  header('Location: members.php');
  exit;
} else {
  header('Location: login.php?error=bad');
  exit;
}

?>