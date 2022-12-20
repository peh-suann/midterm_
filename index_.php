<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "home";
$title = "home";
if (!isset($_SESSION['admin'])) {
    // echo 11;
    session_start();
}
?>

<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>
<div class="container-fluid d-flex justify-content-center align-items-center">
    <div id="index_background">
        <div class="row">
            <h1 class="text-center text-white mt-5">Welcome to Peh-Suann!</h1>
            <h3 class="text-center text-white">Home Page</h3>
        </div>
    </div>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<?php require __DIR__ . '/parts/html-foot.php' ?>