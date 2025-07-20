<?php
session_start();
require_once 'includes/config.php';

$_SESSION['login_errors'] = [];

//Check if login data was sent via POST
if($_SERVER['REQUEST_METHOD'] === 'POST') {

//Get and sanitize user inputs
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

//Validate Inputs
if (empty($username)) {
  $_SESSION['login_errors'] [] = 'Username is required';
}

if (empty($password)) {
  $_SESSION['login_errors'] [] = 'Password is required';
}


//Query DB if no form validation errors occur
if(empty($_SESSION['login_errors'])) {

//Prepared statement to find user by username
$stmt = $conn->prepare("SELECT id, username, password FROM cms_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();


//Check if user exists
if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

//Verify Password
if(password_verify($password, $user['password'])) {

  //Set a session and redirect to the admin
  $_SESSION['is_logged_in'] = true; //Create boolean so php knows they are successfully logged in
  $_SESSION['user_id'] = $user['id']; //Store the users ID number from their actual ID in our database
  $_SESSION['username'] = $user['username']; //Store the username in the session
  header("Location: admin.php");
  exit;

} else {
  $_SESSION['login_errors'][] = "Incorrect Password";
}


} else {
  $_SESSION['login_errors'][] = "User not found";
}

$stmt->close();

 }

} 

//Redirect Back to Login Page and Display errors
header("Location: login.php");
exit;



?>