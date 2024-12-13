<?php

session_start();

if (isset($_SESSION['user_id'])){
    header('Location: /templates/dashboard.php');
    exit();
}

?>


<?php include 'templates/header.php'; ?>

<main>
    <h2>Welcome</h2>
    <p><a href="templates/register.php">Register</a> or <a href="templates/login.php">Login</a> to start uploading files. </p>
</main>

<?php include 'templates/footer.php'; ?>
