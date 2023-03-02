<?php
session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

// Display content for logged in users
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Site</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h1>Welcome to My Site</h1>
  <p>This is some content that only logged in users can see.</p>
  <a href="logout.php">Logout</a>
</body>
</html>