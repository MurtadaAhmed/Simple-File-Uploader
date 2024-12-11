<?php

require "auth.php";

global $conn;

if (is_logged_in()) {
    $user_id = get_user_id();
    $page = $_GET['page'] ?? 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    $stmt = $conn->prepare("SELECT file_name FROM files WHERE user_id = ? LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $user_id, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $files = [];
    while ($row = $result->fetch_assoc()) {
        $files[] = $row['file_name'];
    }
    echo json_encode($files);
}

?>