<?php
$title = 'Tạo hóa đơn';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    label { display: block; margin-top: 12px; font-weight: 500; color: #093d62; }
    input, select { width: 100%; padding: 8px; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; margin-top: 4px; }
    button { margin-top: 18px; width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    .error { color: #d93025; background: #fff0f0; border: 1.5px solid #f8d7da; border-radius: 6px; padding: 10px; margin-bottom: 10px; text-align: center; }
    .qr-preview { text-align: center; margin-top: 18px; }
    .qr-preview img { width: 180px; height: 180px; border: 2px solid #093d62; border-radius: 10px; background: #fff; }
</style>
<script type="text/javascript">
function calcTotal() {
    var tienPhong = parseInt(document.getElementsByName("tien_phong")[0].value) || 0;
    var soDien = parseInt(document.getElementsByName("so_dien")[0].value) || 0;
    var soNuoc = parseInt(document.getElementsByName("so_nuoc")[0].value) || 0;
    var soNguoi = parseInt(document.getElementsByName("so_nguoi")[0].value) || 1;
    var tienDien = soDien * 3000;
    var tienNuoc = soNuoc * 15000;
    var phiDV = (soNguoi == 0) ? 0 : ((soNguoi == 1) ? 30000 : 50000);
    var tong = tienPhong + tienDien + tienNuoc + phiDV;
    var discount = parseInt(document.getElementsByName("discount")[0].value) || 0;
    var total_discount = tong - discount;
    document.getElementsByName("amount")[0].value = tong;
    document.getElementsByName("total_discount")[0].value = total_discount > 0 ? total_discount : 0;
}
function genAddInfo() {
    var room = document.getElementsByName("room")[0].value;
    var month = document.getElementsByName("month")[0].value;
    var year = document.getElementsByName("year")[0].value;
    var now = new Date();
    var day = ("" + now.getDate()).padStart(2, "0");
    var token = Math.floor(Math.random() * 100000).toString().padStart(5, "0");
    if(room && month && year) {
        document.getElementsByName("addinfo")[0].value = "P" + room + "T" + month + year + day + token;
    } else {
        document.getElementsByName("addinfo")[0].value = "";
    }
}
function reloadElectricWaterList() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "index.php?controller=qr&action=ajax_list", true);
    xhr.onload = function() {
        if(xhr.status === 200) {
            try {
                var data = JSON.parse(xhr.responseText);
                var elecSel = document.getElementById("so_dien_select");
                var nuocSel = document.getElementById("so_nuoc_select");
                if(elecSel) {
                    elecSel.innerHTML = \'<option value="">-- Chọn số điện tiêu thụ --</option>\';
                    data.electricity.forEach(function(e) {
                        elecSel.innerHTML += \'<option value="\'+e.object_name+\'|\'+e.DTT+\'">\'+e.object_name+\' (\'+e.DTT+\')</option>\';
                    });
                }
                if(nuocSel) {
                    nuocSel.innerHTML = \'<option value="">-- Chọn số nước tiêu thụ --</option>\';
                    data.water.forEach(function(w) {
                        nuocSel.innerHTML += \'<option value="\'+w.object_name+\'|\'+w.DTT+\'">\'+w.object_name+\' (\'+w.DTT+\')</option>\';
                    });
                }
            } catch(e) {}
        }
    };
    xhr.send();
}
window.addEventListener("DOMContentLoaded", function() {
    reloadElectricWaterList();
    var inputs = ["tien_phong","so_dien","so_nuoc","so_nguoi","discount"];
    inputs.forEach(function(name) {
        document.getElementsByName(name)[0].addEventListener("input", calcTotal);
    });
    ["room","month","year"].forEach(function(name) {
        document.getElementsByName(name)[0].addEventListener("input", genAddInfo);
    });
    calcTotal();
    genAddInfo();
});
</script>';
ob_start();
?>
<div class="container">
    <h2>Tạo hóa đơn</h2>
    <a href="index.php?controller=history" class="back-link">&larr; Quay lại danh sách hóa đơn</a>
    <?php if (!empty($error)): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <label>Phòng</label>
        <select name="room" required>
            <option value="">-- Chọn phòng --</option>
            <?php foreach($roomList as $r): ?>
                <option value="<?= htmlspecialchars($r['room_code']) ?>"><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Tháng</label>
        <input type="text" name="month" maxlength="2" placeholder="VD: 06" required>
        <label>Năm</label>
        <input type="text" name="year" maxlength="4" placeholder="VD: 2025" required>
        <label>Số tiền</label>
        <input type="text" name="amount" required readonly style="background:#f3f3f3;">
        <label>Giảm giá (discount)</label>
        <input type="number" name="discount" min="0" value="0" placeholder="Nhập số tiền giảm giá (nếu có)">
        <label>Cần thanh toán (total_discount)</label>
        <input type="text" name="total_discount" required readonly style="background:#f3f3f3;">
        <label>Nội dung chuyển khoản</label>
        <input type="text" name="addinfo" required readonly style="background:#f3f3f3;">
        <label>Số điện tiêu thụ</label>
        <select name="so_dien_select" id="so_dien_select" required onchange="document.getElementsByName('so_dien')[0].value=this.value.split('|')[1]||0;calcTotal();">
            <option value="">-- Chọn số điện tiêu thụ --</option>
        </select>
        <input type="text" name="so_dien" value="0" required readonly style="background:#f3f3f3;">
        <label>Số nước tiêu thụ</label>
        <select name="so_nuoc_select" id="so_nuoc_select" required onchange="document.getElementsByName('so_nuoc')[0].value=this.value.split('|')[1]||0;calcTotal();">
            <option value="">-- Chọn số nước tiêu thụ --</option>
        </select>
        <input type="text" name="so_nuoc" value="0" required readonly style="background:#f3f3f3;">
        <label>Số người</label>
        <input type="text" name="so_nguoi" value="1">
        <label>Tiền phòng</label>
        <input type="text" name="tien_phong" value="1200000" required>
        <button type="submit">Tạo mã QR</button>
    </form>
    <?php if (!empty($qr_url)): ?>
    <div class="qr-preview">
        <p><strong>QR Code:</strong></p>
        <img src="<?= htmlspecialchars($qr_url) ?>" alt="QR Code">
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
