<?php
// auth.php - kiểm tra đăng nhập cho admin
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}
