<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Trang quản lý' ?></title>
    <link rel="shortcut icon" href="itro-watermark.png" type="image/x-icon">
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
        .menu-dropdown> a {
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
        .menu-dropdown.open> a {
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
        }

        .menu-bar-user a {
            background: #f3f6fa;
            color: #d9534f !important;
            border-radius: 50%;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .menu-bar-user a:hover {
            background: #ffeaea;
        }

        @media (max-width: 900px) {
            .menu-bar-inner {
                min-height: 60px;
            }

            .menu-logo {
                width: 44px;
                margin-bottom: 7px;
                margin-top: 7px;
            }

            .menu-toggle {
                display: inline-block;
                position: absolute;
                right: 50px;
                top: 10px;
                z-index: 1100;
            }

            .menu-bar-user {
                position: absolute;
                right: 10px;
                top: 10px;
                margin-left: 0;
                margin-top: 0;
                z-index: 1101;
            }

            .menu-bar-links {
                display: none;
                flex-direction: column;
                background: #fff;
                position: absolute;
                top: 56px;
                left: 0;
                width: 100vw;
                box-shadow: 0 2px 8px #0002;
                border-radius: 0 0 10px 10px;
                z-index: 1001;
                padding: 10px 0 10px 0;
                animation: slideDown 0.25s;
            }

            .menu-bar-links.active {
                display: flex !important;
            }

            .menu-bar-links a,
            .menu-dropdown-content a {
                text-align: left !important;
                justify-content: flex-start !important;
                align-items: flex-start !important;
                display: block !important;
                padding-left: 22px !important;
                font-size: 17px;
                border-radius: 0;
                margin: 0;
                width: 100vw;
                box-sizing: border-box;
            }

            .menu-bar-links a,
            .menu-dropdown-content a {
                width: 100vw;
                box-sizing: border-box;
                border-bottom: 1px solid #f0f0f0;
            }

            .menu-dropdown {
                width: 100%;
            }

            .menu-dropdown-content {
                position: static;
                min-width: unset;
                box-shadow: none;
                border-radius: 0;
                background: #f8fafc;
                margin: 0;
                padding: 0;
            }

            .menu-dropdown-content a {
                padding-left: 36px !important;
                background: #f8fafc;
            }

            .menu-bar-user {
                margin-left: 0;
                margin-top: 8px;
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

        .footer footer {
            background: #fff;
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
                <a href="index.php?controller=room">Phòng</a>
                <a href="index.php?controller=customer">Khách thuê</a>
                <div class="menu-dropdown">
                    <a href="#" onclick="event.preventDefault();this.parentNode.classList.toggle('open');return false;">Dịch vụ</a>
                    <div class="menu-dropdown-content">
                        <a href="index.php?controller=electricity">Điện</a>
                        <a href="index.php?controller=water">Nước</a>
                    </div>
                </div>
                <a href="index.php?controller=invoice">Hóa đơn</a>
                <!-- <a href="index.php?controller=qr">Quản lý QR Code</a> -->
                <a href="index.php?controller=report">Báo cáo</a>
            </div>
            <div class="menu-bar-user">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php" title="Đăng xuất">
                    <span style="display:inline-block;vertical-align:middle;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M6 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H6zm0 1h4a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/>
                          <path d="M11.146 8.354a.5.5 0 0 0 0-.708l-2-2a.5.5 0 1 0-.708.708L9.293 7.5H4.5a.5.5 0 0 0 0 1h4.793l-1.147 1.146a.5.5 0 1 0 .708.708l2-2z"/>
                        </svg>
                    </span>
                </a>
            <?php endif; ?>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    <div class="main-content">
        <?php if (!empty($content)) echo $content; ?>
    </div>
    <?php if (!$noHeaderFooter): ?>
        <div class="footer">
            <footer style="text-align:center; color:#888; font-size:15px; margin-top:32px; padding:18px 0 0 0; background:#fff;">
                &copy; 2025 Copyright by <a style="
    color: #093d62; text-decoration: none; font-weight: 500;" " href="http://dungtt.id.vn">Tang Tien Dung</a>
            </footer>
        </div>
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