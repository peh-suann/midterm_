<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "order edit";
$title = "order edit";

// ----------------------------------------------------------------------------
// 現在這筆資料
$current_sid = $_GET['sid'];
$current_sql = "SELECT * FROM `order_list` WHERE `sid`= $current_sid";
$current_row = $pdo->query($current_sql)->fetch();
// print_r($current_row);

// ----------------------------------------------------------------------------
// 取得資料庫中的資料
// 顯示相對應的外鍵內容
$order_rows = [];
$order_sql = "SELECT * FROM `order_list` WHERE `fake_delete` = 0";
$order_rows = $pdo->query($order_sql)->fetchAll();

$member_rows = [];
$member_sql = "SELECT `sid`, `name` FROM `member`";
$member_rows = $pdo->query($member_sql)->fetchAll();

$order_status_rows = [];
$order_status_sql = "SELECT `sid`, `status` FROM `order_status`";
$order_status_rows = $pdo->query($order_status_sql)->fetchAll();

$order_detail_rows = [];
$order_detail_sql = "SELECT * FROM `order_detail` WHERE `fake_delete` = 0";
$order_detail_rows = $pdo->query($order_detail_sql)->fetchAll();

$trails_rows = [];
$trails_sql = "SELECT `sid`, `trail_name`, `price` FROM `trails`";
$trails_rows = $pdo->query($trails_sql)->fetchAll();

// ----------------------------------------------------------------------------
// 所有order_sid相同的資料
$same_order_sid_rows = [];
$same_order_sid_sql = "SELECT * FROM `order_detail` WHERE `order_sid`=$current_sid AND `fake_delete` = 0";
$same_order_sid_rows = $pdo->query($same_order_sid_sql)->fetchAll();
// print_r($same_order_sid_rows);

$this_trail_sid = "";
$same_trail_rows = [];
for ($i = 0; $i < count($same_order_sid_rows); $i++) {
    $this_trail_sid = $same_order_sid_rows[$i]['trails_sid'];
    // print_r($this_trail_sid);
    $same_trail_sql = "SELECT `sid`, `trail_name`, `price` FROM `trails` WHERE `sid`=$this_trail_sid";
    $this_trail_rows = $pdo->query($same_trail_sql)->fetch();
    array_push($same_trail_rows, $this_trail_rows);
}
// echo "<br>";
// print_r($same_trail_rows);
?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>
<style>
    .th_od {
        width: 100px;
    }
</style>
<div class="container">
    <!-- title -->
    <h3>訂單修改</h3>
    <form action="" name="form1" onsubmit="checkForm(event)">
        <div class="row mx-1 gap-3 my-3">
            <a href="./order.php" class="w-auto me-auto p-0">
                <button type="button" class="btn btn-primary">上一頁</button>
            </a>
            <button type="submit" name="edit_button" class="btn btn-danger w-auto">修改</button>
            <button type="button" class="btn btn-danger w-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                刪除
            </button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">刪除訂單</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        確認刪除此筆訂單ㄇ？
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="javascript: fake_delete_it(<?= $current_sid ?>)">
                            <button type="button" class="btn btn-primary">軟刪除</button>
                        </a>
                        <a href="javascript: delete_it(<?= $current_sid ?>)">
                            <button type="button" class="btn btn-primary">硬刪除</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th scope="row" class="th_od">會員名稱</th>
                    <td>
                        <?php foreach ($member_rows as $m_r) : ?>
                            <?php if ($m_r['sid'] === $current_row['member_sid']) {
                                echo $m_r['name'];
                            } ?>
                        <?php endforeach ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="th_od">訂購日期</th>
                    <td>
                        <?php foreach ($order_rows as $o_r) : ?>
                            <?php if ($o_r['sid'] === $current_sid) {
                                echo $o_r['order_date'];
                            } ?>
                        <?php endforeach ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="th_od">訂單狀態</th>
                    <td>
                        <select name="status" class="form-select form-select-sm" aria-label=".form-select-sm example">
                            <?php foreach ($order_status_rows as $o_s_r) : ?>
                                <?php if ($o_s_r['sid'] === $current_row['order_status_sid']) { ?>
                                    <option value="1" <?= ($order_status_rows[0]['sid'] === $current_row['order_status_sid']) ? 'selected' : '' ?>><?= $order_status_rows[0]['status'] ?></option>
                                    <option value="2" <?= ($order_status_rows[1]['sid'] === $current_row['order_status_sid']) ? 'selected' : '' ?>><?= $order_status_rows[1]['status'] ?></option>
                                    <option value="3" <?= ($order_status_rows[2]['sid'] === $current_row['order_status_sid']) ? 'selected' : '' ?>><?= $order_status_rows[2]['status'] ?></option> <?php } ?>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="th_od">商品明細</th>
                    <td>
                        <table class="table m-0 p-0 table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row">#</th>
                                    <td>商品名稱</td>
                                    <td>商品數量</td>
                                    <td>商品價錢</td>
                                    <td>商品總價</td>
                                    <td></td>
                                </tr>
                                <?php for ($i = 0; $i < count($same_order_sid_rows); $i++) : ?>
                                    <tr>
                                        <th scope="row"><?= $i + 1 ?></th>
                                        <td>
                                            <?= $same_trail_rows[$i]['trail_name']; ?>
                                        </td>
                                        <td>
                                            <input type="number" name="product_amount<?= $i ?>" id="" value="<?= $same_order_sid_rows[$i]['amount'] ?>" style="width: 50px">
                                        </td>
                                        <td>
                                            <?= $same_trail_rows[$i]['price']; ?>
                                        </td>
                                        <td style="color: red; font-weight: bold">
                                            <?= $same_order_sid_rows[$i]['amount'] * $same_trail_rows[$i]['price']; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $i ?>">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </td>
                                        <div class="modal fade" id="exampleModal<?= $i ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">刪除商品</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        確認刪除此項商品？
                                                    </div>
                                                    <div class="modal-footer">
                                                        <?= $same_order_sid_rows[$i]['sid'] ?>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <a href="javascript: fake_delete_product(<?= $current_sid ?>, <?= $same_order_sid_rows[$i]['sid'] ?>)">
                                                            <button type="button" class="btn btn-primary">軟刪除</button>
                                                        </a>
                                                        <a href="javascript: delete_product(<?= $current_sid ?>, <?= $same_order_sid_rows[$i]['sid'] ?>)">
                                                            <button type="button" class="btn btn-primary">硬刪除</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                <?php endfor ?>
                                <tr>
                                    <th class="align-middle"><?= count($same_order_sid_rows) + 1 ?></th>
                                    <td>
                                        <select class="form-select form-select-sm add_product" aria-label=".form-select-sm example" name="product_name">
                                            <option value="chose product" disabled selected>請選取商品</option>
                                            <?php foreach ($trails_rows as $t_r) : ?>
                                                <option value="<?= $t_r['sid'] ?>"><?= $t_r['trail_name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="add_product" type="number" name="product_amount" id="" value="1" style="width: 50px">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button type="submit" name="add_button" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="th_od">訂單總價</th>
                    <td>
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
                </tr>
                <tr>
                    <th scope="row" class="th_od">備注</th>
                    <td>
                        <textarea name="memo" id="" cols="50" rows="3"><?php foreach ($order_rows as $o_r) : if ($o_r['sid'] === $current_row['sid']) {
                                                                                echo $o_r['memo'];
                                                                            }
                                                                        endforeach ?></textarea>
                    </td>
                </tr>
            </tbody>

        </table>
    </form>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
    function delete_it(sid) {
        location.href = 'order_detail_delete.php?sid=' + sid;
    }

    function fake_delete_it(sid) {
        location.href = 'order_detail_fake_delete.php?sid=' + sid;
    }

    function delete_product(sid, product_sid) {
        location.href = 'order_detail_delete_product.php?sid=' + sid + '&product_sid=' + product_sid;
    }

    function fake_delete_product(sid, product_sid) {
        location.href = 'order_detail_fake_delete_product.php?sid=' + sid + '&product_sid=' + product_sid;
    }

    const checkForm = function(event) {
        event.preventDefault();

        const fD = new FormData(document.form1);

        fetch('order_edit_api.php?sid=<?= $current_sid ?>', {
            method: 'POST',
            body: fD,
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (obj.success1 || obj.success2 || obj.success) {
                alert('Changed!');
                window.location.replace('order_edit.php?sid=<?= $current_sid ?>');
            } else if (obj.msg1) {
                alert('No Data Changed!');
            } else if (obj.msg2) {
                alert('No Data Changed!');
            }
        })

        // fetch('order_add_api.php?sid=<?php //$current_sid ?>', {
        //     method: 'POST',
        //     body: fD,
        // }).then(r => r.json()).then(obj => {
        //     console.log(obj);
        //     if (obj.success) {
        //         alert('Changed!');
        //         window.location.replace('order_edit.php?sid=<?php //$current_sid ?>');
        //     } else if (obj.msg1) {
        //         alert('Chose Product!');
        //     } else if (obj.msg2) {
        //         alert('No Data Changed!');
        //     }
        // })
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>