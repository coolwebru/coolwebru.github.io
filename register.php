<?php
$servername = "localhost";
$username = "root";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ss", $username, $password_hash);
  $stmt->execute();

  if ($stmt->affected_rows == 1) {
    header("Location: login.php");
    exit();
  } else {
    $error = "Registration failed. Please try again.";
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - My Site</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h1>Register</h1>
  <?php if (isset($error)) { echo "<p class=\"error\">$error</p>"; } ?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
