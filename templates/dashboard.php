<?php

require "../scripts/auth.php";



if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$files = list_user_files($user_id);

?>

<?php include 'header.php'; ?>
<main>
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']) ?>!</h1>
    <p><a href="logout.php">Logout</a> </p>
 <section>
     <h3>Upload a file</h3>
    <form id="uploadForm" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
     <div id="uploadMessage"></div>
 </section>
     <section>
         <h3>Your Files</h3>
        <div id="fileList"></div>
     </section>
</main>

<?php include 'footer.php'; ?>