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
            <!-- 刪除通知 -->

            <!-- <div class="modal fade" id="exampleModal<?= $r['sid'] ?>?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">刪除管理員</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            確認刪除此位管理員？
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                <button type="button" class="btn btn-primary">永久刪除</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- 表格 -->
            <table class="table table-striped table-hover align-middle ">
                <thead>

                    <tr>
                        <th>#</th>
                        <th>帳號</th>
                        <th>管理者暱稱</th>
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
                            <td><?= $r['nickname'] ?></td>
                            <td>
                                <a href="<?= PROJ_ROOT ?>/admin-edit.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td>
                                <a type="button" onclick="delItem(<?= $r['sid'] ?>)">
                                    <i class="fa-solid fa-trash-can text-primary"></i>
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
    function delItem(sid) {
        if (confirm(`確定要刪除編號${sid}管理員？`)) {
            // event.currentTarget.closest('tr').remove();
            location.href = 'admin-delete-api.php?sid=' + sid;
            console.log('ok');
        } else {
            console.log('canceled');
        }
    }
</script>