<?php
session_start();
require 'db.php';
require 'auth.php';

global $pdo;

if (!is_logged_in()) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$items_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Get the total count of files
$stmt = $pdo->prepare("SELECT COUNT(*) FROM files WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_files = $stmt->fetchColumn();
$total_pages = ceil($total_files / $items_per_page);

// Get the files for the current page
$stmt = $pdo->prepare("SELECT * FROM files WHERE user_id = ? LIMIT ? OFFSET ?");
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->bindParam(2, $items_per_page, PDO::PARAM_INT);
$stmt->bindParam(3, $offset, PDO::PARAM_INT);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'files' => $files,
    'total_pages' => $total_pages,
]);
