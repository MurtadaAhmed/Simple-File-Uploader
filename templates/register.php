<?php
require 'scripts/auth.php';
require 'scripts/mailer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $verification_code = bin2hex(random_bytes(16));

    if (register_user($username, $email, $password, $verification_code)) {
        send_verification_email($email, $verification_code);
        echo "Registration successful! Check your email to verify your account.";
    } else {
        echo "Username or email already exists.";
    }

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>

<body>
<h1>Register</h1>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>
</body>
</html>