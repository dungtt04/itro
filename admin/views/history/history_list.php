
<?php
$title = 'Hóa đơn';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    .create-btn { display:block; margin:0 auto 18px auto; background:#165a9a; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-size:16px; font-weight:500; cursor:pointer; text-decoration:none; width:max-content; }
    .create-btn:hover { background:#1e7e34; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: center; font-size: 15px; }
    td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .action-btn { background: #165a9a; color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-weight: 500; cursor: pointer; text-decoration: none; margin-right: 6px; transition: background 0.2s, color 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px #093d6240; }
    .action-btn.delete { background: #d93025; }
    .action-btn.print { background: #1e7e34; }
    .action-btn:hover, .action-btn:focus { background: #1e7e34; color: #fff; box-shadow: 0 4px 16px #093d6240; }
    .detail-row { display: none; background: #f8fafc; }
    .show-detail .detail-row { display: table-row; }
    .table-wrapper { overflow-x: auto; }
    @media (max-width: 768px) {
        .container { margin: 20px; padding: 16px; }
        h2 { font-size: 24px; }
        // .create-btn { width: 100%; text-align: center; }
        table { font-size: 14px; }
        th, td { padding: 6px 4px; }
        th:nth-child(3), th:nth-child(6), th:nth-child(7) { display: none; }
        td:nth-child(3), td:nth-child(6), td:nth-child(7) { display: none; }
        .action-btn { padding: 4px 8px; font-size: 12px; }
        // form { text-align: left; }
        // select { width: 100%; margin-bottom: 10px; }
    }
</style>';
require_once __DIR__ . '/../../models/ElectricityModel.php';
require_once __DIR__ . '/../../models/WaterModel.php';
require_once __DIR__ . '/../../models/CustomerModel.php';
require_once __DIR__ . '/../../models/RoomModel.php';
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

    <form method="post" action="index.php?controller=invoice&action=mark_paid_bulk" id="bulkForm">
        <div class="table-wrapper">
        <table>
            <thead style="text-align: center;">
                <tr >
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>Tháng/Năm</th>
                    <th>Mã hóa đơn</th>
                    <th>Phòng</th>
                    <th>Cần thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo/thanh toán</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $h): ?>
                    <tr class="main-row">
                        <td>
                            <?php if ($h['status'] !== 'Đã thanh toán'): ?>
                                <input type="checkbox" name="selected_ids[]" value="<?= $h['id'] ?>">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($h['mmyy']) ?></td>
                        <td><?= htmlspecialchars($h['addinfo']) ?></td>
                        <td><?= htmlspecialchars($h['room']) ?></td>
                        <td><?= number_format($h['total_discount']) ?></td>

                        <td>
                            <?php if ($h['status'] === 'Đã thanh toán'): ?>
                                <span style="color: green; ">
                                    <?= htmlspecialchars($h['status']) ?>
                                </span>
                            <?php else: ?>
                                <span style="color: red; ">
                            <?= htmlspecialchars($h['status']) ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($h['status'] === 'Đã thanh toán'): ?>
                               <p style="color: green">
                                   <?= htmlspecialchars(date('d-m-Y H:i:s', strtotime($h['updated_at'] ?? ''))) ?>
                               </p>
                            <?php else: ?>
                                <p style="color: red">
                                    <?= htmlspecialchars(date('d-m-Y H:i:s', strtotime($h['created_at'] ?? ''))) ?>
                                </p>
                            <?php endif; ?>
                        </td>
                        <td><button class="action-btn" type="button" onclick="toggleDetail(this)">Chi tiết</button></td>
                    </tr>
                    <tr class="detail-row" style="display:none;">
                        <td colspan="8">
                            <div style="padding:10px 0 0 0;">
                                <b>Tiền phòng:</b> <?= number_format($h['tien_phong']) ?>đ<br>
                                
                                <b>Điện:</b><br>
                                <?php if (!empty($h['e_used'])): ?>
                                    <table style="margin-bottom: 10px;">
                                        <tr>
                                            <th>CSC (Cũ)</th>
                                            <th>CSM (Mới)</th>
                                            <th>Lượng tiêu thụ</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                        <tr>
                                            <td><?= htmlspecialchars($h['e_old']) ?></td>
                                            <td><?= htmlspecialchars($h['e_new']) ?></td>
                                            <td><?= htmlspecialchars($h['e_used']) ?></td>
                                            <td><?= number_format($h['e_unit_price'] ?? 3000) ?>₫</td>
                                            <td><?= number_format($h['e_total'] ?? 0) ?>₫</td>
                                        </tr>
                                    </table>
                                    <?php else: ?>Không có dữ liệu điện<br><?php endif; ?>

                                <b>Nước:</b><br>
                                <?php if (!empty($h['w_used'])): ?>
                                    <table style="margin-bottom: 10px;">
                                        <tr>
                                            <th>CSC (Cũ)</th>
                                            <th>CSM (Mới)</th>
                                            <th>Lượng tiêu thụ</th>
                                            <th>Đơn giá</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                        <tr>
                                            <td><?= htmlspecialchars($h['w_old']) ?></td>
                                            <td><?= htmlspecialchars($h['w_new']) ?></td>
                                            <td><?= htmlspecialchars($h['w_used']) ?></td>
                                            <td><?= number_format($h['w_unit_price'] ?? 15000) ?>₫</td>
                                            <td><?= number_format($h['w_total'] ?? 0) ?>₫</td>
                                        </tr>
                                    </table>
                                    <?php else: ?>Không có dữ liệu nước<br><?php endif; ?>

                                <b>Phí dịch vụ:</b> <?= number_format($h['service_fee'] ?? 0) ?>₫<br>
                                <b>Tổng hóa đơn:</b> <?= number_format($h['tong_tien']) ?>₫<br>
                                <b>Giảm giá:</b> <?= number_format($h['discount'] ?? 0) ?>₫<br>
                                <b>Cần thanh toán:</b> <?= number_format($h['total_discount'] ?? $h['tong_tien']) ?>₫<br>
                                <?php if ($h['status'] === 'Đã thanh toán'): ?>
                                    <span style="color:green; font-weight:bold;">Hóa đơn đã được thanh toán.
                                    <b>Thời gian thanh toán:</b> <?= htmlspecialchars(date('d-m-Y H:i:s', strtotime($h['updated_at'] ?? ''))) ?></span><br>
                                <?php else: ?>
                                    <span style="color:red; font-weight:bold;">Hóa đơn chưa được thanh toán.</span><br>
                                <?php endif; ?>
                                <div style="margin-top:10px; text-align:right;">
                                    <?php if ($h['status'] !== 'Đã thanh toán'): ?>
                                        <a href="index.php?controller=invoice&action=mark_paid&id=<?= $h['id'] ?>" onclick="return confirm('Xác nhận thanh toán hóa đơn này?');" class="action-btn">Thanh toán</a>
                                    <?php endif; ?>
                                    <a href="index.php?controller=invoice&action=invoice&id=<?= $h['id'] ?>" class="action-btn print" >In hóa đơn</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>

        <div style="margin-top:15px; text-align:right;">
            <button type="submit" class="action-btn" onclick="return confirmBulk()">Thanh toán tất cả</button>
        </div>
    </form>
</div>
<script>
function toggleDetail(btn) {
    var mainRow = btn.closest('tr');
    var detailRow = mainRow.nextElementSibling;
    if (detailRow && detailRow.classList.contains('detail-row')) {
        if (detailRow.style.display === 'table-row' || detailRow.style.display === '') {
            detailRow.style.display = 'none';
            btn.textContent = 'Chi tiết';
        } else {
            detailRow.style.display = 'table-row';
            btn.textContent = 'Ẩn';
        }
    }
}

function confirmBulk() {
    var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]:checked');
    if (checkboxes.length === 0) {
        alert('Vui lòng chọn ít nhất một hóa đơn để thanh toán!');
        return false;
    }
    return confirm('Xác nhận thanh toán ' + checkboxes.length + ' hóa đơn?');
}

document.addEventListener('DOMContentLoaded', function() {
    var checkAll = document.getElementById('checkAll');
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
            checkboxes.forEach(function(cb) {
                cb.checked = checkAll.checked;
            });
        });
    }
});
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
