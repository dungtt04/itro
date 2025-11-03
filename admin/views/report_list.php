<?php
$title = 'Quản lý báo cáo';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(9, 61, 98, 0.25); padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .btn { background-color: #093d62; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; }
    .btn:hover { background-color: #072a4a; }
    .btn-success { background-color: #28a745; }
    .btn-success:hover { background-color: #218838; }
    .text-success { color: #28a745; }
</style>';
// Include layout file
ob_start();
// views/report_list.php
?>
<div class="container mt-4">
    <h2>Quản lý báo cáo</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Phòng</th>
                <th>Loại</th>
                <th>Chi tiết</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
            <tr>
                <td><?= $report['id'] ?></td>
                <td><?= htmlspecialchars($report['room_code']) ?></td>
                <td><?= htmlspecialchars($report['type']) ?></td>
                <td><?= htmlspecialchars($report['detail']) ?></td>
                <td><?= htmlspecialchars($report['status']) ?></td>
                <td>
                    <?php if ($report['status'] === 'Đã tiếp nhận'): ?>
                        <a href="report_list.php?action=process&id=<?= $report['id'] ?>" class="btn btn-success btn-sm">Xử lý báo cáo</a>
                    <?php else: ?>
                        <span class="text-success">Đã xử lý</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
// layout.php
?>