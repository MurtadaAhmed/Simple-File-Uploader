<?php

require "auth.php";

global $conn;

if ($_SERVER['REQUEST_METHOD'] == ' POST' && is_logged_in()) {
    $user_id = get_user_id();
    $uploadDir = "../uploads/user_$user_id/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['file'];
    $filePath = $uploadDir . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $stmt = $conn->prepare("INSERT INTO files (user_id, file_name) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $file['name']);
        $stmt->execute();
        echo 'File uploaded successfully.';
    } else {
        http_response_code(500);
        echo "Error uploading file.";
    }

}

?>