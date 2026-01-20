<?php
// login.php
session_start();
require_once __DIR__ . '/models/AuthModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = AuthModel::login($username, $password);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['status'] === 'pending') {
            $_SESSION['error_message'] = 'Tài khoản đang chờ duyệt, vui lòng thử lại sau.';
        } elseif ($user['status'] === 'block') {
            $_SESSION['error_message'] = 'Tài khoản bị chặn, vui lòng liên hệ quản trị viên.';
        } elseif ($user['status'] === 'active') {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['error_message'] = 'Tài khoản không hợp lệ.';
        }
    } else {
        $_SESSION['error_message'] = 'Sai tài khoản hoặc mật khẩu!';
    }

    // Reload lại trang để hiển thị toast
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="shortcut icon" href="itro-logo-vuong.png" type="image/x-icon">
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

        .imgItro {
            display: none;
        }

        .support2 {
            display: none;
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
                padding: 20px 0px;
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

            .support2 {
                display: block;
            }

            .imgItro {
                display: block;
            }
        }

        .inforRight {
            display: none;
        }

        @media (max-width: 1200px) {
            .inforRight {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                margin-bottom: 18px;
                border-bottom: 1px solid #ccc;
            }

            .inforRight .imgItro {
                margin-right: 12px;
                display: block;
            }

            .inforRight h3 {
                flex: 1;
                text-align: right;
                margin: 0;
                font-size: 20px;
                font-weight: 700;
                color: #155a9a;
                margin-right: 20px;
            }
        }

        /* Nút hiển thị mật khẩu */
        .show-pass-btn {
            display: block;
            margin: -10px 0 18px auto;
            background: #e3eafc;
            color: #093d62;
            border: none;
            border-radius: 6px;
            padding: 7px 18px;
            min-width: 120px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
        }

        .show-pass-btn:hover {
            background: #093d62;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="left">
        <div class="logo">
            <img src="itro-logo.png" alt="iTrọ">
        </div>
        <h1>HỆ THỐNG QUẢN LÝ NHÀ TRỌ</h1>
        <div class="support">
            <p>Hỗ trợ kỹ thuật: <span>0343.133.166</span></p>
            <p>Email hỗ trợ: <span>admin@dungtt.id.vn</span></p>
        </div>
        <span style="font-size: 12px">Version 1.10</span>
    </div>

    <div class="right">
        <div class="inforRight">
            <img class="imgItro" src="itro-logo.png" alt="iTrọ" style="width: 120px; height: auto;">
            <h3>Hệ thống quản lý nhà trọ iTrọ</h3>
        </div>

        <h2>Đăng nhập hệ thống</h2>

        <form style="width:100%" method="post">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập..." required>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="passwordInput" name="password" placeholder="Nhập mật khẩu..." required>

            <button type="button" class="show-pass-btn" onclick="togglePassword()" id="showPassBtn">Hiển thị mật khẩu</button>
            <button type="submit" class="btn-login">Đăng nhập</button>

            <div class="btn-register"><a href="register.php">Đăng ký</a></div>
        </form>

        <hr>
        <div class="support2">
            <p>Hỗ trợ kỹ thuật: <span>0343.133.166</span></p>
            <p>Email hỗ trợ: <span>admin@dungtt.id.vn</span></p>
        </div>
    </div>

    <!-- Hiển thị lỗi dạng toast -->
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div id="error-toast" style="position:fixed;top:32px;right:32px;z-index:9999;background:red;color:#fff;padding:14px 28px;border-radius:8px;box-shadow:0 2px 12px #093d6240;font-size:16px;animation:fadeIn 0.5s;">
            <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
        <script>
            setTimeout(function() {
                var toast = document.getElementById('error-toast');
                if (toast) toast.style.display = 'none';
            }, 3500);
        </script>
        <style>
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        </style>
    <?php endif; ?>

    <script>
        function togglePassword() {
            var input = document.getElementById('passwordInput');
            var btn = document.getElementById('showPassBtn');
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Ẩn mật khẩu';
            } else {
                input.type = 'password';
                btn.textContent = 'Hiển thị mật khẩu';
            }
        }
    </script>
</body>

</html>
