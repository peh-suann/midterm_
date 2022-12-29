<?php
require __DIR__ . '/parts/connect_db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'code' => 0, // 除錯用
    'errors' => [],
    'postData' => $_POST, // 除錯用
];
if (empty(intval($_POST['sid']))) {
    $output['errors'] = ['sid' => '沒有資料主鍵'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
} else {
    $output['success'] = true;
}

$sid = intval($_GET['sid']);
$account = $_POST['account'] ?? '';
$nickname = $_POST['nickname'] ?? '';
$isPass = true;
$edit_sql = "UPDATE `admins` SET 
    `account`=?, 
    `nickname`=? WHERE sid=$sid";
// $sql2 = "UPDATE `admins` SET `sid`='?',`account`='?',`nickname`='?', WHERE `sid`=?";
// header('location: comment.php');
$stmt = $pdo->prepare($edit_sql);
$stmt->execute([
    $account,
    $nickname
]);
if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['code'] = "here";
    $output['errors'] = '資料沒有變更';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
// if (isset($_SERVER['HTTP_REFERER'])) {
//     header('location: comment.php');
// } else {
//     header('location:' . $_SERVER['HTTP_REFERER']