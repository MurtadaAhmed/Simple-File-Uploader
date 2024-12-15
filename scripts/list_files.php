<?php

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


$stmt = $pdo->prepare("SELECT COUNT(*) FROM files WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_files = $stmt->fetchColumn();
$total_pages = ceil($total_files / $items_per_page);


$stmt = $pdo->prepare("SELECT * FROM files WHERE user_id = ? LIMIT ? OFFSET ?");
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->bindParam(2, $items_per_page, PDO::PARAM_INT);
$stmt->bindParam(3, $offset, PDO::PARAM_INT);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

$base_url = '/uploads/' . $user_id;

foreach ($files as &$file) {
    $file['file_url'] = $base_url . '/' . $file['file_name'];
    $file_path = '../uploads/' . $user_id . '/' .$file['file_name'];
    $file['file_size'] = file_exists($file_path) ? filesize($file_path) : 0;
}

echo json_encode([
    'files' => $files,
    'total_pages' => $total_pages,
]);
