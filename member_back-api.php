<?php
require __DIR__ . '/parts/connect_db.php';

echo $_SERVER['HTTP_REFERER'];

if (empty($_SERVER['HTTP_REFERER'])) {
    header('Location: member.php');
} else {
    // 回到原本刪除的頁面 (HTTP_REFERER)
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
