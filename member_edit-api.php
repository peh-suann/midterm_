<?php


require __DIR__ . '/parts/connect_db.php';

// 設定後端輸出的content-type
header('Content-Type: application/json');

// 設定輸出的格式, 輸出讓前端知道資料新增有沒有成功
$output = [
    'success' => false,
    'code' => 0, // 除錯用
    'errors' => [],
    'postData' => $_POST, // 除錯用
];

if (empty($_POST)) {
    $output['errors'] = ['all' => '沒有表單資料'];
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sid = $_POST['sid'] ?? '';
$name = $_POST['name'] ?? '';
$gender = $_POST['gender'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$address = $_POST['address'] ?? '';
$email = $_POST['email'] ?? '';
$personalid = $_POST['personalid'] ?? '';
$member_status = $_POST['member_status'] ?? '';
$account = $_POST['account'] ?? '';
// if($_POST['password']==$_POST['password2']){
//     $password = $_POST['password'];
// }
$emrg_name = $_POST['ermg_name'] ?? '';
$emrg_mobile = $_POST['emrg_mobile'] ?? '';
$emrg_relationship = $_POST['emrg_relationship'] ?? '';



$isPass = true; // 預設是通過的
// 欄位檢查
// 檢查姓名
if (mb_strlen($name, 'utf8') < 2) {
    $output['errors']['name'] = '請輸入正確的姓名';
    $isPass = false;
}

// 檢查 email 格式: 有填值才判斷格式
if (!empty($email) and !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $output['errors']['email'] = '格式不合法';
    $isPass = false;
}

// 手機檢查  
if (!empty($mobile) and !preg_match("/^09[0-9]{2}-?[0-9]{3}-?[0-9]{3}$/", $mobile)) {
    $output['errors']['mobile'] = '手機格式不符合';
    $isPass = false;
}

// personalid檢查
if (!empty($personalid) and !preg_match("/^[A-Za-z][0-9]{9}$/", $personalid)) {
    $output['errors']['mobile'] = '手機格式不符合';
    $isPass = false;
}


$bt = strtotime($birthday); // 轉換為 timestamp
$birthday = $bt === false ? null : date('Y-m-d', $bt);



if ($isPass = true) {
    $sql = "UPDATE `member` SET 
        `name`=?,
        `gender`=?,
        `birthday`=?,
        `account`=?,
        `mobile`=?,
        `address`=?,
        `email`=?,
        `personal_id`=?,
        `member_status`=? 
        WHERE sid=?";


    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $name,
        $gender,
        $birthday,
        $account,
        $mobile,
        $address,
        $email,
        $personalid,
        $member_status,
        $sid,
    ]);


    $sql = "UPDATE `emergency_contact` SET 
        `emrg_name`=?,
        `emrg_mobile`=?,
        `emrg_relationship`=?
        WHERE `member_sid`=?";


    $stmt2 = $pdo->prepare($sql);

    $stmt2->execute([
        $emrg_name,
        $emrg_mobile,
        $emrg_relationship,
        $sid,
    ]);


    // 新增幾筆: 有新增rowCount()=1 ; 沒有則為0


    if ($stmt->rowCount()) {
        $output['success'] = true;
    } elseif ($stmt2->rowCount()) {
        $output['success'] = true;
    } else {
        $output['msg'] = '資料沒有變更';
    }
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);