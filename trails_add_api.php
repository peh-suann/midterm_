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


// $trail_type = [
//     'image/jpeg' => '.jepg',
//     'image/png' => '.png'
// ];


// $success = false;
// $trail_filename = '';
// if (!empty($_FILES['trail_img']) and $_FILES['trail_img']['error'] === 0) {
//     if (empty($trail_type[$_FILES['trail_img']['type']])) {
//         echo json_encode([
//             'success' => false,
//             'error' => '圖片格式錯誤',
//         ]);
//         exit;
//     }

//     $t_m = $trail_type[$_FILES['trail_img']['type']];
//     $trail_filename = sha1(uniqid() . rand()) . $t_m;


//     $success = move_uploaded_file(
//         $_FILES['trail_img']['tmp_name'],
//         __DIR__ . './trails_uploaded/' . $trail_filename
//     );
// }

// echo json_encode(
//     [
//         'success' => $success,
//         'files' => $_FILES,
//         'filename' => $trail_filename
//     ]
// );



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


$isPass = true;

if (!empty($trail_name) and mb_strlen($trail_name, 'utf8') < 2) {
    $output['errors']['name'] = '請輸入正確的名字';
    $isPass = false;
}
if (!empty($trail_describ) and mb_strlen($trail_describ, 'utf8') < 2) {
    $output['errors']['trail_describ'] = '請輸入正確的格式';
    $isPass = false;
}
if (!empty($trail_short_describ) and mb_strlen($trail_short_describ, 'utf8') < 2) {
    $output['errors']['trail_short_describ'] = '請輸入正確的格式';
}
// if (intval($_POST['price']) > 1) {
//     $output['errors']['price'] = '請輸入正確的格式';
//     $isPass = false;
// }



if ($isPass) {
    if (!empty($_POST['trail_name'])) {

        $sql = "INSERT INTO `trails`(`trail_name`, `trail_img`, `trail_describ`, `trail_short_describ`, `trail_timetable`, `trail_time`, `geo_location_sid`, `difficulty_list_sid`, `coupon_status`, `price`, `memo`, `equipment`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
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
        ]);

        if ($stmt->rowCount()) {
            $output['success'] = true;
        }
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);