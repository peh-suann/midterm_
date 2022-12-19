<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "trails";
$title = "trails";



$perPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($page < 1) {
    header('Location:?page=1');
    exit;
}

$trails_sql = "SELECT COUNT(1) FROM trails";

$trails_totalRows = $pdo->query($trails_sql)->fetch(PDO::FETCH_NUM)[0];
$trails_totalPages = ceil($trails_totalRows / $perPage);

$trails_rows = [];
if ($trails_totalRows > 0) {

    if ($page > $trails_totalPages) {
        header('Location:?page=' . $trails_totalPages);
        exit;
    }

    $sql = sprintf("SELECT * FROM `trails` LIMIT %s,%s", ($page - 1) * $perPage, $perPage);

    $trails_rows = $pdo->query($sql)->fetchAll();
}



?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<div class="d-flex flex-column w-100">
    <div class="d-flex justify-content-between p-5">
        <div>
            <button type="button" class="btn btn-primary"><a href="./trails.php" class="text-decoration-none"
                    style="color:white;">商品管理</a></button>
            <button type="button" class="btn btn-primary"><a href="./trails_add.php" class="text-decoration-none"
                    style="color:white;">新增</a></button>
        </div>
        <!-- <div class="d-flex">
            <select class="form-select" aria-label="Default select example">
                <option value="" selected>請選擇條件</option>
                <option value="<?= $t_r['coupon_status'] == 1 ?>">可使用折價券</option>
                <option value="<?= $t_r['coupon_status'] == 0 ?>">不可使用折價券</option>

            </select>
            <button type="button" class="btn btn-primary "><a href="./trails_select.php" class="text-decoration-none"
                    style="color:white;">搜尋</a></button>
        </div> -->
    </div>
    <table class="table table-striped">
        <thead>

            <tr>
                <th class="text-center align-middle">
                    <i class="fa-solid fa-trash-can"></i>
                </th>
                <th class="text-center align-middle">
                    <i class="fa-solid fa-file-pen"></i>
                </th>
                <th class="text-center align-middle">#</th>
                <th class="col-2 text-center align-middle">名稱
                <th class="col-2 text-center align-middle">簡述
                <th class="col-2 text-center align-middle">可否使用優惠碼</th>
                <th class="col-1 text-center align-middle">價格</th>
                <th class="col text-center align-middle">詳細資料</th>

            </tr>

        </thead>
        <tbody>
            <?php foreach ($trails_rows as $t_r) : ?>
            <tr>
                <td class="text-center align-middle">
                    <a href="javascript: trails_delete_it(<?= $t_r['sid'] ?>)">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </td>
                <td class="text-center align-middle">
                    <a href="trails_edit.php?sid=<?= $t_r['sid'] ?>">
                        <i class="fa-solid fa-file-pen"></i>
                    </a>
                </td>
                <td class="text-center align-middle"><?= $t_r['sid'] ?></td>
                <td class="col-2 text-center align-middle"><?= htmlentities($t_r['trail_name']) ?></td>
                <td class="col-2 text-center align-middle"><?= htmlentities($t_r['trail_short_describ']) ?></td>
                <td class="col-2 text-center align-middle">
                    <?php if ($t_r['coupon_status'] == 0) {
                            echo '否';
                        } else {
                            echo '是';
                        } ?>
                </td>


                <td class="col-1 text-center align-middle"><?= htmlentities($t_r['price']) ?></td>
                <td class="col text-center align-middle"> <button type="button" class="btn btn-primary"><a
                            href="./trails_detail.php?sid=<?= $t_r['sid'] ?>" class="text-decoration-none"
                            style="color:white;">詳細資料</a></button></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example" class="d-flex justify-content-start   align-items-center m-4">
        <ul class="pagination justify-content-end">
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=1">第一頁</a>
            </li>
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) : ?>
            <?php if ($i >= 1 and $i <= $trails_totalPages) : ?>
            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php
                endif;
            endfor; ?>
            <li class="page-item <?= $page == $trails_totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $trails_totalPages ?>">最後一頁</a>
            </li>
        </ul>
    </nav>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
function trails_delete_it(sid) {
    if (confirm(`是否要刪除 ${sid} 這筆資料?`)) {
        location.href = 'trails_delete.php?sid=' + sid;
    }
}
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>