<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "member";
$title = "member";


// 沒有選到sid, sid=0 顯示沒有這個會員
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;


if ($sid == 0) {
    // TODO : 顯示找不到會員
    header('Location: member.php'); // 轉向到列表頁
    exit;
}

$sql = "SELECT * FROM member WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: member.php'); // 轉向到列表頁
    exit;
}

$sql = "SELECT * FROM `emergency_contact` WHERE `member_sid`=$sid";
$re = $pdo->query($sql)->fetch();
if (empty($re)) {
    header('Location: member.php'); // 轉向到列表頁
    exit;
}


?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<div class="container">
    <h2 class="mt-3">會員管理</h2>
    <div class="row">
        <div class="col-8">
            <button style="line-height: 1.0;" type="button" class="btn btn-primary">
                <a style="color: #fff;text-decoration:none;" onclick="history.back()">回上一頁</a>
            </button>
            <button style="line-height: 1.0;" type="button" class="btn btn-info">
                <a style="color: #fff;text-decoration:none;" href="member_edit.php?sid=<?= $r['sid'] ?>">編輯會員</a>
            </button>
            <!-- <button style="line-height: 1.0;" type="button" class="btn btn-warning">
                <a style="color: #fff;text-decoration:none;" href="member_edit.php?sid=<?= $r['sid'] ?>">刪除會員</a>
            </button> -->
            <!-- Button trigger modal -->
            <button style="line-height: 1.0;color: #fff;" type="button" class="btn btn-warning" data-bs-toggle="modal"
                data-bs-target="#deleteModal">
                刪除會員
            </button>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">刪除資料</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <a style="color: #fff;text-decoration:none;"
                                    href="member_fake-delete.php?sid=<?= $r['sid'] ?>">暫時刪除</a>
                            </button>
                            <button type="button" class="btn btn-danger">
                                <a style="color: #fff;text-decoration:none;"
                                    href="member_delete.php?sid=<?= $r['sid'] ?>">永久刪除</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <table class="table">
                <tr>
                    <th scope="row">姓名</th>
                    <td><?= htmlentities($r['name']) ?></td>
                </tr>
                <tr>
                    <th scope="row">帳號</th>
                    <td><?= $r['account'] ?></td>
                </tr>
                <tr>
                    <th scope="row">性別</th>
                    <td><?= $r['gender'] ?></td>
                </tr>
                <tr>
                    <th scope="row">生日</th>
                    <td colspan="2"><?= $r['birthday'] ?></td>
                </tr>
                <tr>
                    <th scope="row">手機</th>
                    <td colspan="2"><?= $r['mobile'] ?></td>
                </tr>
                <tr>
                    <th scope="row">地址</th>
                    <td colspan="2"><?= $r['address'] ?></td>
                </tr>
                <tr>
                    <th scope="row">email</th>
                    <td colspan="2"><?= $r['email'] ?></td>
                </tr>
                <tr>
                    <th scope="row">身分證字號</th>
                    <td colspan="2"><?= $r['personal_id'] ?></td>
                </tr>
                <tr>
                    <th scope="row">會員狀態</th>
                    <td colspan="2"><?= ($r['member_status']) ? "使用中" : "已停權" ?></td>
                </tr>
            </table>

            <table class="table mt-2">
                <h6>緊急聯絡人</h6>
                <tr>
                    <th scope="row">姓名</th>
                    <td><?= htmlentities($re['emrg_name']) ?></td>
                </tr>
                <tr>
                    <th scope="row">手機</th>
                    <td><?= $re['emrg_mobile'] ?></td>
                </tr>
                <tr>
                    <th scope="row">關係</th>
                    <td><?= $re['emrg_relationship'] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>


<?php require __DIR__ . '/parts/scripts.php' ?>
<?php require __DIR__ . '/parts/html-foot.php' ?>