<?php

require __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');

if (!isset($_SESSION)) {
    session_start();
}
//設定輸出格式
$output = [
    'success' => false,
    'code' => 0,
    'errors' => [],
    'postData' => $_POST,
];

//沒有表單資料



$comment = $_POST['comment'];
$reply = $_POST['reply'];

$isPass = true;
if ($isPass) {
    $sql = " 
    UPDATE `rating` 
    SET 
    `reply`=? 
    WHERE `sid`=?
    ";
}
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $reply,
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['msg'] = '資料沒有變更';
}




echo json_encode($output, JSON_UNESCAPED_UNICODE);
