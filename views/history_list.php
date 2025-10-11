<?php
$title = 'Hóa đơn';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    .create-btn { display:block; margin:0 auto 18px auto; background:#093d62; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-size:16px; font-weight:500; cursor:pointer; text-decoration:none; width:max-content; }
    .create-btn:hover { background:#1e7e34; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .action-btn { background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-weight: 500; cursor: pointer; text-decoration: none; margin-right: 6px; transition: background 0.2s, color 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px #093d6240; }
    .action-btn.delete { background: #d93025; }
    .action-btn.print { background: #1e7e34; }
    .action-btn:hover, .action-btn:focus { background: #1e7e34; color: #fff; box-shadow: 0 4px 16px #093d6240; }
    .detail-row { display: none; background: #f8fafc; }
    .show-detail .detail-row { display: table-row; }
</style>';
require_once __DIR__ . '/../models/ElectricityModel.php';
require_once __DIR__ . '/../models/WaterModel.php';
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/RoomModel.php';
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
    <h2>Hóa đơn</h2>
    <a href="index.php?controller=qr" class="create-btn">Tạo hóa đơn</a>
        <!-- <form method="get" class="filter-form">
        <input type="hidden" name="controller" value="electricity">
        <label for="room">Lọc theo phòng:</label>
        <select name="room" id="room" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <?php foreach($roomList as $r): ?>
                <option value="<?= htmlspecialchars($r['room_code']) ?>" <?= $selectedRoom == $r['room_code'] ? 'selected' : '' ?>><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
    </form> -->
    <form method="get" style="margin-bottom: 20px; text-align: center;">
    <input type="hidden" name="controller" value="invoice">
    <input type="hidden" name="action" value="list">

    <label for="room">Phòng:</label>
    <select name="room" id="room" style="padding:6px 10px;">
        <option value="">Tất cả</option>
        <?php foreach($roomList as $r): ?>
            <option value="<?= htmlspecialchars($r['room_code']) ?>" <?= ($room == $r['room_code']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($r['room_code']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- <label for="month">Tháng:</label>
    <select name="month" id="month" style="padding:6px 10px;">
        <option value="">Tất cả</option>
        <?php for($m=1;$m<=12;$m++): ?>
            <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>><?= $m ?></option>
        <?php endfor; ?>
    </select> -->

    <label for="status">Trạng thái:</label>
    <select name="status" id="status" style="padding:6px 10px;">
        <option value="">Tất cả</option>
        <option value="Đã thanh toán" <?= ($status == 'Đã thanh toán') ? 'selected' : '' ?>>Đã thanh toán</option>
        <option value="Chưa thanh toán" <?= ($status == 'Chưa thanh toán') ? 'selected' : '' ?>>Chưa thanh toán</option>
    </select>

    <button type="submit" class="action-btn" style="margin-left:10px;">Lọc</button>
</form>

    <table>
        <thead>
        <tr>
            <th>Tháng/Năm</th>
            <th>Phòng</th>
            <th>Số tiền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($history as $h): ?>
        <tr class="main-row">
            <td><?= htmlspecialchars($h['mmyy']) ?></td>
            <td><?= htmlspecialchars($h['room']) ?></td>
            <td><?= number_format($h['tong_tien']) ?></td>
            <td><?= htmlspecialchars($h['status']) ?></td>
            <td><button class="action-btn" onclick="toggleDetail(this)">Xem chi tiết</button></td>
        </tr>
        <tr class="detail-row" style="display:none;">
            <td colspan="5">
                <div style="padding:10px 0 0 0;">
                    <b>Điện:</b><br>
                    <?php if(isset($h['tien_dien']) && $h['tien_dien'] !== null): ?>
                        <table>
                            <tr>
                                <th>CSC</th>
                                <th>CSM</th>
                                <th>SĐTT</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                            <tr>
                                <td><?= isset($h['CSC']) && $h['CSC'] !== null ? htmlspecialchars($h['CSC']) : '' ?></td>
                                <td><?= isset($h['CSM']) && $h['CSM'] !== null ? htmlspecialchars($h['CSM']) : '' ?></td>
                                <td><?= isset($h['DTT']) && $h['DTT'] !== null ? htmlspecialchars($h['DTT']) : '' ?></td>
                                <td><?= isset($h['unit_price']) &&$h['unit_price']!== null ? htmlspecialchars($h['unit_price']) : ''?></td>
                                <td><?= number_format($h['tien_dien']) ?>đ</td>
                            </tr>
                        </table>
                    <?php else: ?>
                        Không có dữ liệu điện<br>
                    <?php endif; ?>
                    <b>Nước:</b><br>
                    <?php if(isset($h['tien_nuoc']) && $h['tien_nuoc'] !== null): ?>
                        <table>
                            <tr>
                                <th>CSC</th>
                                <th>CSM</th>
                                <th>SĐTT</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                            <tr>
                                <td><?= isset($h['CSC_NUOC']) ? htmlspecialchars($h['CSC_NUOC']) : '' ?></td>
                                <td><?= isset($h['CSM_NUOC']) ? htmlspecialchars($h['CSM_NUOC']) : '' ?></td>
                                <td><?= isset($h['DTT_NUOC']) ? htmlspecialchars($h['DTT_NUOC']) : '' ?></td>
                                <td>
                                    <?= isset($h['unit_price_nuoc']) && $h['unit_price_nuoc'] !== null ? htmlspecialchars($h['unit_price_nuoc']) : '' ?>
                                </td>
                                <td><?= number_format($h['tien_nuoc']) ?>đ</td>
                            </tr>
                        </table>
                    <?php else: ?>
                        Không có dữ liệu nước<br>
                    <?php endif; ?>
                    <b>Phí dịch vụ:</b> <?= number_format(($h['so_nguoi'] == 2) ? 50000 : ($h['so_nguoi'] * 30000)) ?>đ<br>
                    <b>Tiền phòng:</b> <?= number_format($h['tien_phong']) ?>đ<br>
                    <b>Tổng hóa đơn:</b> <?= number_format($h['tong_tien']) ?>đ<br>
                    <b>Giảm giá:</b> <?= isset($h['discount']) ? number_format($h['discount']) : '0' ?>đ<br>
                    <b>Cần thanh toán:</b> <?= isset($h['total_discount']) ? number_format($h['total_discount']) : number_format($h['tong_tien']) ?>đ<br>
                    <div style="margin-top:10px; text-align:right;">
                        <?php if($h['status'] !== 'Đã thanh toán'): ?>
                        
                        <a href="index.php?controller=invoice&action=mark_paid&id=<?= $h['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn thanh toán hóa đơn này?');"  class="action-btn">Thanh toán</a>
                        <?php endif; ?>
                        <a href="index.php?controller=invoice&action=invoice&id=<?= $h['id'] ?>" class="action-btn print" target="_blank">In hóa đơn</a>
                    </div>
                </div>
            </td>
        </tr>
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
