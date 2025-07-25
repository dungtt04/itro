<?php
$title = 'Quản lý phòng';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .add-form { margin-bottom: 18px; }
    .add-form input, .add-form textarea { padding: 7px; border-radius: 5px; border: 1px solid #bfc7d1; margin-right: 8px; }
    .add-form button { background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 7px 18px; font-weight: 500; }
    .error { color: #d93025; background: #fff0f0; border: 1.5px solid #f8d7da; border-radius: 6px; padding: 10px; margin-bottom: 10px; text-align: center; }
</style>';
ob_start();
?>
<div class="container">
    <h2>Quản lý phòng</h2>
    <form method="post" action="index.php?controller=room&action=add" class="add-form">
        <input type="text" name="room_code" placeholder="Mã phòng" required>
        <input type="text" name="description" placeholder="Mô tả (tuỳ chọn)">
        <button type="submit">Thêm phòng</button>
    </form>
    <?php if (!empty($error)): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <table>
        <tr><th>Mã phòng</th><th>Mô tả</th><th>Ngày tạo</th></tr>
        <?php foreach($rooms as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['room_code']) ?></td>
            <td><?= htmlspecialchars($r['description']) ?></td>
            <td><?= htmlspecialchars($r['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
