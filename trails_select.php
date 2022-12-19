<?php
require __DIR__ . '/parts/connect_db.php';

$coupon_status = isset($_GET['coupon_status']) ? intval($_GET['coupon_status']) : 0;

if (empty($coupon_status)) {
    header('Location:trails.php');
    exit;
}
$sql = "SELECT  `coupon_status` FROM `trails` WHERE coupon_status=$coupon_status";

$stmt = $pdo->query($sql)->fetchAll();

?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<div class="trails_w-100">
    <div class="d-flex justify-content-between p-5">
        <div>
            <button type="button" class="btn btn-primary"><a href="./trails.php" class="text-decoration-none"
                    style="color:white;">商品管理</a></button>
            <button type="button" class="btn btn-primary"><a href="./trails_add.php" class="text-decoration-none"
                    style="color:white;">新增</a></button>
        </div>
        <div class="d-flex">
            <select class="form-select" aria-label="Default select example">
                <option value="" selected>請選擇條件</option>
                <option value="<?= $t_r['coupon_status'] == 1 ?>">可使用折價券</option>
                <option value="<?= $t_r['coupon_status'] == 0 ?>">不可使用折價券</option>

            </select>
            <button type="button" class="btn btn-primary "><a href="./trails_select.php" class="text-decoration-none"
                    style="color:white;">搜尋</a></button>
        </div>
    </div>
    <table class="table table-striped">
        <thead>

            <tr>
                <th class="text-center">
                    <i class="fa-solid fa-trash-can"></i>
                </th>
                <th class="text-center">
                    <i class="fa-solid fa-file-pen"></i>
                </th>
                <th class="text-center">#</th>
                <th class="col-2 text-center">名稱
                <th class="col-2 text-center">簡述
                    <!-- <th class="col-1">行程時長</th>
                <th class="col-1">地理位置</th>
                <th class="col-1">難易度</th> -->
                <th class="col-2 text-center">可否使用優惠碼</th>
                <th class="col-1 text-center">價格</th>
                <th class="col text-center">詳細資料</th>

            </tr>

        </thead>
        <tbody>
            <?php foreach ($trails_rows as $t_r) : ?>
            <tr>
                <td class="text-center">
                    <a href="javascript: trails_delete_it(<?= $t_r['sid'] ?>)">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </td>
                <td class="text-center">
                    <a href="trails_edit.php?sid=<?= $t_r['sid'] ?>">
                        <i class="fa-solid fa-file-pen"></i>
                    </a>
                </td>
                <td class="text-center"><?= $t_r['sid'] ?></td>
                <td class="col-2 text-center"><?= htmlentities($t_r['trail_name']) ?></td>
                <!-- <td class="col-2"><?= htmlentities($t_r['trail_describ']) ?></td> -->
                <td class="col-2 text-center"><?= htmlentities($t_r['trail_short_describ']) ?></td>
                <!-- <td class="col-2"><?= htmlentities($t_r['trail_timetable']) ?></td> -->
                <!-- <td class="col-1"><?= htmlentities($t_r['trail_time']) ?></td>
                <td class="col-1"><?= $t_r['geo_location_sid'] ?></td>
                <td class="col-1"><?= $t_r['difficulty_list_sid'] ?></td> -->
                <td class="col-2 text-center">
                    <?php if ($t_r['coupon_status'] == 0) {
                            echo '否';
                        } else {
                            echo '是';
                        } ?>
                </td>


                <td class="col-1 text-center"><?= htmlentities($t_r['price']) ?></td>
                <!-- <td class="col"><?= htmlentities($t_r['memo']) ?></td>
                <td class="col"><?= htmlentities($t_r['equipment']) ?></td> -->
                <td class="col text-center"> <button type="button" class="btn btn-primary"><a
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