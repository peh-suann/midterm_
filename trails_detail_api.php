<?php
header('Location:trails_detail.php');

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location:trails.php');
    exit;
}


$sql = "SELECT `trail_name`,`trail_describ`,`trail_timetable`, `trail_time`, `geo_location_sid`, `difficulty_list_sid`, `coupon_status`, `price`, `memo`, `equipment` FROM `trails` WHERE sid=$sid";

$trails_details = $pdo->query($sql)->fetchAll();