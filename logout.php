<?php
session_start();

//Remove all session variables 
session_unset();

//Destroy a;; records in the session and close it
session_destroy();

//Start back at the empty login page
header('Location: login.php');
exit;

?>