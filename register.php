<?php
// register.php
session_start();
require_once __DIR__ . '/models/AuthModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($username === '' || $password === '' || $password2 === '') {
        $_SESSION['error_message'] = 'Vui lòng nhập đầy đủ thông tin!';
    } elseif ($password !== $password2) {
        $_SESSION['error_message'] = 'Mật khẩu nhập lại không khớp!';
    } else {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $_SESSION['error_message'] = 'Tài khoản đã tồn tại!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin (username, password, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$username, $hash]);
            $_SESSION['success_message'] = 'Tạo tài khoản thành công, vui lòng chờ duyệt trong 2-3 ngày!';
        }
    }

    // Load lại trang để hiển thị toast
    header('Location: register.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản quản trị</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            display: flex;
            height: 100vh;
        }

        /* Bên trái */
        .left {
            width: 50%;
            background-color: #155a9a;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding-left: 80px;
        }

        .logo {
            display: flex;
            align-items: center;
            background: #fff;
            color: #155a9a;
            border-radius: 12px;
            padding: 15px 25px;
            font-size: 24px;
            font-weight: bold;
        }

        .logo img {
            height: 60px;
            margin-right: 10px;
        }

        h1 {
            font-size: 28px;
            margin-top: 40px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .support {
            margin-top: 40px;
            line-height: 1.8;
        }

        .support span {
            font-weight: bold;
        }

        /* Bên phải */
        .right {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 0 80px;
        }

        .right h2 {
            color: #155a9a;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 30px;
        }

        label {
            font-size: 18px;
            color: #155a9a;
            margin-bottom: 8px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #cfd8dc;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .btn-login {
            width: 100%;
            background-color: #155a9a;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-register {
            width: 90%;
            background-color: transparent;
            border: 2px solid #155a9a;
            color: #155a9a;
            font-size: 18px;
            font-weight: 500;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
            text-decoration: none;
        }

        .btn-register a {
            color: #155a9a;
            font-size: 18px;
            font-weight: 500;
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
        }

        .btn-login:hover {
            background-color: #0d3f70;
        }

        @media (max-width: 1200px) {
            body {
                flex-direction: column;
                height: auto;
            }

            .left {
                display: none;
            }

            .right {
                width: 100%;
                padding: 40px 20px;
                align-items: center;
            }

            .right h2 {
                font-size: 28px;
                text-align: center;
            }

            form {
                width: 100%;
                max-width: 400px;
            }
        }
    </style>
</head>

<body>
    <div class="left">
        <div class="logo">
            <img src="../itro-logo.png" alt="iTrọ">
        </div>
        <h1 style="text-align: right;">HỆ THỐNG QUẢN LÝ NHÀ TRỌ</h1>
        <div class="support">
            <p>Hỗ trợ kỹ thuật: <span>0343.133.166</span></p>
            <p>Email hỗ trợ: <span>ttiendung2004lv@gmail.com</span></p>
        </div>
    </div>

    <div class="right">
        <h2>Đăng ký tài khoản quản trị</h2>

        <form method="post">
            <input type="text" name="username" placeholder="Tài khoản" required autofocus>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="password" name="password2" placeholder="Nhập lại mật khẩu" required>
            <button type="submit" class="btn-login">Đăng ký</button>
            <div class="btn-register"><a href="login.php">Đã có tài khoản? Đăng nhập</a></div>
        </form>
    </div>

    <!-- ✅ Toast Thông báo -->
    <?php if (!empty($_SESSION['error_message']) || !empty($_SESSION['success_message'])): ?>
        <div id="toast-message"
            style="position:fixed;top:32px;right:32px;z-index:9999;
                background:<?= !empty($_SESSION['error_message']) ? 'red' : '#1e7e34' ?>;
                color:#fff;padding:14px 28px;border-radius:8px;
                box-shadow:0 2px 12px #093d6240;font-size:16px;
                animation:fadeIn 0.5s, slideIn 0.4s;">
            <?= !empty($_SESSION['error_message']) ? $_SESSION['error_message'] : $_SESSION['success_message']; ?>
            <?php
            unset($_SESSION['error_message']);
            unset($_SESSION['success_message']);
            ?>
        </div>

        <script>
            setTimeout(function() {
                var toast = document.getElementById('toast-message');
                if (toast) toast.style.display = 'none';
            }, 3500);
        </script>
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                }

                to {
                    transform: translateX(0);
                }
            }
        </style>
    <?php endif; ?>
</body>

</html>
