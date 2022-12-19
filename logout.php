<?php require __DIR__ . '/parts/connect_db.php'; 

unset($_SESSION['admin']);

?>
<script>
alert('已登出');
</script>

<?php header('Location: index_.php'); ?>