<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "member";
$title = "member";


// 沒有選到sid, sid=0 顯示沒有這個會員
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;


if ($sid == 0) {
    // TODO : 顯示找不到會員
    header("Location: member.php"); // 轉向到列表頁
    exit;
}

$sql = "SELECT m.*, 
    e.emrg_name, e.emrg_relationship, e.emrg_mobile 
    FROM `member` m 
    JOIN `emergency_contact` e 
    ON m.sid=e.`member_sid` 
    WHERE sid=$sid;";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
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
            <form name="form1" onsubmit="checkForm(event)">
                <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                <table class="table">
                    <tr>
                        <th scope="row"><label for="name" class="col-form-label">姓名*</label></th>
                        <td><input type="text" class="form-control" id="name" name="name" required
                                value="<?= htmlentities($r['name']) ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="account" class="col-form-label">帳號*</label></th>
                        <td><input type="text" class="form-control" id="account" name="account" required
                                value="<?= $r['account'] ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="gender" class="col-form-label">性別</label></th>
                        <td>
                            <select class="ms-3" name="gender" id="gender">
                                <option value="male" <?= ($r['gender'] == "male") ? "selected" : '' ?>>male</option>
                                <option value="female" <?= ($r['gender'] == "female") ? "selected" : '' ?>>female
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="birthday" class="col-form-label">生日*</label></th>
                        <td colspan="2"><input type="date" class="form-control" id="birthday" name="birthday" required
                                value="<?= $r['birthday'] ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="mobile" class="col-form-label">手機*</label></th>
                        <td colspan="2"><input type="tel" class="form-control" id="mobile" name="mobile" required
                                value="<?= $r['mobile'] ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="address" class="col-form-label">地址</label></th>
                        <td colspan="2"><input type="text" class="form-control" id="address" name="address"
                                value="<?= $r['address'] ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="email" class="col-form-label">email*</label></th>
                        <td colspan="2"><input type="email" class="form-control" id="email" name="email" required
                                value="<?= $r['email'] ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="personalid" class="col-form-label">身分證字號*</label></th>
                        <td colspan="2"><input type="text" class="form-control" id="personalid" name="personalid"
                                required value="<?= $r['personal_id'] ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="member_status" class="col-form-label">會員狀態</label></th>
                        <td colspan="2">
                            <select class="ms-3" name="member_status" id="member_status">
                                <option value="1" <?= ($r['member_status'] == 1) ? "selected" : '' ?>>使用中</option>
                                <option value="0" <?= ($r['member_status'] == 0) ? "selected" : '' ?>>已停權</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <table class="table mt-2">
                    <h6>緊急聯絡人</h6>
                    <tr>
                        <th scope="row">姓名*</th>
                        <td><input type="text" class="form-control" id="ermg_name" name="ermg_name" required
                                value="<?= htmlentities($r['emrg_name']) ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row">手機*</th>
                        <td><input type="tel" class="form-control" id="emrg_mobile" name="emrg_mobile" required
                                value="<?= $r['emrg_mobile'] ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row">關係</th>
                        <td><input type="text" class="form-control" id="emrg_relationship" name="emrg_relationship"
                                required value="<?= $r['emrg_relationship'] ?>"></td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-primary">完成編輯</button>
            </form>
        </div>
    </div>



</div>


<?php require __DIR__ . '/parts/scripts.php' ?>
<script>
// 格式設定
const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;
const email_re =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
const personalid_re = /^[a-zA-Z]\d{9}$/;

const checkForm = function(event) {
    event.preventDefault();
    // 欄位外觀回復原來的樣子
    document.form1.querySelectorAll('input').forEach(function(el) {
        el.style.border = '1px solid #CCCCCC';
    });
    document.form1.querySelectorAll('span').forEach(function(el) {
        el.innerHTML = '';
    });

    // 欄位檢查
    let isPass = true;
    let field = document.form1.querySelectorAll('#name')[0];
    let fieldtext = document.form1.querySelectorAll('#name')[1];
    if (field.value.length < 2) {
        isPass = false;
        field.style.border = '2px solid red';
        fieldtext.innerHTML = '請填寫正確的姓名';
    }

    field = document.form1.querySelectorAll('#email')[0];
    fieldtext = document.form1.querySelectorAll('#email')[1];
    if (!email_re.test(field.value)) {
        isPass = false;
        field.style.border = '2px solid red';
        fieldtext.innerHTML = '請填寫正確的email格式';
    }

    field = document.form1.querySelectorAll('#mobile')[0];
    fieldtext = document.form1.querySelectorAll('#mobile')[1];
    if (!mobile_re.test(field.value)) {
        isPass = false;
        field.style.border = '2px solid red';
        fieldtext.innerHTML = '請填寫正確的手機號碼';
    }

    field = document.form1.querySelectorAll('#personalid')[0];
    fieldtext = document.form1.querySelectorAll('#personalid')[1];
    if (!personalid_re.test(field.value)) {
        isPass = false;
        field.style.border = '2px solid red';
        fieldtext.innerHTML = '請填寫正確的身分證字號';
    }


    if (isPass) {
        const fd = new FormData(document.form1);

        fetch('member_edit-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.text()).then(obj => {
            // console.log(obj);
            obj_JSON = JSON.parse(obj);
            if (obj_JSON.success) {
                alert('修改成功');
            } else {
                $msg = obj_JSON.msg;
                alert($msg);
            }
            location.href = 'member_detail.php?sid=<?= $sid ?>';
            // location.href = 'member.php';  
        });
    }
};
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>