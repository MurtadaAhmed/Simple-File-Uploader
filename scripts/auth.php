<?php

session_start();
require 'db.php';

//$conn = new mysqli('localhost', 'root', '', 'file_upload');

function register_user($username, $email, $password, $verification_code) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO users (username,email, password, verification_code) VALUES (?, ?, ?, ?)');
    return $stmt->execute([$username, $email, $password, $verification_code]);
}

function verify_email($code) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET emai_verified=1 WHERE verification_code = ? ");
    return $stmt->execute([$code]);
}

function login_user($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

function list_user_files($user_id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM files WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
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


