<?php
require 'db.php';
require 'auth.php';

global $pdo;

if (!is_logged_in()) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$file_id = $data['id'] ?? null;

if (!$file_id) {
    echo json_encode(['success' => false, 'error' => 'Invalid file ID']);
    exit;
}

// Get the file details
$stmt = $pdo->prepare("SELECT * FROM files WHERE id = ? AND user_id = ?");
$stmt->execute([$file_id, $_SESSION['user_id']]);
$file = $stmt->fetch();

if (!$file) {
    echo json_encode(['success' => false, 'error' => 'File not found']);
    exit;
}

// Delete the file record from the database
$stmt = $pdo->prepare("DELETE FROM files WHERE id = ?");
$stmt->execute([$file_id]);

// Delete the file from the server
$file_path = __DIR__ . '/../uploads/' . $_SESSION['user_id'] . '/' . $file['file_name'];
if (file_exists($file_path)) {
    unlink($file_path);
}

echo json_encode(['success' => true]);
