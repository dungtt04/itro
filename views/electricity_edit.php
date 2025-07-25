<?php
$title = 'Sửa chỉ số điện';
$headContent = '<style>
    .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    label { display: block; margin-top: 12px; font-weight: 500; color: #093d62; }
    input, select { width: 100%; padding: 8px; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; margin-top: 4px; }
    button { margin-top: 18px; width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    .msg { color: #1e7e34; text-align: center; margin-bottom: 10px; }
</style>
<script type="text/javascript">
function updateObjectName() {
    var room = document.getElementById("room_id");
    var month = document.getElementById("month");
    var obj = document.getElementById("object_name");
    var roomName = room.options[room.selectedIndex] ? room.options[room.selectedIndex].text : "";
    var thang = "";
    if(month.value.match(/^\d{4}-\d{2}$/)) {
        var arr = month.value.split("-");
        thang = arr[1] + "/" + arr[0];
    } else {
        thang = month.value;
    }
    obj.value = "Phòng " + roomName + " tháng " + thang;
}
function calcDTT() {
    var csc = parseInt(document.getElementById("CSC").value) || 0;
    var csm = parseInt(document.getElementById("CSM").value) || 0;
    var dtt = csm - csc;
    document.getElementById("DTT").value = dtt > 0 ? dtt : 0;
    document.getElementById("total").value = (dtt > 0 ? dtt : 0) * 3000;
}
</script>';
ob_start();
?>
<div class="container">
    <h2>Sửa chỉ số điện</h2>
    <?php if (!empty($msg)): ?><div class="msg"><?= $msg ?></div><?php endif; ?>
    <form method="post">
        <label>Tháng (YYYY-MM)</label>
        <input type="text" name="month" id="month" value="<?= htmlspecialchars($e['month']) ?>" required oninput="updateObjectName();">
        <label>Phòng</label>
        <select name="room_id" id="room_id" required onchange="updateObjectName();">
            <option value="">-- Chọn phòng --</option>
            <?php foreach($rooms as $r): ?>
                <option value="<?= $r['id'] ?>" <?= $e['room_id']==$r['id']?'selected':'' ?>><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Tên đối tượng</label>
        <input type="text" name="object_name" id="object_name" value="<?= htmlspecialchars($e['object_name']) ?>" readonly required>
        <label>Chỉ số cũ (CSC)</label>
        <input type="text" name="CSC" id="CSC" value="<?= $e['CSC'] ?>" readonly>
        <label>Chỉ số mới (CSM)</label>
        <input type="text" name="CSM" id="CSM" value="<?= $e['CSM'] ?>" required oninput="calcDTT();">
        <label>Số điện tiêu thụ (DTT)</label>
        <input type="text" name="DTT" id="DTT" value="<?= $e['DTT'] ?>" readonly>
        <label>Thành tiền</label>
        <input type="text" name="total" id="total" value="<?= $e['total'] ?>" readonly>
        <button type="submit">Lưu</button>
    </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
