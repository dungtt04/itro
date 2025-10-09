<?php
// controllers/RegisterController.php
require_once __DIR__ . '/../models/UserModel.php';

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password2 = trim($_POST['password2'] ?? '');
    if ($username === '' || $password === '' || $password2 === '') {
        $error = 'Vui lòng nhập đầy đủ các trường!';
    } elseif ($password !== $password2) {
        $error = 'Mật khẩu nhập lại không khớp!';
    } else {
        $result = UserModel::register($username, $password);
        if ($result === 'exists') {
            $error = 'Tên đăng nhập đã tồn tại!';
        } elseif ($result === true) {
            $success = 'Tạo tài khoản thành công, vui lòng chờ duyệt trong 2 -3 ngày!';
        } else {
            $error = 'Có lỗi xảy ra, vui lòng thử lại!';
        }
    }
}
include __DIR__ . '/../views/register.php';
