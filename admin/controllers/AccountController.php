<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/UserModel.php';

// // Kiểm tra khóa truy cập quản lý tài khoản
// if (isset($_SESSION['account_manage_lock_time']) && time() < $_SESSION['account_manage_lock_time']) {
//     $wait = ceil(($_SESSION['account_manage_lock_time'] - time()) / 60);
//     echo '<div class="container" style="max-width:400px;margin:80px auto;background:#fff;padding:32px 28px;border-radius:8px;box-shadow:0 2px 8px #ccc;">';
//     echo '<h2>Bạn đã nhập sai quá 3 lần!</h2>';
//     echo '<div class="error" style="color:red;text-align:center;margin-bottom:10px;">Vui lòng thử lại sau ' . $wait . ' phút.</div>';
//     echo '</div>';
//     exit;
// }

// if (!isset($_SESSION['account_manage_pass']) || $_SESSION['account_manage_pass'] !== '030204005842') {
//     if (!isset($_SESSION['account_manage_fail'])) $_SESSION['account_manage_fail'] = 0;
//     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['account_manage_pass'])) {
//         if ($_POST['account_manage_pass'] === '030204005842') {
//             $_SESSION['account_manage_pass'] = '030204005842';
//             $_SESSION['account_manage_fail'] = 0;
//             unset($_SESSION['account_manage_lock_time']);
//             header('Location: index.php?controller=account&action=index');
//             exit;
//         } else {
//             $_SESSION['account_manage_fail']++;
//             if ($_SESSION['account_manage_fail'] >= 3) {
//                 $_SESSION['account_manage_lock_time'] = time() + 600; // 10 phút
//                 echo '<div class="container" style="max-width:400px;margin:80px auto;background:#fff;padding:32px 28px;border-radius:8px;box-shadow:0 2px 8px #ccc;">';
//                 echo '<h2>Bạn đã nhập sai quá 3 lần!</h2>';
//                 echo '<div class="error" style="color:red;text-align:center;margin-bottom:10px;">Vui lòng thử lại sau 10 phút.</div>';
//                 echo '</div>';
//                 exit;
//             } else {
//                 $error = 'Mật khẩu truy cập không đúng!';
//             }
//         }
//     }
//     echo '<div class="container" style="max-width:400px;margin:80px auto;background:#fff;padding:32px 28px;border-radius:8px;box-shadow:0 2px 8px #ccc;">';
//     echo '<h2>Nhập mật khẩu quản lý tài khoản</h2>';
//     if (!empty($error)) echo '<div class="error" style="color:red;text-align:center;margin-bottom:10px;">' . $error . '</div>';
//     echo '<form method="post"><input type="password" name="account_manage_pass" placeholder="Mật khẩu quản lý" required style="width:100%;padding:10px;margin-bottom:16px;border:1px solid #bbb;border-radius:4px;">';
//     echo '<button type="submit" style="width:100%;padding:10px;background:#093d62;color:#fff;border:none;border-radius:4px;font-size:16px;">Xác nhận</button></form></div>';
//     exit;
// }

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'change_password':
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['id'];
            $old = $_POST['old_password'] ?? '';
            $new = $_POST['new_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $user = UserModel::getById($userId);
            if (!$user || !password_verify($old, $user['password'])) {
                $error = 'Mật khẩu cũ không đúng!';
            } elseif (strlen($new) < 6) {
                $error = 'Mật khẩu mới phải từ 6 ký tự!';
            } elseif ($new !== $confirm) {
                $error = 'Nhập lại mật khẩu mới không khớp!';
            } else {
                $hash = password_hash($new, PASSWORD_DEFAULT);
                UserModel::updatePassword($userId, $hash);
                $success = 'Đổi mật khẩu thành công!';
            }
        }
        // Hiển thị lại modal nếu có lỗi hoặc thành công
        echo '<script>setTimeout(function(){document.getElementById("change-password-modal").style.display="block";}, 100);</script>';
        if ($error) echo '<script>alert("' . addslashes($error) . '");</script>';
        if ($success) echo '<script>alert("' . addslashes($success) . '");window.location.href="index.php";</script>';
        $users = UserModel::getAll();
        include __DIR__ . '/../views/account/account_list.php';
        break;
    case 'approve':
        $id = $_GET['id'] ?? 0;
        UserModel::updateStatus($id, 'active');
        $_SESSION['success_message'] = 'Duyệt tài khoản thành công!';
        header('Location: index.php?controller=account&action=index');
        exit;
    case 'block':
        $id = $_GET['id'] ?? 0;
        $user = UserModel::getById($id);
        if ($user && $user['role'] === 'general_admin') {
            $_SESSION['error_message'] = 'Không thể khóa tài khoản quản trị viên!';
            header('Location: index.php?controller=account&action=index');
            exit;
        }
        UserModel::updateStatus($id, 'block');
        $_SESSION['success_message'] = 'Đã khóa tài khoản!';
        header('Location: index.php?controller=account&action=index');
        exit;
    case 'unblock':
        $id = $_GET['id'] ?? 0;
        UserModel::updateStatus($id, 'active');
        $_SESSION['success_message'] = 'Đã mở khóa tài khoản!';
        header('Location: index.php?controller=account&action=index');
        exit;
    case 'make_admin':
        $id = $_GET['id'] ?? 0;
        $user = UserModel::getByID($id);
        if ($user && $user['status'] === 'block') {
            $_SESSION['error_message'] = 'Không thể nâng cấp tài khoản bị khóa';
            header('Location: index.php?controller=account&action=index');
            exit;
        }

        UserModel::updateRole($id, 'general_admin');
        $_SESSION['success_message'] = 'Đã chuyển thành quản trị viên!';
        header('Location: index.php?controller=account&action=index');
        exit;
    case 'demote_admin':
        $id = $_GET['id'] ?? 0;
        UserModel::updateRole($id, 'admin');
        $_SESSION['success_message'] = 'Đã hạ cấp quản trị viên xuống quản lý!';
        header('Location: index.php?controller=account&action=index');
        exit;
    case 'index':
    default:
        $users = UserModel::getAll();
        include __DIR__ . '/../views/account/account_list.php';
        break;
}
