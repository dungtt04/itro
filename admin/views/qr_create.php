<?php
$title = 'Tạo hóa đơn';

$headContent = <<<HTML
<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #eef2f7;
        margin: 0;
        padding: 0;
    }

    .wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: center;
        padding: 40px 16px;
    }

    .container {
        flex: 1 1 480px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        padding: 32px 28px;
        max-width: 640px;
        transition: all .25s ease;
    }
    .container:hover { box-shadow: 0 4px 20px rgba(22,90,154,0.25); }

    .summary-card {
        flex: 0 0 280px;
        background: linear-gradient(180deg, #165a9a, #0d3a66);
        color: #fff;
        border-radius: 12px;
        padding: 28px 22px;
        box-shadow: 0 3px 16px rgba(9,61,98,0.3);
        position: sticky;
        top: 24px;
        height: fit-content;
    }

    h2 {
        text-align: center;
        color: #165a9a;
        margin-top: 0;
        margin-bottom: 8px;
    }

    a.back-link {
        display: inline-block;
        font-size: 14px;
        color: #165a9a;
        text-decoration: none;
        margin-bottom: 16px;
        transition: color .2s;
    }
    a.back-link:hover { color: #0d3a66; }

    label {
        display: block;
        margin-top: 14px;
        font-weight: 600;
        color: #0d3a66;
        font-size: 15px;
    }

    input, select {
        width: 100%;
        padding: 9px 10px;
        border: 1px solid #cfd7e2;
        border-radius: 6px;
        font-size: 15px;
        margin-top: 5px;
        box-sizing: border-box;
        transition: all .2s;
    }

    input:focus, select:focus {
        border-color: #165a9a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(22,90,154,0.15);
    }

    button {
        margin-top: 22px;
        width: 100%;
        background: #165a9a;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s;
    }

    button:hover { background: #0d3a66; }

    .error {
        color: #d93025;
        background: #fff0f0;
        border: 1.5px solid #f8d7da;
        border-radius: 6px;
        padding: 10px;
        margin-bottom: 14px;
        text-align: center;
    }

    .qr-preview {
        text-align: center;
        margin-top: 24px;
    }

    .qr-preview img {
        width: 200px;
        height: 200px;
        border: 2px solid #093d62;
        border-radius: 12px;
        background: #fff;
    }

    .summary-card h3 {
        text-align: center;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .summary-item {
        margin-bottom: 14px;
    }

    .summary-item label {
        color: #fff;
        font-weight: 500;
        font-size: 14px;
    }

    .summary-item input {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
    }

    #amount_display, #payable_display {
        display: block;
        font-weight: 700;
        color: #fff;
        text-align: right;
        margin-top: 4px;
    }

    #amount_display { font-size: 20px; }
    #payable_display { font-size: 22px; }

    @media (max-width: 768px) {
        .wrapper { flex-direction: column; }
        .summary-card { position: static; margin-top: 20px; }
    }
</style>

<script>
function formatVND(n){
    return (isNaN(n)||n===null)?'0':n.toString().replace(/\B(?=(\\d{3})+(?!\\d))/g, '.');
}
function getNamed(name){ let el=document.getElementsByName(name);return el&&el.length?el[0]:null;}
function calcTotal(){
    let tienPhong=parseInt(getNamed("tien_phong")?.value||0),
        soDien=parseInt(getNamed("so_dien")?.value||0),
        soNuoc=parseInt(getNamed("so_nuoc")?.value||0),
        soNguoi=parseInt(getNamed("so_nguoi")?.value||1),
        discount=parseInt(getNamed("discount")?.value||0);
    let tienDien=soDien*3000, tienNuoc=soNuoc*15000, phiDV=soNguoi<=1?30000:50000;
    let tong=tienPhong+tienDien+tienNuoc+phiDV, payable=Math.max(0,tong-discount);
    document.getElementById("amount_display").textContent=formatVND(tong);
    document.getElementById("payable_display").textContent=formatVND(payable);
}

/* Giữ nguyên phần load danh sách điện nước */
function reloadElectricWaterList(){
    var xhr=new XMLHttpRequest();
    xhr.open("GET","index.php?controller=qr&action=ajax_list",true);
    xhr.onload=function(){
        if(xhr.status===200){
            try{
                var data=JSON.parse(xhr.responseText);
                var elecSel=document.getElementById("so_dien_select");
                var nuocSel=document.getElementById("so_nuoc_select");
                if(elecSel){
                    elecSel.innerHTML='<option value="">-- Chọn số điện tiêu thụ --</option>';
                    if(data.electricity) data.electricity.forEach(function(e){
                        elecSel.innerHTML+='<option value="'+e.object_name+'|'+e.DTT+'">'+e.object_name+' ('+e.DTT+')</option>';
                    });
                }
                if(nuocSel){
                    nuocSel.innerHTML='<option value="">-- Chọn số nước tiêu thụ --</option>';
                    if(data.water) data.water.forEach(function(w){
                        nuocSel.innerHTML+='<option value="'+w.object_name+'|'+w.DTT+'">'+w.object_name+' ('+w.DTT+')</option>';
                    });
                }
            }catch(e){console.error("Invalid JSON from ajax_list",e);}
        }
    };
    xhr.send();
}

window.addEventListener("DOMContentLoaded",()=>{
    reloadElectricWaterList();
    ["tien_phong","so_dien","so_nuoc","so_nguoi","discount"].forEach(n=>{
        let el=getNamed(n); if(el) el.addEventListener("input",calcTotal);
    });

    document.getElementById("so_dien_select")?.addEventListener("change",function(){
        let parts=this.value.split("|");
        let val=parts[1]?parseInt(parts[1]):0;
        let soDienEl=getNamed("so_dien");
        if(soDienEl) soDienEl.value=val;
        calcTotal();
    });

    document.getElementById("so_nuoc_select")?.addEventListener("change",function(){
        let parts=this.value.split("|");
        let val=parts[1]?parseInt(parts[1]):0;
        let soNuocEl=getNamed("so_nuoc");
        if(soNuocEl) soNuocEl.value=val;
        calcTotal();
    });

    calcTotal();
});
</script>
HTML;

ob_start();
?>

<div class="wrapper">
    <div class="container">
        <h2>Tạo hóa đơn</h2>
        <a href="index.php?controller=history" class="back-link">← Quay lại danh sách hóa đơn</a>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

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

            <label>Số điện tiêu thụ</label>
            <select name="so_dien_select" id="so_dien_select" required>
                <option value="">-- Chọn số điện tiêu thụ --</option>
            </select>
            <input type="text" name="so_dien" value="0" readonly style="background:#f3f3f3;">

            <label>Số nước tiêu thụ</label>
            <select name="so_nuoc_select" id="so_nuoc_select" required>
                <option value="">-- Chọn số nước tiêu thụ --</option>
            </select>
            <input type="text" name="so_nuoc" value="0" readonly style="background:#f3f3f3;">

            <label>Số người</label>
            <input type="text" name="so_nguoi" value="1">

            <label>Tiền phòng</label>
            <input type="text" name="tien_phong" value="1200000" required>

            <label>Nội dung chuyển khoản</label>
            <input type="text" name="addinfo" readonly style="background:#f3f3f3;">

            <button type="submit">Tạo hóa đơn</button>
        </form>

        <?php if (!empty($qr_url)): ?>
        <div class="qr-preview">
            <p><strong>QR Code:</strong></p>
            <img src="<?= htmlspecialchars($qr_url) ?>" alt="QR Code">
        </div>
        <?php endif; ?>
    </div>

    <div class="summary-card" aria-live="polite">
        <h3>Tổng kết hóa đơn</h3>

        <div class="summary-item">
            <label>Tổng tiền:</label>
            <span id="amount_display">0</span>
        </div>

        <div class="summary-item">
            <label>Giảm giá:</label>
            <input type="number" name="discount" min="0" value="0">
        </div>

        <div class="summary-item">
            <label>Cần thanh toán:</label>
            <span id="payable_display">0</span>
        </div>

        <div style="margin-top:14px;font-size:13px;color:rgba(255,255,255,0.85);text-align:center;">
            Đã bao gồm điện, nước, phí dịch vụ.
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
