<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "order";
$title = "order";
if (!isset($_SESSION)) {
    session_start();
}
// ----------------------------------------------------------------------------
// 取得資料庫中的資料
// ----------------------------------------------------------------------------
$order_rows = [];
$order_sql = "SELECT * FROM `order_list` WHERE `fake_delete`=0 ORDER BY `order_status_sid`";
$order_rows = $pdo->query($order_sql)->fetchAll();

$member_rows = [];
$member_sql = "SELECT `sid`, `name` FROM `member`";
$member_rows = $pdo->query($member_sql)->fetchAll();

$order_status_rows = [];
$order_status_sql = "SELECT `sid`, `status` FROM `order_status`";
$order_status_rows = $pdo->query($order_status_sql)->fetchAll();
// ----------------------------------------------------------------------------
// 分頁按鈕
$per_page = 10;
$pag_page = 2;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header("Location: ?page=1");
    exit;
}

$total_sql = "SELECT COUNT(1) FROM `order_list` WHERE `fake_delete`=0 ORDER BY `sid`";
$total_rows = $pdo->query($total_sql)->fetch(PDO::FETCH_NUM)[0];
$total_pages = ceil($total_rows / $per_page);

$rows = [];
if ($total_rows > 0) {
    if ($page > $total_pages) {
        header("Location: ?page=" . $total_pages);
        exit;
    }
    $sql = sprintf("SELECT * FROM `order_list` WHERE `fake_delete`=0 ORDER BY `sid` ASC LIMIT %s, %s", ($page - 1) * $per_page, $per_page);
    $rows = $pdo->query($sql)->fetchAll();
}
// ----------------------------------------------------------------------------
// 查看訂單明細
// $od_sql = "SELECT * FROM `order_detail`";
// $od_rows = $pdo->query($od_sql)->fetchAll();
// print_r($od_rows);


// ----------------------------------------------------------------------------
// 測試


?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>
<div class="container">
    <!-- title -->
    <h2>訂單管理</h2>

    <!-- 😀😀😀😀😀😀😀😀😀😀😀😀😀 -->

    <!-- filter -->
    <div class="row mt-3">
        <div class="col">
            <form class="input-group" method="get">
                <select class="ms-1" name="status_filter" id="status_filter" placeholder="依狀態篩選">
                    <option value="">search by status</option>
                    <?php foreach ($order_status_rows as $o_s_r) : ?>
                        <option value="<?= $o_s_r['sid'] ?>"><?= $o_s_r['status'] ?></option>
                    <?php endforeach ?>
                </select>
                <button type="submit" class="btn btn-primary ms-1">
                    filter
                </button>
            </form>
        </div>
    </div>

    <?php
    // 判斷是否有篩選
    $isSelect = false;
    if ((isset($_GET['status_filter']))) {
        $isSelect = true;
    }

    if ($isSelect) {
        $perPage = 10; // 每一頁最多有幾筆
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // 搜尋keywords
        if (intval($_GET['status_filter']) > 3 || intval($_GET['status_filter']) < 1) {
            $searchKey = 1;
        } else {
            $searchKey = isset($_GET['status_filter']) ? $_GET['status_filter'] : 1;
        }

        // 計算總頁數
        $t_status = "SELECT COUNT(1) FROM `order_list` WHERE `fake_delete`=0 AND `order_status_sid` LIKE '%$searchKey%'";
        $total_status = $pdo->query($t_status)->fetch(PDO::FETCH_NUM)[0];
        $totalPage = ceil($total_status / $perPage);

        // 取出資料庫的資料
        $first = ($page - 1) * $perPage;
        $last = $perPage;

        $rows = [];
        $sql = "SELECT * FROM `order_list` WHERE `fake_delete`=0 AND `order_status_sid` LIKE '%$searchKey%' LIMIT $first, $last";
        $rows = $pdo->query($sql)->fetchAll();
    ?>
        <div class="row">
            <div class="col">
                共<?= $total_status ?>筆
            </div>
        </div>
    <?php } ?>


    <!-- 😀😀😀😀😀😀😀😀😀😀😀😀😀 -->
    <!-- list -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">訂購日期</th>
                <th scope="col">會員名稱</th>
                <th scope="col">訂單狀態</th>
                <th scope="col">訂單總價</th>
                <th scope="col">備注</th>
                <th scope="col">
                    <i class="fa-solid fa-pen-to-square"></i>
                </th>
                <th scope="col">
                    <i class="fa-solid fa-trash-can"></i>
                </th>
                <th scope="col">訂單明細</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr class="align-middle">
                    <th><?= "021215" . $r['sid'] ?></th>
                    <td><?= $r['order_date'] ?></td>
                    <td>
                        <?php foreach ($member_rows as $m_r) : ?>
                            <a href="<?= PROJ_ROOT ?>/member_order.php?sid=<?= $r['sid'] ?>" class="link-dark">
                                <?php if ($m_r['sid'] === $r['member_sid']) {
                                    echo $m_r['name'];
                                } ?>
                            </a>
                        <?php endforeach ?>
                    </td>
                    <td>
                        <?php foreach ($order_status_rows as $os_r) : ?>
                            <?php if ($os_r['sid'] === $r['order_status_sid']) {
                                echo $os_r['status'];
                            } ?>
                        <?php endforeach ?>
                    </td>
                    <td>
                        <?php
                        $current_sid = $r['sid'];
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
                    <td><?= $r['memo'] ?></td>
                    <td>
                        <a href="<?= PROJ_ROOT ?>/order_edit.php?sid=<?= $r['sid'] ?>">
                            <i class="fa-solid fa-pen-to-square text-success"></i>
                        </a>
                    </td>
                    <td data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer;">
                        <i class=" fa-solid fa-trash-can text-primary"></i>
                    </td>
                    <td>
                        <a href="<?= PROJ_ROOT ?>/order_detail.php?sid=<?= $r['sid'] ?>">
                            <button class="btn btn-primary btn-sm">訂單明細</button>
                        </a>
                    </td>
                </tr>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">刪除訂單</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                確認刪除此筆訂單？
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="javascript: fake_delete_it(<?= $r['sid'] ?>)">
                                    <button type="button" class="btn btn-primary">軟刪除</button>
                                </a>
                                <a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                    <button type="button" class="btn btn-primary">硬刪除</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </tbody>
    </table>

    <!-- pagination -->
    <div class="row me-1">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disable' : '' ?>">
                        <a class="page-link" href="?page=1">第一頁</a>
                    </li>
                    <?php if ($page > ($pag_page * 2) - 1) : ?>
                        <li class="page-item disabled">
                            <a class="page-link">
                                <i class="fa-solid fa-ellipsis"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <?php for ($i = $page - $pag_page; $i <= $page + $pag_page; $i++) : ?>
                        <?php if ($i >= 1 && $i <= $total_pages) : ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endif ?>
                    <?php endfor ?>
                    <?php if ($page <= ($total_pages - ($pag_page * 2) + 1)) : ?>
                        <li class="page-item disabled">
                            <a class="page-link">
                                <i class="fa-solid fa-ellipsis"></i>
                            </a>
                        </li>
                    <?php endif ?>
                    <li class="page-item <?= $page == $total_pages ? 'disable' : '' ?>">
                        <a class="page-link" href="?page=<?= $total_pages ?>">最後一頁</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
    function delete_it(sid) {
        location.href = 'order_delete.php?sid=' + sid;
    }

    function fake_delete_it(sid) {
        location.href = 'order_fake_delete.php?sid=' + sid;
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>