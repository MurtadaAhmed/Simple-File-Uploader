<?php

require "auth.php";
require "db.php";


if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $user_dir = '../uploads/' . $user_id;

    if (!is_dir($user_dir)) {
        mkdir($user_dir, 0777, true);
    }

    if (isset($_FILES['file'])) {
        $file_name = basename($_FILES['file']['name']);
        $file_path = $user_dir . '/' . $file_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)){
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO files (user_id, file_name) VALUES (?, ?)");
            $stmt->execute([$user_id, $file_name]);

            echo json_encode(['success' => true, 'file' => $file_name]);
        } else {
            echo json_encode(['error' => 'Failed to upload file.']);
        }

    }

}

?>