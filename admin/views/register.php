
<?php
$title = 'Đăng ký tài khoản admin';
$headContent = '<style>
    .register-box { max-width: 350px; margin: 80px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    input[type=text], input[type=password] { width: 100%; padding: 10px; margin: 10px 0 18px 0; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; }
    button { width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    .error { color: #d93025; background: #fff0f0; border: 1.5px solid #f8d7da; border-radius: 6px; padding: 10px; margin-bottom: 10px; text-align: center; }
    .success { color: #388e3c; background: #f0fff0; border: 1.5px solid #c8e6c9; border-radius: 6px; padding: 10px; margin-bottom: 10px; text-align: center; }
    @media (max-width: 500px) {
        .register-box {
            max-width: 98vw;
            margin: 30px 1vw;
            padding: 18px 8px;
        }
        h2 {
            font-size: 20px;
        }
        input[type=text], input[type=password] {
            font-size: 15px;
            padding: 9px;
        }
        button {
            font-size: 15px;
            padding: 9px;
        }
    }
</style>';
ob_start();
?>
<div class="register-box">
    <h2>Đăng ký tài khoản admin</h2>
    <?php if (!empty($error)): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <?php if (!empty($success)): ?><div class="success"><?= $success ?></div><?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Mã admin" required autofocus>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="password" name="password2" placeholder="Nhập lại mật khẩu" required>
        <button type="submit">Tạo tài khoản</button>
    </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
