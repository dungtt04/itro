<?php
$title = 'Quản lý tài khoản';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .add-btn { display: inline-block; background: #093d62; color: #fff; padding: 8px 18px; border-radius: 6px; text-decoration: none; font-weight: 500; margin-bottom: 18px; }
    .action-btn { display: inline-block; background: #093d62; color: #fff; padding: 6px 14px; border-radius: 5px; text-decoration: none; font-size: 14px; margin-right: 6px; transition: background 0.2s, color 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px #093d6240; border: none; cursor: pointer; }
    .action-btn:hover, .action-btn:focus { background: #1e7e34; color: #fff; box-shadow: 0 4px 16px #093d6240; }
    @media (max-width: 700px) {
        table, thead, tbody, th, td, tr { display: block; }
        thead { display: none; }
        tr { margin-bottom: 18px; border: 1px solid #bfc7d1; border-radius: 8px; background: #fff; box-shadow: 0 2px 8px #093d6240; }
        td { border: none; border-bottom: 1px solid #eee; position: relative; padding-left: 48%; min-height: 38px; }
        td:before { position: absolute; left: 12px; top: 8px; width: 44%; white-space: nowrap; font-weight: bold; color: #093d62; }
        td[data-label]:before { content: attr(data-label); }
    }
</style>';
ob_start();
?>
<div class="container">
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div id="success-toast" style="position:fixed;top:32px;right:32px;z-index:9999;background:#1e7e34;color:#fff;padding:14px 28px;border-radius:8px;box-shadow:0 2px 12px #093d6240;font-size:16px;animation:fadeIn 0.5s;">
            <?= $_SESSION['success_message'];
            unset($_SESSION['success_message']); ?>
        </div>
        <script>
            setTimeout(function() {
                var toast = document.getElementById('success-toast');
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
        </style>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div id="error-toast" style="position:fixed;top:32px;right:32px;z-index:9999;background:red;color:#fff;padding:14px 28px;border-radius:8px;box-shadow:0 2px 12px #093d6240;font-size:16px;animation:fadeIn 0.5s;">
            <?= $_SESSION['error_message'];
            unset($_SESSION['error_message']); ?>
        </div>
        <script>
            setTimeout(function() {
                var toast = document.getElementById('error-toast');
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
        </style>
    <?php endif; ?>
<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'general_admin'): ?>
    <h2>Quản lý tài khoản</h2>
    <a href="index.php?controller=account&action=add" class="add-btn">+ Thêm tài khoản mới</a>
    <table>
        <thead>
            <tr>
                <th>Tên đăng nhập</th>
                <th>Quyền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td data-label="Tên đăng nhập"><?= htmlspecialchars($u['username']) ?></td>
                    <td data-label="Quyền">
                        <?php if ($u['role'] === 'general_admin'): ?>
                            Quản trị viên
                        <?php elseif ($u['role'] === 'admin'): ?>
                            Quản lý nhà trọ
                        <?php else: ?>
                            Nhân viên
                        <?php endif; ?>
                        <!-- <?= htmlspecialchars($u['role']) ?> -->
                    </td>
                    <td data-label="Trạng thái">
                        <?php if ($u['status'] === 'active'): ?>
                            <span style="color:green;font-weight:500;">Đang hoạt động</span>
                        <?php elseif ($u['status'] === 'pending'): ?>
                            <span style="color:orange;font-weight:500;">Chờ duyệt</span>
                        <?php else: ?>
                            <span style="color:red;font-weight:500;">Đã khóa</span>
                        <?php endif; ?>
                    </td>
                    <td data-label="Thao tác">
                        <!-- <a href="index.php?controller=account&action=edit&id=<?= $u['id'] ?>" class="action-btn" style="background:#ffc107;color:#093d62;">Sửa</a>
                        <a href="index.php?controller=account&action=delete&id=<?= $u['id'] ?>" class="action-btn" style="background:#dc3545;color:#fff;" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?');">Xóa</a> -->
                        <?php if ($u['status'] === 'pending'): ?>
                            <a href="index.php?controller=account&action=approve&id=<?= $u['id'] ?>" class="action-btn" style="background:#1e7e34;">Duyệt</a>
                        <?php endif; ?>
                        <?php if ($u['status'] !== 'pending'): ?>

                            <?php if ($u['role'] !== 'general_admin'): ?>
                                <a href="index.php?controller=account&action=make_admin&id=<?= $u['id'] ?>" class="action-btn" style="background:#007bff;">Thêm làm QTV</a>
                            <?php endif; ?>
                            <?php if ($u['role'] === 'general_admin'): ?>
                                <a href="index.php?controller=account&action=demote_admin&id=<?= $u['id'] ?>" class="action-btn" style="background:#ffc107;color:#093d62;">Hạ xuống quản lý</a>
                            <?php endif; ?>
                            <?php if ($u['status'] !== 'block'): ?>
                                <a href="index.php?controller=account&action=block&id=<?= $u['id'] ?>" class="action-btn" style="background:#d93025;">Khóa</a>
                            <?php endif; ?>
                            <?php if ($u['status'] === 'block'): ?>
                                <a href="index.php?controller=account&action=unblock&id=<?= $u['id'] ?>" class="action-btn" style="background:green">Mở khóa</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table><?php else: ?>
    <div style="text-align:center; padding:40px; font-size:18px; color:#555;">
        Bạn không có quyền truy cập trang này.
    </div>
<?php endif; ?>
    
</div>

</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>