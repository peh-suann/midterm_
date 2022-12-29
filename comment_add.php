<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "comment_add";
$title = "comment_add";

// echo '1';

// 沒有選到sid, sid=0 顯示沒有這個會員
$sid = isset($_GET['member_sid']) ? intval($_GET['member_sid']) : 0;
$rows = [];
$sql = "SELECT * FROM `rating` WHERE 1";
$rows = $pdo->query($sql)->fetchAll();

$trail_rows = [];
$trail_sql = "SELECT `trail_name`,`sid` FROM `trails` ";
$trail_rows = $pdo->query($trail_sql)->fetchAll();
?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<div class="container">
    <h2>評論管理</h2>
    <h3>新增評論</h3>
    <div class="row col-8 add-comment-card ">
        <form name="add_comment" method="POST" onsubmit="checkComment()">
            <div class="mb-3 mt-3">
                <label for="person" class="form-label">評論人</label>
                <input type="text" class="form-control" id="person" name="person" placeholder="">
            </div>
            <div class="mb-3 mt-3">
                <label for="member" class="form-label">會員編號</label>
                <input type="text" class="form-control" id="member" name="member" placeholder="">
            </div>

            <div class="mb-3">
                <label for="score" class="form-label">評分（5星~1星）</label>
                <div class="d-flex">
                    <select class="px-5" name="score" id="score">
                        <option value="5" selected>5星</option>
                        <option value="4">4星</option>
                        <option value="3">3星</option>
                        <option value="2">2星</option>
                        <option value="1">1星</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="trails" class="form-label">參加行程</label>
                <div class="d-flex">
                    <select class="px-5" name="trails" id="trails">
                        <?php foreach ($trail_rows as $t_r) : ?>
                            <option value="<?= $t_r['sid'] ?>"><?= $t_r['trail_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="trails" class="form-label">評論內容</label>
                <textarea class="form-control" name="comment_text" id="comment_text" rows="6" cols="50" placeholder="請寫下您寶貴的評論"></textarea>
            </div>
            <button class="btn btn-primary col-1 mb-3" type="submit">送出</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
    let isPass = true;

    function checkComment() {

        if (isPass) {
            const fd = new FormData(document.add_comment);
            fetch('comment_add_api.php', {
                method: 'POST',
                body: fd,
            }).then(
                response => response.text()
            ).then(

                obj => {
                    let obj_json = JSON.parse(obj);
                    if (obj_json['success']) {

                        alert('新增成功！');
                        location.href = 'comment.php';
                    }
                }

            )
        }
    }
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>