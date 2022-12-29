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

// 更改數量
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
}

// 更改狀態
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

$product_name = $_POST['product_name'] ?? '';
$product_amount = $_POST['product_amount'] ?? '';

// 新增商品
if (empty($product_name)) {
    $output['msg2'] = 'chose product';
} else {
    $sql_add = "INSERT INTO `order_detail`(
    `order_sid`, 
    `trails_sid`, 
    `amount`, 
    `create_date`, 
    `fake_delete`
    ) VALUES (
        ?, 
        ?, 
        ?, 
        NOW(),
        0
        )";

    $stmt_add = $pdo->prepare($sql_add);

    $stmt_add->execute([
        $current_sid,
        $product_name,
        $product_amount
    ]);

    if ($stmt_add->rowCount()) {
        $output['success'] = true;
    } else {
        $output['msg1'] = 'no data changes';
    }
}

if ($stmt->rowCount()) {
    $output['success1'] = true;
} else {
    $output['msg1'] = 'no data changes';
}

//如果沒寫這行資料依然會新增進資料表，但在前端看會發生錯誤，見 add.php的 here111
// 在 add.php的 here111已經設定回傳的檔案為json()，應把資料型態轉為json
echo json_encode($output, JSON_UNESCAPED_UNICODE);
