<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = htmlspecialchars(string: $_POST['identifier']);
    $password = htmlspecialchars(string: $_POST['password']);

    $stmt = $conn->prepare(query: "SELECT * FROM users WHERE username = :identifier OR email = :identifier");
    $stmt->execute(params: ['identifier' => $identifier]);
    $user = $stmt->fetch();

    if ($user && password_verify(password: $password, hash: $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header(header: "Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username/email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="identifier" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
      
        <input type="submit" value="Login">
    </form>
    <p><h6>Don't have an account? <a href="register.php">Register</a></h6></p>
</body>
</html>
