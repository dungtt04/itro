<?php
$title = 'Quản lý nước';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    .add-btn { display:block; margin:0 auto 18px auto; background:#093d62; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-size:16px; font-weight:500; cursor:pointer; text-decoration:none; width:max-content; }
    .add-btn:hover { background:#1e7e34; }
    .filter-form { margin-bottom: 18px; }
    .filter-form select { padding: 6px 12px; border-radius: 5px; border: 1px solid #bfc7d1; font-size: 15px; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .action-btn { background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-weight: 500; cursor: pointer; text-decoration: none; margin-right: 6px; }
    .action-btn.delete { background: #d93025; }
</style>';
require_once __DIR__ . '/../models/RoomModel.php';
$roomList = RoomModel::getAll();
$selectedRoom = $_GET['room'] ?? '';
ob_start();
?>
<div class="container">
    <h2>Quản lý nước</h2>
    <form method="get" class="filter-form">
        <input type="hidden" name="controller" value="water">
        <label for="room">Lọc theo phòng:</label>
        <select name="room" id="room" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <?php foreach($roomList as $r): ?>
                <option value="<?= htmlspecialchars($r['room_code']) ?>" <?= $selectedRoom == $r['room_code'] ? 'selected' : '' ?>><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    <a href="index.php?controller=water&action=add" class="add-btn">Thêm chỉ số nước</a>
    <table>
        <tr>
            <th>ID</th><th>Tháng</th><th>Phòng</th><th>CSC</th><th>CSM</th><th>DTT</th><th>Thành tiền</th><th>Hành động</th>
        </tr>
        <?php foreach($list as $w): ?>
        <?php if (!$selectedRoom || $w['room_code'] == $selectedRoom): ?>
        <tr>
            <td><?= $w['id'] ?></td>
            <td><?= htmlspecialchars($w['month']) ?></td>
            <td><?= htmlspecialchars($w['room_code']) ?></td>
            <td><?= $w['CSC'] ?></td>
            <td><?= $w['CSM'] ?></td>
            <td><?= $w['DTT'] ?></td>
            <td><?= number_format($w['total']) ?></td>
            <td>
                <a href="index.php?controller=water&action=edit&id=<?= $w['id'] ?>" class="action-btn">Sửa</a>
                <a href="index.php?controller=water&action=delete&id=<?= $w['id'] ?>" class="action-btn delete" onclick="return confirm('Xóa bản ghi này?');">Xóa</a>
            </td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
