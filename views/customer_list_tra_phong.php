<?php
$title = 'Danh sách khách trả phòng';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1000px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .action-btn { background: #d93025; color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-weight: 500; cursor: pointer; text-decoration: none; margin-right: 6px; }
</style>';
require_once __DIR__ . '/../models/CustomerModel.php';
$customers = array_filter(CustomerModel::getAll(), function($c) {
    return isset($c['status']) && $c['status'] === 'Trả phòng';
});
ob_start();
?>
<div class="container">
    <h2>Danh sách khách trả phòng</h2>
    <table>
        <thead>
            <tr>
                <th>Phòng</th>
                <th>Họ tên</th>
                <th>Số CCCD</th>
                <th>Ngày sinh</th>
                <th>Ngày cấp</th>
                <th>Nơi cấp</th>
                <th>Thường trú</th>
                <th>SĐT</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($customers as $c): ?>
            <?php if (isset($c['status']) && $c['status'] === 'Trả phòng'): ?>
            <tr>
                <td><?= htmlspecialchars($c['room_code']) ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['cccd']) ?></td>
                <td><?= htmlspecialchars($c['dob']) ?></td>
                <td><?= htmlspecialchars($c['issue_date']) ?></td>
                <td><?= htmlspecialchars($c['issue_place']) ?></td>
                <td><?= htmlspecialchars($c['address']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td>
                    <a href="index.php?controller=customer&action=delete&id=<?= $c['id'] ?>" class="action-btn">Xoá</a>
                </td>
            </tr>
            <?php else: ?>
            <tr>
                <td colspan="9" style="text-align: center;">Không có khách trả phòng</td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
