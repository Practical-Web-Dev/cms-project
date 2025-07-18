<?php

$host = "localhost";
$user = "root";
$password = "root"; //XAAMP ""
$db_name = "cms_db";

$conn = mysqli_connect($host, $user, $password, $db_name);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>