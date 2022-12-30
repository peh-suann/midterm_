<?php
require __DIR__ . '/parts/connect_db.php';

$pagename = 'admin edit';
$title = '編輯管理者資料';

$sid = $_GET['sid'];
$rows = [];
$sql = "SELECT * FROM `admins` WHERE `sid` = $sid ";
$rows = $pdo->query($sql)->fetch();
?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>
<style></style>

<div class="container">
    <div class="col-8">
        <h3>管理者資料修改</h3>

        <form action="" name="admin_edit" onsubmit="checkForm(event)">
            <div class="row mx-1 gap-3 my-3">
                <a href="<?= PROJ_ROOT ?>/admin.php" class="w-auto me-auto p-0">
                    <button type="button" class="btn btn-primary">上一頁</button>
                </a>
                <button type="submit" class="btn btn-danger w-auto">確認修改</button>
                <button type="button" class="btn btn-danger w-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    刪除
                </button>
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row" class="th_od">管理者Email</th>
                        <td>
                            <input type="hidden" name="sid" id="sid" value="<?= $rows['sid']; ?>"></input>
                            <input type="text" name="account" id="account" value="<?= $rows['account']; ?>"></input>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="th_od">管理者暱稱</th>
                        <td>

                            <input type="text" name="nickname" id="nickname" value="<?php echo $rows['nickname']; ?>"></input>

                        </td>
                    </tr>
                    <tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
    const checkForm = function(event) {
        console.log('沒出去');
        event.preventDefault();
        const fd = new FormData(document.admin_edit);
        console.log(fd);
        fetch('admin-edit-api.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            // obj_JSON = JSON.parse(obj);
            console.log(obj);
            console.log('有回來');
        })
        location.href = 'admin.php';
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>