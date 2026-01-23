<?php
$title = 'Quản lý điện';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }

    .container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    .header-section { display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; margin-bottom: 24px; }
    .add-btn { background:#093d62; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-size:16px; font-weight:500; cursor:pointer; text-decoration:none; white-space: nowrap; }
    .add-btn:hover { background:#1e7e34; }
    .filter-form { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; flex: 1; }
    .filter-group { display: flex; flex-direction: column; gap: 4px; }
    .filter-group label { font-size: 14px; color: #333; font-weight: 500; }
    .filter-form select, .filter-form input { padding: 6px 12px; border-radius: 5px; border: 1px solid #bfc7d1; font-size: 15px; }
    .filter-btn { background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 8px 16px; font-weight: 500; cursor: pointer; }
    .filter-btn:hover { background: #1e7e34; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .action-btn { background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-weight: 500; cursor: pointer; text-decoration: none; margin-right: 6px; }
    .action-btn.delete { background: #d93025; }
</style>';
require_once __DIR__ . '/../../models/RoomModel.php';
$roomList = RoomModel::getAll();
$selectedRoom = $_GET['room'] ?? '';
$selectedMonth = $_GET['month'] ?? '';
$selectedYear = $_GET['year'] ?? '';
ob_start();
?>
<div class="container">
    <h2>Quản lý điện</h2>
    <div class="header-section">
        <form method="get" class="filter-form">
            <input type="hidden" name="controller" value="electricity">
            <div class="filter-group">
                <label for="room">Phòng:</label>
                <select name="room" id="room">
                    <option value="">Tất cả</option>
                    <?php foreach ($roomList as $r): ?>
                        <option value="<?= htmlspecialchars($r['room_code']) ?>" <?= $selectedRoom == $r['room_code'] ? 'selected' : '' ?>><?= htmlspecialchars($r['room_code']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="month">Tháng:</label>
                <select name="month" id="month">
                    <option value="">Tất cả</option>
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>" <?= $selectedMonth == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>>Tháng <?= $m ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="year">Năm:</label>
                <select name="year" id="year">
                    <option value="">Tất cả</option>
                    <?php for ($y = 2023; $y <= date('Y'); $y++): ?>
                        <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <button type="submit" class="filter-btn">Lọc</button>
        </form>
        <a href="index.php?controller=electricity&action=add" class="add-btn">Thêm chỉ số điện</a>
    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>Tháng</th>
            <th>Phòng</th>
            <th>CSC</th>
            <th>CSM</th>
            <th>TT</th>
            <!-- <th>Thành tiền</th> -->
            <th>Hành động</th>
        </tr>
        <?php foreach ($list as $e): ?>
            <?php 
                $monthMatch = !$selectedMonth || strpos($e['month'], $selectedMonth) !== false;
                $yearMatch = !$selectedYear || strpos($e['month'], $selectedYear) !== false;
                $roomMatch = !$selectedRoom || $e['room_code'] == $selectedRoom;
                if ($monthMatch && $yearMatch && $roomMatch): 
            ?>
                <tr>
                    <td><?= $e['id'] ?></td>
                    <td><?= htmlspecialchars($e['month']) ?></td>
                    <td><?= htmlspecialchars($e['room_code']) ?></td>
                    <td><?= $e['CSC'] ?></td>
                    <td><?= $e['CSM'] ?></td>
                    <td><?= $e['DTT'] ?></td>
                    <!-- <td><?= number_format($e['total']) ?></td> -->
                    <td>
                        <!-- <a href="index.php?controller=electricity&action=edit&id=<?= $e['id'] ?>" class="action-btn">Sửa</a> -->
                        <a href="index.php?controller=electricity&action=delete&id=<?= $e['id'] ?>" class="action-btn delete" onclick="return confirm('Xóa bản ghi này?');">Xóa</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>