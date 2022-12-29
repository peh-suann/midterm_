<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "admin";
$title = "管理者列表";
if (!isset($_SESSION)) {
    session_start();
}
$perPage = 10; //每一頁的最高筆數
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM `admins`";
//取得總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
// 設定總頁數
$totalPages = ceil($totalRows / $perPage);

$rows = [];
$sql = sprintf("SELECT * FROM `admins` ORDER BY `sid` ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll();

?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>
<div class="container">
    <div class="row">
        <h2>管理者列表</h2>
        <div class="col-7 d-flex justify-content-between">
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= PROJ_ROOT ?>/index_.php">後台首頁</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="<?= PROJ_ROOT ?>/admin.php">管理者列表</a></li>
                    <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
                </ol>
            </nav>
            <!-- 新增管理員按鈕 -->
            <a style="text-decoration:none;" href="<?= PROJ_ROOT ?>/register-admin.php">
                <button style="color: #fff;line-height: 1.0;" type="button" class="btn btn-info">新增管理員</button>
            </a>
        </div>
        <div class="col-6 d-flex justify-content-center">
            <table class="table table-striped table-hover align-middle ">
                <thead>

                    <tr>
                        <th>#</th>
                        <th>帳號</th>
                        <th class="th_act_admin">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                        <th class="th_act_admin">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['account'] ?></td>
                            <td>
                                <a href="<?= PROJ_ROOT ?>/admin-edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?= PROJ_ROOT ?>/admin-delete.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=1">第一頁</a>
                </li>
                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                    if ($i >= 1 and $i <= $totalPages) :
                ?>
                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                <?php
                    endif;
                endfor;
                ?>
                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $totalPages ?>">最後一頁</a>
                </li>
            </ul>
        </nav>
    </div>
</div>


<script>

</script>