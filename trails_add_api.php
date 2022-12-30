<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type:application/json');

$output = [
    'success' => false,
    'errors' => [],
    'postData' => $_POST,
];


if (empty($_POST)) {
    $output['errors'] = ['沒有表單資料'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}



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

if (empty($trail_name) and mb_strlen($trail_name, 'utf8') < 2) {
    $output['errors']['name'] = '請輸入正確的名字';
    $isPass = false;
}
if (empty($trail_describ) and mb_strlen($trail_describ, 'utf8') < 2) {
    $output['errors']['trail_describ'] = '請輸入正確的格式';
    $isPass = false;
}
if (empty($trail_short_describ) and mb_strlen($trail_short_describ, 'utf8') < 2) {
    $output['errors']['trail_short_describ'] = '請輸入正確的格式';
    $isPass = false;
}
if (empty($trail_timetable) and mb_strlen($trail_timetable, 'utf8') < 2) {
    $output['errors']['trail_timetable'] = '請輸入正確的格式';
    $isPass = false;
}
if (empty($trail_time)) {
    $output['errors']['trail_time'] = '請輸入正確的格式';
    $isPass = false;
}




if ($isPass) {
    if (!empty($trail_name)) {

        $sql = "INSERT INTO `trails`(`trail_name`, `trail_img`, `trail_describ`, `trail_short_describ`, `trail_timetable`, `trail_time`, `geo_location_sid`, `difficulty_list_sid`, `coupon_status`, `price`, `memo`, `equipment`,`trails_display`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
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
        ]);

        if ($stmt->rowCount()) {
            $output['success'] = true;
        }
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);