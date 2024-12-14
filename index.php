<?php

session_start();

if (isset($_SESSION['user_id'])){
    header('Location: /templates/dashboard.php');
    exit();
}

?>


<?php include 'templates/header.php'; ?>

<main class="container text-center my-5">
    <div class="card mx-auto" style="max-width: 500px">
        <div class="card-body">
    <h2 class="card-title mb-4">Welcome to Simple File Uploader</h2>
    <p class="card-text mb-4">
        Register or log in to start uploading and managing your files.
    </p>
    <div class="d-grid gap-2">
        <a href="templates/register.php" class="btn btn-primary">Register</a>
        <a href="templates/login.php" class="btn btn-secondary">Login</a>
    </div>
    </div>
    </div>
</main>

<?php include 'templates/footer.php'; ?>
