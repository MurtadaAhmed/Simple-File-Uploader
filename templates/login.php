<?php

require '../scripts/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login_user($username, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

<?php include 'header.php'; ?>
<main>
<h1>Login</h1>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
</main>
<?php include 'footer.php'; ?>
