<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "trails";
$title = "trails";
if (!isset($title)) {
    $title = '';
} else {
    $title;
}



$perPage = 10;
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

<div class="trails_w-100">
    <div class="d-flex justify-content-between p-5">
        <div>

            <button type="button" class=""><a href="./trails.php">商品管理</a></button>
            <button type="button" class=""><a href="./trails_add.php">新增</a></button>
        </div>
        <nav aria-label="Page navigation example" class="d-flex justify-content-end   align-items-center">
            <ul class="pagination justify-content-end">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=1"><i class="fa-solid fa-circle-chevron-left"></i></a>
                </li>
                <?php for ($i = $page - 1; $i <= $page + 1; $i++) : ?>
                <?php if ($i >= 1 and $i <= $trails_totalPages) : ?>
                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php
                    endif;
                endfor; ?>
                <li class="page-item <?= $page == $trails_totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $trails_totalPages ?>"><i
                            class="fa-solid fa-circle-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">
                    <i class="fa-solid fa-trash-can"></i>
                </th>
                <th scope="col">#</th>
                <th scope="col">名稱</th>
                <th scope="col">圖片</th>
                <th scope="col">描述</th>
                <th scope="col">簡述</th>
                <th scope="col">行程規劃</th>
                <th scope="col">行程時長</th>
                <th scope="col">地理位置</th>
                <th scope="col">難易度</th>
                <th scope="col">可否使用優惠碼</th>
                <th scope="col">價格</th>
                <th scope="col">備註</th>
                <th scope="col">裝備說明</th>
                <th scope="col">
                    <i class="fa-solid fa-file-pen"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trails_rows as $t_r) : ?>
            <tr>
                <td class="col td_h">
                    <a href="#" onclick="delItem(event)">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </td>
                <td class="col td_h"><?= $t_r['sid'] ?></td>
                <td class="col td_h"><?= $t_r['trail_name'] ?></td>
                <td class="col td_h"><?= $t_r['trail_img'] ?></td>
                <td class="col td_h"><?= $t_r['trail_describ'] ?></td>
                <td class="col td_h"><?= $t_r['trail_short_describ'] ?></td>
                <td class="col td_h"><?= $t_r['trail_timetable'] ?></td>
                <td class="col td_h"><?= $t_r['trail_time'] ?></td>
                <td class="col td_h"><?= $t_r['geo_location_sid'] ?></td>
                <td class="col td_h"><?= $t_r['difficulty_list_sid'] ?></td>
                <td class="col td_h"><?= $t_r['coupon_status'] ?></td>
                <td class="col td_h"><?= $t_r['price'] ?></td>
                <td class="col td_h"><?= $t_r['memo'] ?></td>
                <td class="col td_h"><?= $t_r['equipment'] ?></td>
                <td class="col td_h">
                    <a href="#">
                        <i class="fa-solid fa-file-pen"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
function delItem(event) {
    const t = event.currentTarget.closest('tr').remove();
}
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>