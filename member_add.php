<?php require __DIR__ . '/parts/connect_db.php' ?>
<?php
$pageName = "member";
$title = "member";

// echo '1';

// 沒有選到sid, sid=0 顯示沒有這個會員
$sid = isset($_GET['member_sid']) ? intval($_GET['member_sid']) : 0;


?>
<?php require __DIR__ . '/parts/html-head.php' ?>
<?php require __DIR__ . '/parts/navbar.php' ?>

<div class="container">
    <h2 class="mt-3">會員管理</h2>
    <h3 class="mt-3">新增會員</h3>
    <div class="row">
        <div class="col">
            <form name="form1" onsubmit="checkForm(event)">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="name" class="col-form-label">姓名*</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="name" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="gender" class="col-form-label">性別</label>
                        <select class="ms-3" name="gender" id="gender">
                            <option value="male" selected>male</option>
                            <option value="female">female</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="birthday" class="col-form-label">生日*</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" id="birthday" name="birthday" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="birthday" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="mobile" class="col-form-label">手機*</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="mobile" name="mobile" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="mobile" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="address" class="col-form-label">地址</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="address" name="address" class="form-control">
                    </div>
                    <div class="col-auto">
                        <span id="address" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="email" class="col-form-label">email*</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="email" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="personalid" class="col-form-label">身分證字號*</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="personalid" name="personalid" class="form-control">
                    </div>
                    <div class="col-auto">
                        <span id="personalid" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="member_status" class="col-form-label">會員狀態</label>
                        <select class="ms-3" name="member_status" id="member_status">
                            <option value="1" selected>使用中</option>
                            <option value="0">已停權</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 align-items-center mt-5">
                    <div class="col-auto">
                        <label for="account" class="col-form-label">帳號*</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="account" name="account" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="account" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="password" class="col-form-label">密碼*</label>
                    </div>
                    <div class="col-auto">
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="password" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="password2" class="col-form-label">再次輸入密碼*</label>
                    </div>
                    <div class="col-auto">
                        <input type="password" id="password2" name="password2" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="password2" class="form-text"></span>
                    </div>
                </div>


                <h6 class="mt-5">緊急聯絡人</h6>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="emrg_name" class="col-form-label">姓名*</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="emrg_name" name="emrg_name" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="emrg_name" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="emrg_mobile" class="col-form-label">手機*</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="emrg_mobile" name="emrg_mobile" class="form-control" required>
                    </div>
                    <div class="col-auto">
                        <span id="emrg_mobile" class="form-text"></span>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="emrg_relationship" class="col-form-label">關係</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="emrg_relationship" name="emrg_relationship" class="form-control">
                    </div>
                    <div class="col-auto">
                        <span id="emrg_relationship" class="form-text"></span>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">新增</button>
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

    // 密碼確認
    field = document.form1.querySelectorAll('#password')[0];
    fieldtext = document.form1.querySelectorAll('#password')[1];
    let field1 = document.form1.querySelectorAll('#password2')[0];
    let field1text = document.form1.querySelectorAll('#password2')[1];
    if (field.value != field1.value) {
        isPass = false;
        field.style.border = '2px solid red';
        field1.style.border = '2px solid red';
        field1text.innerHTML = '輸入密碼不相等';
    }

    // 緊急聯絡人姓名
    field = document.form1.querySelectorAll('#emrg_name')[0];
    fieldtext = document.form1.querySelectorAll('#emrg_name')[1];
    if (field.value.length < 2) {
        isPass = false;
        field.style.border = '2px solid red';
        fieldtext.innerHTML = '請填寫正確的姓名';
    }

    // 緊急聯絡人手機
    field = document.form1.querySelectorAll('#emrg_mobile')[0];
    fieldtext = document.form1.querySelectorAll('#emrg_mobile')[1];
    if (!mobile_re.test(field.value)) {
        isPass = false;
        field.style.border = '2px solid red';
        fieldtext.innerHTML = '請填寫正確的手機號碼';
    }

    if (isPass) {

        const fd = new FormData(document.form1);

        fetch('member_add-api.php', {
            method: 'POST',
            body: fd,
        }).then(r => r.text()).then(obj => {
            let obj_json = JSON.parse(obj);
            if (obj_json['success']) {
                alert('新增成功!');
                location.href = 'member.php';
            }
        });

    }



};
</script>
<?php require __DIR__ . '/parts/html-foot.php' ?>