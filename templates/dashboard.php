<?php

require "scripts/auth.php";

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_id = get_user_id();

?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<script src="script.js"></script>
</head>
<body>
<h1>Welcome, User <?php echo $user_id; ?>!</h1>
<form id="uploadForm"">
    <input type="file" name="file" required>
    <button type="submit">Upload</button>
</form>
<div id="fileList"></div>
</body>
</html>
