<?php

require 'scripts/auth.php';

global $conn;

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $stmt = $conn->prepare("UPDATE users SET emai_verified=1 WHERE verification_code = ? ");
    $stmt->bind_param("s", $code);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "Email verified successfully! <a href='login.php'>Login here</a>";
    } else {
        echo "Invalid or expired verification code.";
    }
}
?>