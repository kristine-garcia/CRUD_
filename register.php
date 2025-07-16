<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars(string: $_POST['fullname']);
    $email = htmlspecialchars(string: $_POST['email']);
    $username = htmlspecialchars(string: $_POST['username']);
    $password = htmlspecialchars(string: $_POST['password']);
    $confirm_password = htmlspecialchars(string: $_POST['confirm_password']);

    if (empty($fullname) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare(query: "SELECT username, email FROM users WHERE username = :username OR email = :email");
        $stmt->execute(params: ['username' => $username, 'email' => $email]);
        if ($stmt->rowCount() > 0) {
            $error = "Username or email already exists.";
        } else {
            $hashed_password = password_hash(password: $password, algo: PASSWORD_DEFAULT);
            $stmt = $conn->prepare(query: "INSERT INTO users (fullname, email, username, password, created_at) VALUES (:fullname, :email, :username, :password, NOW())");
            $stmt->execute(params: ['fullname' => $fullname, 'email' => $email, 'username' => $username, 'password' => $hashed_password]);
            header(header: "Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <register>Register</h1>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <div><input type="text" name="fullname" placeholder="Full Name" required></div>
        <div><input type="email" name="email" placeholder="Email" required></div>
        <div><input type="text" name="username" placeholder="Username" required></div>
        <div><input type="password" name="password" placeholder="Password" required></div>
        <div><input type="password" name="confirm_password" placeholder="Confirm Password" required></div>
        <div><input type="submit" value="Register"></div>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
