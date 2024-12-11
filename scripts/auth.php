<?php

session_start();

$conn = new mysqli('localhost', 'root', '', 'file_upload');

function register_user($username, $email, $password, $verification_code) {
    global $conn;
    $stmt = $conn->prepare('INSERT INTO users (username,email, password, verification_code) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $username, $email, $password, $verification_code);
    return $stmt->execute();
}


function login_user($username, $password) {
    global $conn;
    $stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        return true;
    }
    return false;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function get_user_id() {
    return $_SESSION['user_id'];
}

function logout_user() {
    session_destroy();
}
?>