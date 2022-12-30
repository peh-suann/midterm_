<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type:application/json');

$output = [
    'success' => false,
    'errors' => [],
    'postData' => $_POST,
];


if (empty(intval($_POST['sid']))) {
    $output['errors'] = ['sid' => '沒有表單主鍵'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sid = intval($_POST['sid']);
$trail_name =  $_POST['trail_name'] ?? '';
$trail_img =  $_POST['trail_img'] ?? '';
$trail_describ =  $_POST['trail_describ'] ?? '';
$trail_short_describ =  $_POST['trail_short_describ'] ?? '';
$trail_timetable =  $_POST['trail_timetable'] ?? '';
$trail_time =  $_POST['trail_time'] ?? '';
$geo_location_sid =  $_POST['geo_location_sid'] ?? '';
$difficulty_list_sid =  $_POST['difficulty_list_sid'] ?? '';
$coupon_status =  $_POST['coupon_status'] ?? '';
$price =  $_POST['price'] ?? '';
$memo =  $_POST['memo'] ?? '';
$equipment =  $_POST['equipment'] ?? '';
$trails_display =  $_POST['trails_display'] ?? '';

$isPass = true;

if ($isPass) {

    $sql = "UPDATE `trails` SET `trail_name`=?,`trail_img`=?,`trail_describ`=?,`trail_short_describ`=?,`trail_timetable`=?,`trail_time`=?,`geo_location_sid`=?,`difficulty_list_sid`=?,`coupon_status`=?,`price`=?,`memo`=?,`equipment`=?,`trails_display`=? WHERE `sid`=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $trail_name,
        $trail_img,
        $trail_describ,
        $trail_short_describ,
        $trail_timetable,
        $trail_time,
        $geo_location_sid,
        $difficulty_list_sid,
        $coupon_status,
        $price,
        $memo,
        $equipment,
        $trails_display,
        $sid,
    ]);

    if ($stmt->rowCount()) {
        $output['success'] = true;
    } else {
        $output['msg'] = '資料沒有變更';
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);