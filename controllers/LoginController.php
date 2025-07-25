<?php
// session_start();
require_once __DIR__ . '/../models/UserModel.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $user = UserModel::login($username, $password);
    if ($user) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Sai mã admin hoặc mật khẩu!';
    }
}
include __DIR__ . '/../views/login.php';
