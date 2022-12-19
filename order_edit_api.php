<?php
require __DIR__ . '/parts/connect_db.php';

$current_sid = intval($_GET['sid']);

$same_order_sid_rows = [];
$same_order_sid_sql = "SELECT * FROM `order_detail` WHERE `order_sid`=$current_sid AND `fake_delete` = 0";
$same_order_sid_rows = $pdo->query($same_order_sid_sql)->fetchAll();
// print_r($same_order_sid_rows);


header("Content-Type: application/json");


// 設定輸出的格式
$output = [
    'success1' => false,
    'code1' => 0,
    'errors1' => [],
    'postData' => $_POST,

    'success2' => false,
    'code2' => 0,
    'errors2' => []
];

$amount = intval('');
// $sql_amount = '';
// $stmt_amount = '';
// $num = 0;
// foreach($same_order_sid_rows as $s_r){
//     $amount.$num = intval($_POST['product_amount'.$num]);

//     $sql_amount.$num = "UPDATE `order_detail` SET `amount`=? WHERE `order_sid`=?";
//     $stmt_amount.$num = $pdo->prepare($sql_amount.$num);
//     $stmt_amount.$num->execute([
//         $amount.$num,
//         $current_sid
//     ]);

//     if ($stmt_amount.$num->rowCount()) {
//         $output['success'] = true;
//     } else {
//         $output['msg'] = 'no data changes';
//     }
//     $num = $num + 1;
// }

for ($i = 0; $i < count($same_order_sid_rows); $i++) {
    $amount = intval($_POST['product_amount' . $i]);
    $this_sid = $same_order_sid_rows[$i]['sid'];

    $sql_amount = "UPDATE `order_detail` SET `amount`=? WHERE `order_sid`=? AND `sid`=?";
    $stmt_amount = $pdo->prepare($sql_amount);
    $stmt_amount->execute([
        $amount,
        $current_sid,
        $this_sid
    ]);

    if ($stmt_amount->rowCount()) {
        $output['success2'] = true;
        $output['code2'] = 100;
    } else {
        $output['msg2'] = 'no data changes';
        $output['code2'] = 200;
    }
}

$status = $_POST['status'] ?? '';
$memo = $_POST['memo'] ?? '';


$sql = "UPDATE `order_list` SET 
`order_status_sid`=?, 
`memo`=? 
WHERE `sid`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $status,
    $memo,
    $current_sid
]);

if ($stmt->rowCount()) {
    $output['success1'] = true;
} else {
    $output['msg1'] = 'no data changes';
}

//如果沒寫這行資料依然會新增進資料表，但在前端看會發生錯誤，見 add.php的 here111
// 在 add.php的 here111已經設定回傳的檔案為json()，應把資料型態轉為json
echo json_encode($output, JSON_UNESCAPED_UNICODE);
