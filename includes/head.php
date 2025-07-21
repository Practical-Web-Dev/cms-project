<?php

//Start session if one isn't already started
if(session_status() === PHP_SESSION_NONE) {
  session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/293abf4b96.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styles/style.css">
  <title><?php echo isset($page_title) ? $page_title : 'New Page'?></title>
</head>
<body>