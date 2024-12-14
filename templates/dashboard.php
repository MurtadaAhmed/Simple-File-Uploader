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
    <div class="container">
        <div class="row">
            <div class="col-md-6">
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']) ?>!</h1>
            </div>
    <div class="col-md-6 text-end"><a href="logout.php" class="btn btn-danger">Logout</a> </div>
        </div>
    </div>
 <section class="container my-5">
     <h3 class="mb-4">Upload a file</h3>
    <form id="uploadForm" method="POST" enctype="multipart/form-data" class="mb-3">
        <input type="file" name="file" required>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
     <div id="uploadMessage" class="text-success"></div>
     <div class="progress my-3" style="display: none; height: 25px">
         <div id="uploadProgress" class="progress-bar" role="progressbar" style="width: 0%;"></div>
     </div>
 </section>
     <section class="container my-5">
         <h3>Your Files</h3>
        <div id="fileList" class="row"></div>
     </section>
</main>

<?php include 'footer.php'; ?>