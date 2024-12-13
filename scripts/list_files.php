<?php
session_start();

require "auth.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$files = list_user_files($user_id);

if ($files) {
    foreach ($files as $file) {
        echo '<div>' . htmlspecialchars($file['file_name']) . '</div>';
    }
} else {
    echo '<p>No files uploaded yet.</p>';
}

?>