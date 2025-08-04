<?php
$title = 'Thêm chỉ số điện & nước';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    .split { display: flex; gap: 32px; }
    .form-box { flex: 1; background: #f8fafc; border-radius: 10px; padding: 24px 18px; box-shadow: 0 1px 6px #093d6220; }
    label { display: block; margin-top: 12px; font-weight: 500; color: #093d62; }
    input, select { width: 100%; padding: 8px; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; margin-top: 4px; }
    button { margin-top: 18px; width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    .msg { color: #1e7e34; margin-top: 10px; text-align: center; }
    .error { color: #d93025; margin-top: 10px; text-align: center; }
</style>';
require_once __DIR__ . '/../models/RoomModel.php';
$roomList = RoomModel::getAll();
$msg_e = $msg_w = $error_e = $error_w = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_both'])) {
    // Xử lý điện
    require_once __DIR__ . '/../models/ElectricityModel.php';
    $room_id_e = (int)($_POST['room_id_e'] ?? 0);
    $month_e = trim($_POST['month_e'] ?? '');
    $object_name_e = trim($_POST['object_name_e'] ?? '');
    $CSC_e = trim($_POST['CSC_e'] ?? '');
    $CSM_e = trim($_POST['CSM_e'] ?? '');
    if ($room_id_e && $month_e && $object_name_e && $CSM_e !== '') {
        $DTT_e = (int)$CSM_e - (int)$CSC_e;
        $total_e = $DTT_e * 3000;
        if (ElectricityModel::add([
            'month' => $month_e,
            'room_id' => $room_id_e,
            'object_name' => $object_name_e,
            'CSC' => $CSC_e,
            'CSM' => $CSM_e,
            'DTT' => $DTT_e,
            'total' => $total_e
        ])) {
            $msg_e = 'Đã thêm chỉ số điện!';
        } else {
            $error_e = 'Không thể thêm chỉ số điện!';
        }
    } else {
        $error_e = 'Vui lòng nhập đủ thông tin điện!';
    }
    // Xử lý nước
    require_once __DIR__ . '/../models/WaterModel.php';
    $room_id_w = (int)($_POST['room_id_w'] ?? 0);
    $month_w = trim($_POST['month_w'] ?? '');
    $object_name_w = trim($_POST['object_name_w'] ?? '');
    $CSC_w = trim($_POST['CSC_w'] ?? '');
    $CSM_w = trim($_POST['CSM_w'] ?? '');
    if ($room_id_w && $month_w && $object_name_w && $CSM_w !== '') {
        $DTT_w = (int)$CSM_w - (int)$CSC_w;
        $total_w = $DTT_w * 15000;
        if (WaterModel::add([
            'month' => $month_w,
            'room_id' => $room_id_w,
            'object_name' => $object_name_w,
            'CSC' => $CSC_w,
            'CSM' => $CSM_w,
            'DTT' => $DTT_w,
            'total' => $total_w
        ])) {
            $msg_w = 'Đã thêm chỉ số nước!';
        } else {
            $error_w = 'Không thể thêm chỉ số nước!';
        }
    } else {
        $error_w = 'Vui lòng nhập đủ thông tin nước!';
    }
}
ob_start();
?>
<div class="container">
    <h2>Thêm chỉ số điện & nước</h2>
    <form method="post" class="form-box" style="max-width:800px; margin:0 auto;">
        <div class="split">
            <div style="flex:1;">
                <h3>Thêm chỉ số điện</h3>
                <label>Phòng</label>
                <select name="room_id_e" required>
                    <option value="">-- Chọn phòng --</option>
                    <?php foreach($roomList as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['room_code']) ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Tháng (YYYY-MM)</label>
                <input type="text" name="month_e" required placeholder="2025-08">
                <label>Tên thiết bị/đồng hồ</label>
                <input type="text" name="object_name_e" id="object_name_e" required readonly style="background:#f3f3f3;">
                <label>Chỉ số cũ (CSC)</label>
                <input type="number" name="CSC_e" required>
                <label>Chỉ số mới (CSM)</label>
                <input type="number" name="CSM_e" required>
            </div>
            <div style="flex:1;">
                <h3>Thêm chỉ số nước</h3>
                <label>Phòng</label>
                <select name="room_id_w" required>
                    <option value="">-- Chọn phòng --</option>
                    <?php foreach($roomList as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['room_code']) ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Tháng (YYYY-MM)</label>
                <input type="text" name="month_w" required placeholder="2025-08">
                <label>Tên thiết bị/đồng hồ</label>
                <input type="text" name="object_name_w" id="object_name_w" required readonly style="background:#f3f3f3;">
                <label>Chỉ số cũ (CSC)</label>
                <input type="number" name="CSC_w" required>
                <label>Chỉ số mới (CSM)</label>
                <input type="number" name="CSM_w" required>
            </div>
        </div>
        <button type="submit" name="submit_both">Thêm điện & nước</button>
        <?php if ($msg_e): ?><div class="msg">Điện: <?= $msg_e ?></div><?php endif; ?>
        <?php if ($error_e): ?><div class="error">Điện: <?= $error_e ?></div><?php endif; ?>
        <?php if ($msg_w): ?><div class="msg">Nước: <?= $msg_w ?></div><?php endif; ?>
        <?php if ($error_w): ?><div class="error">Nước: <?= $error_w ?></div><?php endif; ?>
    </form>
</div>
<script>
function updateObjectNameE() {
    var roomSel = document.getElementsByName("room_id_e")[0];
    var monthInput = document.getElementsByName("month_e")[0];
    var objInput = document.getElementById("object_name_e");
    var roomCode = roomSel.options[roomSel.selectedIndex].text;
    var month = monthInput.value;
    if(roomSel.value && month) objInput.value = "Phòng " + roomCode + " tháng " + month;
    else objInput.value = "";
}
function updateObjectNameW() {
    var roomSel = document.getElementsByName("room_id_w")[0];
    var monthInput = document.getElementsByName("month_w")[0];
    var objInput = document.getElementById("object_name_w");
    var roomCode = roomSel.options[roomSel.selectedIndex].text;
    var month = monthInput.value;
    if(roomSel.value && month) objInput.value = "Phòng " + roomCode + " tháng " + month;
    else objInput.value = "";
}
window.addEventListener("DOMContentLoaded", function() {
    document.getElementsByName("room_id_e")[0].addEventListener("change", updateObjectNameE);
    document.getElementsByName("month_e")[0].addEventListener("input", updateObjectNameE);
    document.getElementsByName("room_id_w")[0].addEventListener("change", updateObjectNameW);
    document.getElementsByName("month_w")[0].addEventListener("input", updateObjectNameW);
});
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
