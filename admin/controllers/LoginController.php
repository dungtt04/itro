<?php
// session_start();
// require_once __DIR__ . '/../models/AdminModel.php';
// $error = '';
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $username = trim($_POST['username'] ?? '');
//     $password = trim($_POST['password'] ?? '');
//     $user = UserModel::login($username, $password);
//     if ($user) {
//         $_SESSION['admin_logged_in'] = true;
//             $_SESSION['user'] = [
//                 'id' => $user['id'],
//                 'username' => $user['username'],
//                 // 'fullname' => $user['fullname'],
//                 'role' => $user['role']
//             ];
//     echo '<pre>'; print_r($_SESSION); echo '</pre>'; // Thêm dòng này để kiểm tra session
//         // header('Location: index.php');
//         exit;
//     } else {
//         $error = 'Sai mã admin hoặc mật khẩu!';
//     }
// }
// include __DIR__ . '/../views/login.php';
