<?php
$title = 'Thêm chỉ số nước';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }

    .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    label { display: block; margin-top: 12px; font-weight: 500; color: #093d62; }
    input, select { width: 100%; padding: 8px; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; margin-top: 4px; }
    button { margin-top: 18px; width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    .msg { color: #1e7e34; text-align: center; margin-bottom: 10px; }
</style>';
ob_start();
?>
<div class="container">
    <h2>Thêm chỉ số nước</h2>
    <?php if (!empty($msg)): ?><div class="msg"><?= $msg ?></div><?php endif; ?>
    <form method="post">
        <label>Tháng</label>
        <select name="month" id="month" required onchange="updateObjectName();fetchCSC();autoSetMonthField();">
            <option value="">-- Chọn tháng --</option>
            <?php for($i=1;$i<=12;$i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <label>Năm</label>
        <input type="number" name="year" id="year" min="2020" max="2100" required oninput="updateObjectName();fetchCSC();autoSetMonthField();">
        <input type="hidden" name="month_db" id="month_db">
        <label>Phòng</label>
        <select name="room_id" id="room_id" required onchange="updateObjectName();fetchCSC();">
            <option value="">-- Chọn phòng --</option>
            <?php foreach($rooms as $r): ?>
                <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Tên đối tượng</label>
        <input type="text" name="object_name" id="object_name" readonly required>
        <label>Chỉ số cũ (CSC)</label>
        <input type="text" name="CSC" id="CSC" >
        <label>Chỉ số mới (CSM)</label>
        <input type="text" name="CSM" id="CSM" required oninput="calcDTT();">
        <label>Số nước tiêu thụ (DTT)</label>
        <input type="text" name="DTT" id="DTT" readonly>
        <label>Thành tiền</label>
        <input type="text" name="total" id="total" readonly>
        <button type="submit">Lưu</button>
    </form>
</div>
<script type="text/javascript">
function updateObjectName() {
    var room = document.getElementById("room_id");
    var month = document.getElementById("month");
    var year = document.getElementById("year");
    var obj = document.getElementById("object_name");
    var roomName = room.options[room.selectedIndex] ? room.options[room.selectedIndex].text : "";
    var thang = month.value + "/" + year.value;
    obj.value = "Phòng " + roomName + " tháng " + thang;
}
function fetchCSC() {
    var room_id = document.getElementById("room_id").value;
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    if(room_id && month && year) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "index.php?controller=water&action=ajax_csc&room_id="+room_id+"&month="+month+"&year="+year, true);
        xhr.onload = function() {
            if(xhr.status === 200) {
                document.getElementById("CSC").value = xhr.responseText || "";
            }
        };
        xhr.send();
    }
}
function calcDTT() {
    var csc = parseInt(document.getElementById("CSC").value) || 0;
    var csm = parseInt(document.getElementById("CSM").value) || 0;
    var dtt = csm - csc;
    document.getElementById("DTT").value = dtt > 0 ? dtt : 0;
    document.getElementById("total").value = (dtt > 0 ? dtt : 0) * 15000;
}
function autoSetMonthField() {
    var m = document.getElementById("month") ? document.getElementById("month").value : '';
    var y = document.getElementById("year") ? document.getElementById("year").value : '';
    if(m && y) {
        document.getElementById("month_db").value = (m.length==1?('0'+m):m) + '-' + y;
    } else {
        document.getElementById("month_db").value = '';
    }
}
if(document.getElementById("month")) document.getElementById("month").addEventListener("change", autoSetMonthField);
if(document.getElementById("year")) document.getElementById("year").addEventListener("input", autoSetMonthField);
autoSetMonthField();
</script>';

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
<?php
$title = 'Thêm chỉ số nước';
$headContent = '<style>
    .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    label { display: block; margin-top: 12px; font-weight: 500; color: #093d62; }
    input, select { width: 100%; padding: 8px; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; margin-top: 4px; }
    button { margin-top: 18px; width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    .msg { color: #1e7e34; text-align: center; margin-bottom: 10px; }
</style>';
ob_start();
?>
<div class="container">
    <h2>Thêm chỉ số nước</h2>
    <?php if (!empty($msg)): ?><div class="msg"><?= $msg ?></div><?php endif; ?>
    <form method="post">
        <label>Tháng</label>
        <select name="month" id="month" required onchange="updateObjectName();fetchCSC();autoSetMonthField();">
            <option value="">-- Chọn tháng --</option>
            <?php for($i=1;$i<=12;$i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <label>Năm</label>
        <input type="number" name="year" id="year" min="2020" max="2100" required oninput="updateObjectName();fetchCSC();autoSetMonthField();">
        <input type="hidden" name="month_db" id="month_db">
        <label>Phòng</label>
        <select name="room_id" id="room_id" required onchange="updateObjectName();fetchCSC();">
            <option value="">-- Chọn phòng --</option>
            <?php foreach($rooms as $r): ?>
                <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Tên đối tượng</label>
        <input type="text" name="object_name" id="object_name" readonly required>
        <label>Chỉ số cũ (CSC)</label>
        <input type="text" name="CSC" id="CSC" >
        <label>Chỉ số mới (CSM)</label>
        <input type="text" name="CSM" id="CSM" required oninput="calcDTT();">
        <label>Số nước tiêu thụ (DTT)</label>
        <input type="text" name="DTT" id="DTT" readonly>
        <label>Thành tiền</label>
        <input type="text" name="total" id="total" readonly>
        <button type="submit">Lưu</button>
    </form>
</div>
<script type="text/javascript">
function updateObjectName() {
    var room = document.getElementById("room_id");
    var month = document.getElementById("month");
    var year = document.getElementById("year");
    var obj = document.getElementById("object_name");
    var roomName = room.options[room.selectedIndex] ? room.options[room.selectedIndex].text : "";
    var thang = month.value + "/" + year.value;
    obj.value = "Phòng " + roomName + " tháng " + thang;
}
function fetchCSC() {
    var room_id = document.getElementById("room_id").value;
    var month = document.getElementById("month").value;
    var year = document.getElementById("year").value;
    if(room_id && month && year) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "index.php?controller=water&action=ajax_csc&room_id="+room_id+"&month="+month+"&year="+year, true);
        xhr.onload = function() {
            if(xhr.status === 200) {
                document.getElementById("CSC").value = xhr.responseText || "";
            }
        };
        xhr.send();
    }
}
function calcDTT() {
    var csc = parseInt(document.getElementById("CSC").value) || 0;
    var csm = parseInt(document.getElementById("CSM").value) || 0;
    var dtt = csm - csc;
    document.getElementById("DTT").value = dtt > 0 ? dtt : 0;
    document.getElementById("total").value = (dtt > 0 ? dtt : 0) * 15000;
}
function autoSetMonthField() {
    var m = document.getElementById("month") ? document.getElementById("month").value : '';
    var y = document.getElementById("year") ? document.getElementById("year").value : '';
    if(m && y) {
        document.getElementById("month_db").value = (m.length==1?('0'+m):m) + '-' + y;
    } else {
        document.getElementById("month_db").value = '';
    }
}
if(document.getElementById("month")) document.getElementById("month").addEventListener("change", autoSetMonthField);
if(document.getElementById("year")) document.getElementById("year").addEventListener("input", autoSetMonthField);
autoSetMonthField();
</script>';

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
