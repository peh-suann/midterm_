<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "coupon";
$title = "coupon";
if (!isset($_SESSION)) {
    session_start();
}
?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>
<h6>coupon</h6>
<?php require __DIR__ . '/parts/scripts.php' ?>
<?php require __DIR__ . '/parts/html-foot.php' ?>