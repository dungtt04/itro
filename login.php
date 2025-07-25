<?php
// login.php
session_start();
require_once __DIR__ . '/models/AuthModel.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = AuthModel::login($username, $password);
    if ($user) {
        $_SESSION['user'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Sai tài khoản hoặc mật khẩu!';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập quản trị</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; }
        .login-box { max-width: 350px; margin: 80px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #ccc; padding: 32px 28px; }
        h2 { text-align: center; margin-bottom: 18px; }
        input[type=text], input[type=password] { width: 100%; padding: 10px; margin: 8px 0 16px 0; border: 1px solid #bbb; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #222; color: #fff; border: none; border-radius: 4px; font-size: 16px; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Đăng nhập quản trị</h2>
    <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Tài khoản" required autofocus>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>
</div>
</body>
</html>
