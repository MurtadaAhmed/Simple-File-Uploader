<?php

session_start();
require 'auth.php';

if (!isset($_SESSION['user_id'])){
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $file_name = $_POST['file'];

    $file_path = '../uploads/' . $user_id . '/' . $file_name;
    if (file_exists($file_path) && unlink($file_path)) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM files WHERE user_id = ? AND file_name = ?");
        $stmt->execute([$user_id, $file_name]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to delete file.']);
    }
}