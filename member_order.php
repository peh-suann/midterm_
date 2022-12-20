<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "member order";
$title = "member order";

// ----------------------------------------------------------------------------
// 取得資料庫中的資料
$current_member_sid = $_GET['member_sid'];
$current_member_sql = "SELECT * FROM `order_list` WHERE `member_sid` = $current_member_sid";
$current_member_row = $pdo->query($current_member_sql)->fetchAll();
// print_r($current_member_row);
$current_member_array = [];
foreach ($current_member_row as $c_m_r) {
    array_push($current_member_array, $c_m_r['sid']);
}
// print_r($current_member_array);

// ----------------------------------------------------------------------------
// 現在這筆資料
// $current_sid = $_GET['sid'];
// $current_sql = "SELECT * FROM `order_list` WHERE `sid`= $current_sid";
// $current_row = $pdo->query($current_sql)->fetch();
// print_r($current_row);


// ----------------------------------------------------------------------------
// 取得資料庫中的資料
// 顯示相對應的外鍵內容
$order_rows = [];
$order_sql = "SELECT * FROM `order_list`";
$order_rows = $pdo->query($order_sql)->fetchAll();

$member_rows = [];
$member_sql = "SELECT `sid`, `name` FROM `member` WHERE `sid` = $current_member_sid";
$member_rows = $pdo->query($member_sql)->fetch();

$order_status_rows = [];
$order_status_sql = "SELECT `sid`, `status` FROM `order_status`";
$order_status_rows = $pdo->query($order_status_sql)->fetchAll();

$order_detail_rows = [];
$order_detail_sql = "SELECT * FROM `order_detail` WHERE `order_sid`=5";
$order_detail_rows = $pdo->query($order_detail_sql)->fetchAll();

$trails_rows = [];
$trails_sql = "SELECT `sid`, `trail_name`, `price` FROM `trails`";
$trails_rows = $pdo->query($trails_sql)->fetchAll();

// ----------------------------------------------------------------------------
// 所有order_sid相同的資料
$same_order_sid_rows = [];
foreach ($current_member_row as $c_m_r) {
    $order_sid = $c_m_r['sid'];
    $same_order_sid_sql = "SELECT * FROM `order_detail` WHERE `order_sid`=$order_sid AND `fake_delete` = 0";
    $order_sid_row = $pdo->query($same_order_sid_sql)->fetchAll();
    array_push($same_order_sid_rows, $order_sid_row);
}
// echo "<br>";
// echo json_encode($same_order_sid_rows);
// print_r(count($same_order_sid_rows));
// print_r($same_order_sid_rows);

$this_trail_sid = "";
$same_trail_rows = [];
for ($i = 0; $i < count($same_order_sid_rows); $i++) {
    $this_trail_sid = $same_order_sid_rows[$i];
    // print_r($this_trail_sid);
    // $same_trail_sql = "SELECT `sid`, `trail_name`, `price` FROM `trails` WHERE `sid`=$this_trail_sid";
    // $this_trail_rows = $pdo->query($same_trail_sql)->fetch();
    // array_push($same_trail_rows, $this_trail_rows);
    // print_r($same_trail_rows);
    // print_r(count($this_trail_sid));
}
// print_r($same_trail_rows);

// ----------------------------------------------------------------------------
// 所有order_sid相同的資料
$list_same_order_sid = "";
$list_same_order_rows = [];
for ($i = 0; $i < count($current_member_row); $i++) {
    $list_same_order_sid = $current_member_row[$i]['sid'];
    // print_r($list_same_order_sid);
    // echo "<br>";
    $list_same_order_sid_sql = "SELECT * FROM `order_detail` WHERE `order_sid`=$list_same_order_sid";
    $same_order_rows = $pdo->query($list_same_order_sid_sql)->fetchAll();
    // echo "<br>same order rows";
    // print_r($same_order_rows);
    // echo "<br>";
    array_push($list_same_order_rows, $same_order_rows);
    // print_r($same_trail_rows);
}
// echo json_encode($list_same_order_rows);
// print_r(count($list_same_order_rows[1]));
?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php'
?>
<style>
    .th_od {
        width: 100px;
    }
</style>
<div class="container">
    <!-- title -->
    <h3>會員歷史訂單</h3>
    <div class="row mx-1 gap-3 my-3">
        <button class="btn btn-primary w-auto me-auto" onclick="history.back()">上一頁</button>
    </div>
    <table class="table table-striped">
        <tbody>
            <tr>
                <th scope="row" class="th_od">會員名稱</th>
                <td>
                    <?= $member_rows['name'] ?>
                </td>
            </tr>
            <tr>
                <th>訂單記錄</th>
                <td>
                    共
                    <?= count($same_order_sid_rows) ?>
                    筆
                </td>
            </tr>
            <tr>
                <th scope="row" class="th_od">歷史訂單</th>
                <td>
                    <table class="table m-0 p-0 table-borderless">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>商品數量</th>
                                <th>訂單總價</th>
                                <th>訂購時間</th>
                                <th>訂單明細</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num = 1;
                            $product_num = 0;
                            ?>
                            <?php foreach ($current_member_row as $c_m_r) : ?>
                                <tr>
                                    <th>
                                        <?= $num ?>
                                        <?php $num = $num + 1; ?>
                                    </th>
                                    <td>
                                        共
                                        <?= count($list_same_order_rows[$product_num]) ?>
                                        <?php $product_num = $product_num + 1; ?>
                                        項商品
                                    </td>
                                    <td>
                                        <?php
                                        $current_sid = $c_m_r['sid'];
                                        $same_order_sid_rows = [];
                                        $same_order_sid_sql = "SELECT * FROM `order_detail` WHERE `order_sid`=$current_sid";
                                        $same_order_sid_rows = $pdo->query($same_order_sid_sql)->fetchAll();

                                        $this_trail_sid = "";
                                        $same_trail_rows = [];
                                        for ($i = 0; $i < count($same_order_sid_rows); $i++) {
                                            $this_trail_sid = $same_order_sid_rows[$i]['trails_sid'];
                                            // print_r($this_trail_sid);
                                            $same_trail_sql = "SELECT `sid`, `trail_name`, `price` FROM `trails` WHERE `sid`=$this_trail_sid";
                                            $this_trail_rows = $pdo->query($same_trail_sql)->fetch();
                                            array_push($same_trail_rows, $this_trail_rows);
                                            // print_r($same_trail_rows);
                                        }
                                        ?>
                                        <?php $total_price_array = []; ?>
                                        <?php for ($i = 0; $i < count($same_order_sid_rows); $i++) : ?>
                                            <?php foreach ($same_order_sid_rows as $s_r) : ?>
                                                <?php if ($s_r['trails_sid'] === $same_trail_rows[$i]['sid']) {
                                                    array_push($total_price_array, $s_r['amount'] * $same_trail_rows[$i]['price']);
                                                } ?>
                                            <?php endforeach ?>
                                        <?php endfor ?>
                                        <?= array_sum($total_price_array) ?>
                                    </td>
                                    <td>
                                        <?= $c_m_r['order_date'] ?>
                                    </td>
                                    <td>
                                        <a href="<?= PROJ_ROOT ?>/order_detail.php?sid=<?= $c_m_r['sid'] ?>">
                                            <button class="btn btn-primary btn-sm">訂單明細</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </td>
            </tr>


        </tbody>
    </table>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
    function delete_it(sid) {
        location.href = 'order_detail_delete.php?sid=' + sid;
    }

    function fake_delete_it(sid) {
        location.href = 'order_detail_fake_delete.php?sid=' + sid;
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>