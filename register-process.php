<?php
session_start();
require_once 'includes/config.php';

//Helper function to sanitize inputs
function sanitize_input($data) {

return htmlspecialchars(trim($data));

}

//Collect and Santize Input Data
$username = sanitize_input($_POST['username'] ?? '');
$email = sanitize_input($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';


//Server Side Validation
$errors = [];

//Validate username
if(!preg_match('/^[a-zA-Z0-9]{3,}$/', $username)) {
  $errors[] = "Username must be at least 3 characters and only letters and numbers";
}

//Validate Email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "Invalid email format";
}

//Validate Password
if(!preg_match('/^(?=.*\d)(?=.*[\W_]).{6,}$/', $password)) {
    $errors[] = "Password must be at least 6 characters, include a number, and one special chracter";
}


//Validate Confirm Password Input
if($password !== $confirm_password) {
  $errors[] = "Passwords do not match";
}


//Check if error messages are present in the $errors array, and if they are, sends the user back to the register page and diplays the errors
if(!empty($errors)) {
  $_SESSION['register_errors'] = $errors;
  header("Location: register.php");
  exit;
}

//Prepared Statement
//1. Prepare the SQL query (with placeholders (?))
//2. Bind the actual user input values to those placeholders
//3. Execute the query

//Check if username or email already exists
$stmt = $conn->prepare("SELECT id FROM cms_users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows > 0) {
  $_SESSION['register_errors'] = ["Username or email already taken"];
  $stmt->close();
  header("Location: register.php");
  exit;
}

 $stmt->close();


 //Hashing Passwords (password123 - $2y$10$9lU9.VaBcR5WlzPYyoMRfOxuOaGn7HOZ.Rasw3fySmVJ3gygJPAvC)
 $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

//Insert new user into database (Finally!)
$stmt = $conn->prepare("INSERT INTO cms_users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

if($stmt->execute()) {
  $_SESSION['success_message'] = "Registration Succesful. Please log in";
  header("Location: login.php");
} else {
  $_SESSION['register_errors'] = ["Something went wrong. Please try agian"];
   header("Location: register.php");
}

$stmt->close();
$conn->close();

?>