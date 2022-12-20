<?php require __DIR__ . '/parts/connect_db.php';

unset($_SESSION['admin']);


?>
<script>
    // console.log(10);
    alert('已登出');
    location.href = '/peh-suann.github.io/login.php';
</script>