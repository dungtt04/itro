<?php
// register.php
require_once __DIR__ . '/models/AuthModel.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    if ($username === '' || $password === '' || $password2 === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    } elseif ($password !== $password2) {
        $error = 'Mật khẩu nhập lại không khớp!';
    } else {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Tài khoản đã tồn tại!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin (username, password, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$username, $hash]);
            $success = 'Đăng ký thành công! Bạn có thể đăng nhập.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản quản trị</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; }
        .register-box { max-width: 350px; margin: 80px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #ccc; padding: 32px 28px; }
        h2 { text-align: center; margin-bottom: 18px; }
        input[type=text], input[type=password] { width: 100%; padding: 10px; margin: 8px 0 16px 0; border: 1px solid #bbb; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #222; color: #fff; border: none; border-radius: 4px; font-size: 16px; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
        .success { color: green; text-align: center; margin-bottom: 10px; }
        .link { text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
<div class="register-box">
    <h2>Đăng ký tài khoản quản trị</h2>
    <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Tài khoản" required autofocus>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="password" name="password2" placeholder="Nhập lại mật khẩu" required>
        <button type="submit">Đăng ký</button>
    </form>
    <div class="link"><a href="login.php">Đã có tài khoản? Đăng nhập</a></div>
</div>
</body>
</html>
<?php
// register.php
require_once __DIR__ . '/models/AuthModel.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    if ($username === '' || $password === '' || $password2 === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    } elseif ($password !== $password2) {
        $error = 'Mật khẩu nhập lại không khớp!';
    } else {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Tài khoản đã tồn tại!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin (username, password, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$username, $hash]);
            $success = 'Đăng ký thành công! Bạn có thể đăng nhập.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản quản trị</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; }
        .register-box { max-width: 350px; margin: 80px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #ccc; padding: 32px 28px; }
        h2 { text-align: center; margin-bottom: 18px; }
        input[type=text], input[type=password] { width: 100%; padding: 10px; margin: 8px 0 16px 0; border: 1px solid #bbb; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #222; color: #fff; border: none; border-radius: 4px; font-size: 16px; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
        .success { color: green; text-align: center; margin-bottom: 10px; }
        .link { text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
<div class="register-box">
    <h2>Đăng ký tài khoản quản trị</h2>
    <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Tài khoản" required autofocus>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="password" name="password2" placeholder="Nhập lại mật khẩu" required>
        <button type="submit">Đăng ký</button>
    </form>
    <div class="link"><a href="login.php">Đã có tài khoản? Đăng nhập</a></div>
</div>
</body>
</html>
