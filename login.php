<?php
session_start();

if (isset($_SESSION["user_id"])) {
  header("Location: index.php");
  exit();
}

$servername = "localhost";
$username = "root";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
      $_SESSION["user_id"] = $row["id"];
      header("Location: index.php");
      exit();
    } else {
      $error = "Invalid username or password";
    }
  } else {
    $error = "Invalid username or password";
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - My Site</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h1>Login</h1>
  <?php if (isset($error)) { echo "<p class=\"error\">$error</p>"; } ?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>
