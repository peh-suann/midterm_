<?php
require __DIR__ . '/parts/connect_db.php';

header('Content-Type: application/json');
// require __DIR__ . '/parts/admin-required-for-api.php';

// if (!isset($_SESSION)) {
//     session_start();
// }

$output = [
    'success' => false,
    'code' => 0, // 除錯用
    'errors' => [],
    'postData' => $_POST, // 除錯用
];

// echo $_POST['sid'];

if (empty(intval($_POST['reply_sid']))) {
    $output['errors'] = ['sid' => '沒有資料主鍵'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
} else {
    $output['success'] = true;
}

$sid = intval($_POST['reply_sid']);
$reply = $_POST['reply_show'] ?? '';
// // if (empty($sid)) {
// //     header('location: comment.php');
// //     exit;
// // }
$sql = "UPDATE `rating` SET `reply`=? WHERE `sid`=?";
// header('location: comment.php');
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $reply,
    $sid
]);
if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['errors'] = '資料沒有變更';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
// if (isset($_SERVER['HTTP_REFERER'])) {
//     header('location: comment.php');
// } else {
//     header('location:' . $_SERVER['HTTP_REFERER']