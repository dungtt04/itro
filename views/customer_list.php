<?php
$title = 'Quản lý khách thuê';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .add-btn { display: inline-block; background: #093d62; color: #fff; padding: 8px 18px; border-radius: 6px; text-decoration: none; font-weight: 500; margin-bottom: 18px; }
    .filter-form { margin-bottom: 18px; }
    .filter-form select { padding: 6px 12px; border-radius: 5px; border: 1px solid #bfc7d1; font-size: 15px; }
    .action-btn { display: inline-block; background: #093d62; color: #fff; padding: 6px 14px; border-radius: 5px; text-decoration: none; font-size: 14px; margin-right: 6px; transition: background 0.2s, color 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px #093d6240; border: none; cursor: pointer; }
    .action-btn:hover, .action-btn:focus { background: #1e7e34; color: #fff; box-shadow: 0 4px 16px #093d6240; }
    @media (max-width: 700px) {
        table, thead, tbody, th, td, tr { display: block; }
        thead { display: none; }
        tr { margin-bottom: 18px; border: 1px solid #bfc7d1; border-radius: 8px; background: #fff; box-shadow: 0 2px 8px #093d6240; }
        td { border: none; border-bottom: 1px solid #eee; position: relative; padding-left: 48%; min-height: 38px; }
        td:before { position: absolute; left: 12px; top: 8px; width: 44%; white-space: nowrap; font-weight: bold; color: #093d62; }
        td[data-label]:before { content: attr(data-label); }
        .detail-row { display: none; }
        .show-detail .detail-row { display: block; }
        /* Thêm CSS cho chi tiết khách thuê trên mobile */
        .detail-row td {
            background: #f8fafc;
            border-radius: 0 0 8px 8px;
            box-shadow: none;
            padding: 16px 12px 12px 12px;
        }
        .detail-row b {
            color: #093d62;
            font-size: 15px;
        }
        .detail-row .acton {
            margin-top: 14px !important;
            text-align: right;
            margin-right: 0 !important;
            margin-bottom: 0 !important;
        }
        .detail-row .action-btn {
            margin: 4px 2px;
            padding: 7px 10px;
            font-size: 14px;
        }
    }
</style>';
ob_start();
// Lấy danh sách phòng cho bộ lọc
require_once __DIR__ . '/../models/RoomModel.php';
$roomList = RoomModel::getAll();
$selectedRoom = $_GET['room'] ?? '';
?>
<div class="container">
    <h2>Quản lý khách thuê</h2>
    <form method="get" class="filter-form">
        <input type="hidden" name="controller" value="customer">
        <input type="hidden" name="action" value="list">
        <label for="room">Lọc theo phòng:</label>
        <select name="room" id="room" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <?php foreach ($roomList as $r): ?>
                <option value="<?= htmlspecialchars($r['room_code']) ?>" <?= $selectedRoom == $r['room_code'] ? 'selected' : '' ?>><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    <a href="index.php?controller=customer&action=add" class="add-btn">+ Khai báo khách mới</a>
    <a href="index.php?controller=customer&action=list_tra_phong" class="add-btn">Khách trả phòng</a>
    <table>
        <thead>
            <tr>
                <th>Phòng</th>
                <th>Họ tên</th>
                <th>Số CCCD</th>
                <th>Ngày sinh</th>
                <th class="desktop-only">Ngày cấp</th>
                <th class="desktop-only">Nơi cấp</th>
                <th class="desktop-only">Thường trú</th>
                <th class="desktop-only">SĐT</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $c): ?>
                <?php if (!$selectedRoom || $c['room'] == $selectedRoom): ?>
                    <?php if (isset($c['status']) && $c['status'] === 'Trả phòng') continue; ?>
                    <tr class="main-row">
                        <td data-label="Phòng"><?= htmlspecialchars($c['room']) ?></td>
                        <td data-label="Họ tên"><?= htmlspecialchars($c['name']) ?></td>
                        <td data-label="Số CCCD"><?= htmlspecialchars($c['cccd']) ?></td>
                        <td data-label="Ngày sinh">
                            <?php $dob = $c['dob'] ? date('d/m/Y', strtotime($c['dob'])) : '';
                            echo htmlspecialchars($dob); ?>
                        </td>
                        <td class="desktop-only" data-label="Ngày cấp">
                            <?php $cccd_date = $c['cccd_date'] ? date('d/m/Y', strtotime($c['cccd_date'])) : '';
                            echo htmlspecialchars($cccd_date); ?>
                        </td>
                        <td class="desktop-only" data-label="Nơi cấp"><?= htmlspecialchars($c['cccd_place']) ?></td>
                        <td class="desktop-only" data-label="Thường trú"><?= htmlspecialchars($c['address']) ?></td>
                        <td class="desktop-only" data-label="SĐT"><?= htmlspecialchars($c['phone']) ?></td>
                        <td data-label="Thao tác">
                            <button class="action-btn" onclick="toggleDetail(this)">Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr class="detail-row" style="display:none;">
                        <td colspan="9">
                            <div style="padding:10px 0 0 0;">
                                <b>Ngày cấp:</b> <?= htmlspecialchars($cccd_date) ?><br>
                                <b>Nơi cấp:</b> <?= htmlspecialchars($c['cccd_place']) ?><br>
                                <b>Thường trú:</b> <?= htmlspecialchars($c['address']) ?><br>
                                <b>SĐT:</b> <?= htmlspecialchars($c['phone']) ?><br>
                                <div class="acton" style="margin-top:10px; text-align:right; margin-right: 20px; margin-bottom: 10px;">
                                    <a href="index.php?controller=customer&action=tra_phong&id=<?= $c['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn trả phòng khách thuê này?');" class="action-btn" style="background:#d93025;color:white; text-decoration:none; margin:5px 5px; border-radius: 2px; padding:5px 5px;">Trả phòng</a>
                                    <?php if ($c['type_of_tenant'] === 'Chính'): ?>
                                        <!-- <a href="index.php?controller=customer&action=edit&id<?= $c['id'] ?>" class="action-btn" style="background:#1e7e34; color:white; text-decoration:none; margin:5px 5px; border-radius: 2px; padding:5px 5px;">Sửa</a> -->
                                        <a href="index.php?controller=customer&action=contract&id=<?= $c['id'] ?>" target="_blank" class="action-btn" style="background:#093d62; color:white; text-decoration:none; margin:5px 5px; border-radius: 2px; padding:5px 5px;">In hợp đồng</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    function toggleDetail(btn) {
        var mainRow = btn.closest('tr');
        var detailRow = mainRow.nextElementSibling;
        if (detailRow && detailRow.classList.contains('detail-row')) {
            if (detailRow.style.display === 'table-row' || detailRow.style.display === '') {
                detailRow.style.display = 'none';
                btn.textContent = 'Xem chi tiết';
            } else {
                detailRow.style.display = 'table-row';
                btn.textContent = 'Ẩn chi tiết';
            }
        }
    }
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>