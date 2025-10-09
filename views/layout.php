<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Trang quản lý' ?></title>
    <link rel="shortcut icon" href="itro-logo-vuong.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php if (!empty($headContent)) echo $headContent; ?>
    <style>
        nav.menu-bar {
            background: #fff !important;
            box-shadow: 0 2px 8px #0001;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1.5px solid #e5e7eb;
            min-height: 60px;
        }

        .menu-bar-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            gap: 18px;
            align-items: center;
            position: relative;
            min-height: 60px;
            padding: 0 18px;
        }

        .menu-logo {
            width: 80px;
            transition: width 0.2s;
        }

        .menu-toggle {
            display: none;
            background: none;
            color: #093d62;
            border: none;
            font-size: 28px;
            border-radius: 6px;
            padding: 8px 16px;
            margin-right: 10px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .menu-toggle:hover {
            background: #f3f6fa;
        }

        .menu-bar-links {
            display: flex;
            gap: 18px;
            align-items: center;
            flex: 1;
            transition: all 0.2s;
        }

        .menu-bar-links a,
        .menu-dropdown>a {
            color: #093d62 !important;
            font-weight: 500;
            text-decoration: none;
            padding: 10px 22px;
            font-size: 17px;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
            display: inline-block;
        }

        .menu-bar-links a.active,
        .menu-bar-links a:hover,
        .menu-dropdown.open>a {
            background: #093d62 !important;
            color: #fff !important;
        }

        .menu-dropdown {
            position: relative;
        }

        .menu-dropdown-content {
            display: none;
            position: absolute;
            left: 0;
            top: 100%;
            background: #fff;
            min-width: 180px;
            box-shadow: 0 2px 8px #0002;
            border-radius: 8px;
            z-index: 10;
            margin-top: 2px;
        }

        .menu-dropdown-content a {
            display: block;
            padding: 10px 22px;
            color: #093d62 !important;
            background: #fff;
            border-radius: 0;
            font-size: 16px;
        }

        .menu-dropdown-content a:hover {
            background: #093d62 !important;
            color: #fff !important;
        }

        .menu-dropdown:hover .menu-dropdown-content,
        .menu-dropdown.open .menu-dropdown-content {
            display: block;
        }

        .menu-bar-user {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .user-greeting {
            cursor: pointer;
            display: inline-block;
            padding: 8px 18px;
            background: #f3f6fa;
            border-radius: 6px;
            font-weight: 500;
            color: #093d62;
            transition: background 0.2s, color 0.2s;
            box-shadow: 0 2px 8px #093d6240;
        }

        .user-greeting:hover,
        .user-greeting:focus {
            background: #e3eafc;
            color: #093d62;
        }

        .user-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 110%;
            background: #fff;
            box-shadow: 0 4px 24px #093d6240;
            border-radius: 10px;
            min-width: 200px;
            z-index: 999;
            padding: 8px 0;
            animation: fadeInUserDropdown 0.18s;
        }

        .user-dropdown-menu a {
            display: block;
            padding: 12px 22px;
            color: #093d62;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
            transition: background 0.18s, color 0.18s;
        }

        .user-dropdown-menu a:hover {
            background: #e3eafc;
            color: #093d62;
        }

        @keyframes fadeInUserDropdown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

@media (max-width: 900px) {
    .menu-bar-inner {
        min-height: 60px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .menu-logo {
        width: 44px;
        margin: 8px 0;
    }

    /* Gộp nút menu và user thành 1 cụm bên phải */
    .menu-right-group {
        display: flex;
        align-items: center;
        gap: 6px;
        position: absolute;
        right: 10px;
        top: 8px;
        z-index: 1100;
    }

    .menu-toggle {
        display: inline-block;
        background: none;
        color: #093d62;
        border: none;
        font-size: 28px;
        border-radius: 6px;
        padding: 6px 10px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .menu-toggle:hover {
        background: #f3f6fa;
    }

    .menu-bar-user {
        position: static;
        margin: 0;
    }

    .menu-bar-links {
        display: none;
        flex-direction: column;
        background: #fff;
        position: absolute;
        top: 60px;
        left: 0;
        width: 100vw;
        box-shadow: 0 2px 8px #0002;
        border-radius: 0 0 10px 10px;
        z-index: 1001;
        padding: 10px 0;
        animation: slideDown 0.25s;
    }

    .menu-bar-links.active {
        display: flex !important;
    }

    .menu-bar-links a,
    .menu-dropdown-content a {
        width: 100vw;
        padding-left: 22px !important;
        font-size: 17px;
        border-bottom: 1px solid #f0f0f0;
        box-sizing: border-box;
        text-align: left;
    }

    .menu-dropdown-content {
        position: static;
        box-shadow: none;
        border-radius: 0;
        background: #f8fafc;
    }

    .menu-dropdown-content a {
        padding-left: 36px !important;
    }
}

        @media (max-width: 600px) {
            .menu-bar-inner {
                padding: 0 2vw;
            }

            .menu-bar-links a,
            .menu-dropdown-content a {
                font-size: 15px;
                text-align: left;
                padding: 10px 8px 10px 18px;
                width: 100vw;
                box-sizing: border-box;
                border-bottom: 1px solid #f0f0f0;
            }

            /* .menu-logo {
                width: 38px;
            } */
        }

        .footer {
            background-color: #ffffff;
            border-top: 1px solid #eaeaea;
            padding: 18px 8%;
            font-family: "Inter", "Segoe UI", sans-serif;
            color: #444;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .footer-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo {
            height: 36px;
            width: auto;
        }

        .brand-name {
            font-weight: 600;
            color: #222;
            font-size: 15px;
        }

        .footer-right {
            font-size: 14px;
            color: #666;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .footer-right a {
            color: #0077cc;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-right a:hover {
            color: #005999;
            text-decoration: underline;
        }

        .dot {
            color: #ccc;
        }

        /* 📱 Responsive cho điện thoại */
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-left {
                justify-content: center;
            }

            .footer-right {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <?php
    // Ẩn header/footer nếu là giao diện khách hàng (customerportal)
    $noHeaderFooter = (isset($_GET['controller']) && $_GET['controller'] === 'customerportal');
    ?>
    <?php if (!$noHeaderFooter): ?>
        <nav class="menu-bar">
            <div class="menu-bar-inner">
                <a class="menu-logo" href="index.php?controller=dashboard">
                    <img src="itro-logo.png" class="menu-logo" alt="Logo" />
                </a>
                <button class="menu-toggle" onclick="document.querySelector('.menu-bar-links').classList.toggle('active')">☰
                </button>
                <div class="menu-bar-links">
                    <a href="index.php?controller=dashboard">Dashboard</a>
                    <div class="menu-dropdown">
                        <a href="#" onclick="event.preventDefault();this.parentNode.classList.toggle('open');return false;">Dịch vụ phòng</a>
                        <div class="menu-dropdown-content">
                            <a href="index.php?controller=room">Phòng ở</a>
                            <a href="index.php?controller=customer">Khách thuê</a>

                            <div class="menu-dropdown2">
                                <a href="#" onclick="event.preventDefault();this.parentNode.classList.toggle('open');return false;">Dịch vụ</a>
                                <div class="menu-dropdown2-content">
                                    <a href="index.php?controller=electricity">Điện</a>
                                    <a href="index.php?controller=water">Nước</a>
                                </div>
                            </div>
                            <style>
                                .menu-dropdown2 {
                                    position: relative;
                                    display: inline-block;
                                }

                                .menu-dropdown2>a {
                                    color: #093d62 !important;
                                    font-weight: 500;
                                    text-decoration: none;
                                    padding: 10px 22px;
                                    font-size: 17px;
                                    border-radius: 6px;
                                    transition: background 0.2s, color 0.2s;
                                    display: inline-block;
                                    background: none;
                                    white-space: nowrap;
                                }

                                .menu-dropdown2.open>a,
                                .menu-dropdown2>a:hover {
                                    background: #093d62 !important;
                                    color: #fff !important;
                                }

                                .menu-dropdown2-content {
                                    display: none;
                                    position: absolute;
                                    left: 100%;
                                    top: 0;
                                    background: #fff;
                                    min-width: 180px;
                                    box-shadow: 0 2px 8px #0002;
                                    border-radius: 8px;
                                    z-index: 20;
                                    margin-top: 0;
                                    margin-left: 2px;
                                }

                                .menu-dropdown2.open .menu-dropdown2-content,
                                .menu-dropdown2:hover .menu-dropdown2-content {
                                    display: block;
                                }

                                .menu-dropdown2-content a {
                                    display: block;
                                    padding: 10px 22px;
                                    color: #093d62 !important;
                                    background: #fff;
                                    border-radius: 0;
                                    font-size: 16px;
                                    text-align: left;
                                    transition: background 0.2s, color 0.2s;
                                    white-space: nowrap;
                                }

                                .menu-dropdown2-content a:hover {
                                    background: #093d62 !important;
                                    color: #fff !important;
                                }

                                @media (max-width: 900px) {
                                    .menu-dropdown2 {
                                        width: 100%;
                                    }

                                    .menu-dropdown2-content {
                                        position: static;
                                        min-width: unset;
                                        box-shadow: none;
                                        border-radius: 0;
                                        background: #f8fafc;
                                        margin: 0;
                                        padding: 0;
                                    }

                                    .menu-dropdown2-content a {
                                        padding-left: 36px !important;
                                        background: #f8fafc;
                                        width: 100vw;
                                        box-sizing: border-box;
                                        border-bottom: 1px solid #f0f0f0;
                                    }

                                    .menu-dropdown2>a {
                                        width: 100vw;
                                        box-sizing: border-box;
                                        border-bottom: 1px solid #f0f0f0;
                                    }
                                }
                            </style>
                        </div>

                    </div>

                    <!-- <a href="index.php?controller=room">Phòng</a>
                    <a href="index.php?controller=customer">Khách thuê</a>
                    <div class="menu-dropdown">
                        <a href="#" onclick="event.preventDefault();this.parentNode.classList.toggle('open');return false;">Dịch vụ</a>
                        <div class="menu-dropdown-content">
                            <a href="index.php?controller=electricity">Điện</a>
                            <a href="index.php?controller=water">Nước</a>
                        </div>
                    </div> -->
                    <a href="index.php?controller=invoice">Hóa đơn</a>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'general_admin'): ?>
                        <div class="menu-dropdown">
                            <a href="#" onclick="event.preventDefault();this.parentNode.classList.toggle('open');return false;">Quản trị</a>
                            <div class="menu-dropdown-content">
                                <a href="index.php?controller=account">Tài khoản</a>
                            </div>

                        </div>

                    <?php endif; ?>
                    <!-- <a href="index.php?controller=qr">Quản lý QR Code</a> -->
                    <!-- <a href="index.php?controller=report">Báo cáo</a> -->
                </div>
                <div class="menu-right-group">
    <button class="menu-toggle" onclick="document.querySelector('.menu-bar-links').classList.toggle('active')">
        ☰
    </button>
    <div class="menu-bar-user">
        <?php if (isset($_SESSION['user'])): ?>
            <div class="user-dropdown" style="position:relative;">
                <span class="user-greeting">
                    Xin chào <?= htmlspecialchars($_SESSION['user']['username']) ?> &#9662;
                </span>
                <div class="user-dropdown-menu" style="display:none;">
                    <a href="#" onclick="showChangePasswordModal();return false;">Đổi mật khẩu</a>
                    <a href="logout.php" style="color:red;">Đăng xuất</a>
                </div>
            </div>
                                <script>
                            const userGreeting = document.querySelector('.user-greeting');
                            const userDropdownMenu = document.querySelector('.user-dropdown-menu');
                            if (userGreeting && userDropdownMenu) {
                                userGreeting.addEventListener('mouseenter', function() {
                                    userDropdownMenu.style.display = 'block';
                                });
                                userGreeting.addEventListener('mouseleave', function() {
                                    setTimeout(() => {
                                        if (!userDropdownMenu.matches(':hover')) userDropdownMenu.style.display = 'none';
                                    }, 200);
                                });
                                userDropdownMenu.addEventListener('mouseleave', function() {
                                    userDropdownMenu.style.display = 'none';
                                });
                                userDropdownMenu.addEventListener('mouseenter', function() {
                                    userDropdownMenu.style.display = 'block';
                                });
                            }

                            function showChangePasswordModal() {
                                document.getElementById('change-password-modal').style.display = 'block';
                            }

                            function hideChangePasswordModal() {
                                document.getElementById('change-password-modal').style.display = 'none';
                            }
                        </script>

        <?php endif; ?>
    </div>
</div>

            </div>
        </nav>
    <?php endif; ?>
    <div class="main-content">
        <?php if (!empty($content)) echo $content; ?>
    </div>
    <?php if (!$noHeaderFooter): ?>
<footer class="footer">
  <div class="footer-content">
    <div class="footer-left">
      <img src="../itro-logo.png" alt="TTD Motel Logo" class="footer-logo">
      <span class="brand-name">Hệ thống quản lý nhà trọ iTrọ</span>
    </div>

    <div class="footer-right">
      <span>© 2025 Tang Tien Dung</span>
      <span class="dot">•</span>
      <span>Hỗ trợ: <a href="tel:0343133166">0343.133.166</a></span>
      <span class="dot">•</span>
      <span>Email: <a href="mailto:tiendung2004lv@gmail.com">tiendung2004lv@gmail.com</a></span>
    </div>
  </div>
</footer>        </div>
    <?php endif; ?>
</body>
<script>
    // Ẩn menu khi click ra ngoài hoặc chọn mục
    document.addEventListener("click", function(e) {
        var menuBar = document.querySelector(".menu-bar");
        var menuLinks = document.querySelector(".menu-bar-links");
        var toggleBtn = document.querySelector(".menu-toggle");
        if (!menuBar.contains(e.target)) {
            if (menuLinks) menuLinks.classList.remove("active");
            // Đóng dropdown nếu đang mở
            var openDropdown = document.querySelector(".menu-dropdown.open");
            if (openDropdown) openDropdown.classList.remove("open");
        }
    });
    // Ẩn menu khi chọn mục (trừ dropdown)
    document.querySelectorAll(".menu-bar-links > a").forEach(function(link) {
        link.addEventListener("click", function() {
            var menuLinks = document.querySelector(".menu-bar-links");
            if (menuLinks) menuLinks.classList.remove("active");
        });
    });
    // Sửa toggle dropdown không lỗi PHP/JS
    document.querySelectorAll(".menu-dropdown > a").forEach(function(drop) {
        drop.addEventListener("click", function(e) {
            e.preventDefault();
            var parent = this.parentNode;
            parent.classList.toggle("open");
        });
    });
    // Đóng dropdown khi chọn mục con
    document.querySelectorAll(".menu-dropdown-content a").forEach(function(link) {
        link.addEventListener("click", function() {
            var parent = this.closest(".menu-dropdown");
            if (parent) parent.classList.remove("open");
            var menuLinks = document.querySelector(".menu-bar-links");
            if (menuLinks) menuLinks.classList.remove("active");
        });
    });
</script>

</html>
<?php
if (isset($_SESSION['user'])) {
    require_once __DIR__ . '/../models/UserModel.php';
    $user = UserModel::getById($_SESSION['user']['id']);
    if ($user && $user['status'] === 'block') {
        session_unset();
        session_destroy();
        header('Location: login.php?error=locked');
        exit;
    }
}
?>