<?php

require '../scripts/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login_user($username, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<?php include 'header.php'; ?>
<main class="container d-flex justify-content-center align-items-center">
    <div class="card" style="max-width: 400px; width: 100%;">
        <div class="card-body">
        <h2 class="card-title text-center mb-4">Login</h2>
            <?php if (isset($error)) : ?>
            <div class="aler alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>
