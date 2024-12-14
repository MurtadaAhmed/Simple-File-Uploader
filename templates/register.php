<?php
require '../scripts/auth.php';
require '../scripts/mailer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $verification_code = bin2hex(random_bytes(16));

    if (register_user($username, $email, $password, $verification_code)) {
        send_verification_email($email, $verification_code);
        $success_message= "Registration successful! Check your email to verify your account.";
    } else {
        $error_message= "Username or email already exists.";
    }

}

?>


<?php include 'header.php';?>
<main class="container d-flex justify-content-center align-items-center">
    <div class="card" style="max-width: 500px; width: 100%;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Register</h2>

            <?php if(isset($success_message)): ?>
                <div class="aler alert-success" role="alert">
                    <?php echo htmlspecialchars($success_message) ?>
                </div>
            <?php endif;?>

            <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <?php endif;?>

            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>