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


$name = $_POST['name'] ?? '';
$gender = $_POST['gender'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$address = $_POST['address'] ?? '';
$email = $_POST['email'] ?? '';
$personalid = $_POST['personalid'] ?? '';
$member_status = $_POST['member_status'] ?? '';
$account = $_POST['account'] ?? '';
if($_POST['password']==$_POST['password2']){
    $password = $_POST['password'];
}



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
if (!empty($mobile) and !preg_match("/^09[0-9]{2}-?[0-9]{3}-?[0-9]{3}$/",$mobile)) {
    $output['errors']['mobile'] = '手機格式不符合';
    $isPass = false;
}

// personalid檢查
if (!empty($personalid) and !preg_match("/^[A-Za-z][0-9]{9}$/",$personalid)) {
    $output['errors']['mobile'] = '手機格式不符合';
    $isPass = false;
}


$bt = strtotime($birthday); // 轉換為 timestamp
$birthday = $bt === false ? null : date('Y-m-d', $bt);



if($isPass = true){
    $sql = "INSERT INTO `member`(
        `name`, `gender`, 
        `birthday`, `account`, `password`,
        `regist_date`, `mobile`, `address`, 
        `email`, `personal_id`, `member_status`,
        `display`
        ) VALUES (
            ?,?,
            ?,?,?,
            NOW(),?,?,
            ?,?,?,
            ?
        )";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        $name,
        $gender,
        $birthday,
        $account,
        password_hash($password, PASSWORD_DEFAULT),
        $mobile,
        $address,
        $email,
        $personalid,
        $member_status,
        1
    ]);
    
    // 新增幾筆: 有新增rowCount()=1 ; 沒有則為0
    if ($stmt->rowCount()) {
        $output['success'] = true;
    }

}


echo json_encode($output, JSON_UNESCAPED_UNICODE);