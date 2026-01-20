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
<style>

</style>
<script>
function formatVND(n){
    return (isNaN(n)||n===null)?'0':n.toString().replace(/\B(?=(\\d{3})+(?!\\d))/g, '.');
}
function getNamed(name){ let el=document.getElementsByName(name);return el&&el.length?el[0]:null;}

function calcTotal(){
    let tienPhong = parseInt(getNamed("tien_phong")?.value||0);
    let serviceFee = parseInt(getNamed("service_fee")?.value||0);
    let eUsed = parseInt(getNamed("e_used")?.value||0);
    let eUnitPrice = parseInt(getNamed("e_unit_price")?.value||3000);
    let wUsed = parseInt(getNamed("w_used")?.value||0);
    let wUnitPrice = parseInt(getNamed("w_unit_price")?.value||15000);
    let discount = parseInt(getNamed("discount")?.value||0);
    
    let eTotal = eUsed * eUnitPrice;
    let wTotal = wUsed * wUnitPrice;
    let tong = tienPhong + serviceFee + eTotal + wTotal;
    let payable = Math.max(0, tong - discount);
    
    // Update all displays in summary card
    let roomDisplay = document.getElementById("room_fee_display");
    if(roomDisplay) roomDisplay.textContent = formatVND(tienPhong);
    
    let eTotalDisplay = document.getElementById("e_total_display");
    if(eTotalDisplay) eTotalDisplay.textContent = formatVND(eTotal);
    
    let wTotalDisplay = document.getElementById("w_total_display");
    if(wTotalDisplay) wTotalDisplay.textContent = formatVND(wTotal);
    
    let serviceFeeDisplay = document.getElementById("service_fee_display");
    if(serviceFeeDisplay) serviceFeeDisplay.textContent = formatVND(serviceFee);
    
    let amountDisplay = document.getElementById("amount_display");
    if(amountDisplay) amountDisplay.textContent = formatVND(tong);
    
    let discountDisplay = document.getElementById("discount_display");
    if(discountDisplay) discountDisplay.textContent = formatVND(discount);
    
    let payableDisplay = document.getElementById("payable_display");
    if(payableDisplay) payableDisplay.textContent = formatVND(payable);
    
    // Update hidden e_total and w_total fields
    let eTotalField = getNamed("e_total");
    if(eTotalField) eTotalField.value = eTotal;
    let wTotalField = getNamed("w_total");
    if(wTotalField) wTotalField.value = wTotal;
}

function reloadElectricWaterList(autoSelect = false){
    var month = getNamed("month")?.value || '';
    var year = getNamed("year")?.value || '';
    if(!month || !year) return;
    
    var xhr = new XMLHttpRequest();
    var url = "index.php?controller=qr&action=ajax_list&month=" + encodeURIComponent(month) + "&year=" + encodeURIComponent(year);
    xhr.open("GET", url, true);
    xhr.onload = function(){
        if(xhr.status === 200){
            try{
                var data = JSON.parse(xhr.responseText);
                var elecSel = document.getElementById("so_dien_select");
                var nuocSel = document.getElementById("so_nuoc_select");
                
                if(elecSel && data.electricity){
                    elecSel.innerHTML = '<option value="">-- Chọn chỉ số điện --</option>';
                    data.electricity.forEach(function(e){
                        elecSel.innerHTML += '<option value="' + e.object_name + '|' + e.CSC + '|' + e.CSM + '|' + e.DTT + '">' 
                            + e.object_name + ' (CSC: ' + e.CSC + ', CSM: ' + e.CSM + ', DTT: ' + e.DTT + ')</option>';
                    });
                    // Make select visible and enabled so user can choose after loading
                    elecSel.style.display = '';
                    elecSel.disabled = false;
                    // Auto-select first option if autoSelect is true (but keep select editable)
                    if(autoSelect && elecSel.options.length > 1){
                        elecSel.selectedIndex = 1;
                        elecSel.dispatchEvent(new Event('change'));
                    }
                }
                if(nuocSel && data.water){
                    nuocSel.innerHTML = '<option value="">-- Chọn chỉ số nước --</option>';
                    data.water.forEach(function(w){
                        nuocSel.innerHTML += '<option value="' + w.object_name + '|' + w.CSC + '|' + w.CSM + '|' + w.DTT + '">' 
                            + w.object_name + ' (CSC: ' + w.CSC + ', CSM: ' + w.CSM + ', DTT: ' + w.DTT + ')</option>';
                    });
                    // Make select visible and enabled so user can choose after loading
                    nuocSel.style.display = '';
                    nuocSel.disabled = false;
                    // Auto-select first option if autoSelect is true (but keep select editable)
                    if(autoSelect && nuocSel.options.length > 1){
                        nuocSel.selectedIndex = 1;
                        nuocSel.dispatchEvent(new Event('change'));
                    }
                }
            }catch(e){console.error("Invalid JSON from ajax_list", e);}
        }
    };
    xhr.send();
}

function findMeterData(){
    reloadElectricWaterList(true);
}

window.addEventListener("DOMContentLoaded", ()=>{
    // Don't auto-load on page load - wait for user to click "Tìm chỉ số" button
    
    // Setup event listeners for input change
    ["tien_phong", "service_fee", "e_used", "e_unit_price", "w_used", "w_unit_price", "discount"].forEach(n=>{
        let el = getNamed(n);
        if(el) el.addEventListener("input", calcTotal);
    });
    
    // Electricity selection
    document.getElementById("so_dien_select")?.addEventListener("change", function(){
        let parts = this.value.split("|");
        if(parts.length >= 4){
            let eOldField = getNamed("e_old");
            let eNewField = getNamed("e_new");
            let eUsedField = getNamed("e_used");
            if(eOldField) eOldField.value = parts[1];
            if(eNewField) eNewField.value = parts[2];
            if(eUsedField) eUsedField.value = parts[3];
        }
        calcTotal();
    });
    
    // Water selection
    document.getElementById("so_nuoc_select")?.addEventListener("change", function(){
        let parts = this.value.split("|");
        if(parts.length >= 4){
            let wOldField = getNamed("w_old");
            let wNewField = getNamed("w_new");
            let wUsedField = getNamed("w_used");
            if(wOldField) wOldField.value = parts[1];
            if(wNewField) wNewField.value = parts[2];
            if(wUsedField) wUsedField.value = parts[3];
        }
        calcTotal();
    });
    
    // Attach find meter data button
    document.getElementById("findMeterBtn")?.addEventListener("click", function(e){
        e.preventDefault();
        findMeterData();
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
                <?php foreach ($roomList as $r): ?>
                    <option value="<?= htmlspecialchars($r['room_code']) ?>"><?= htmlspecialchars($r['room_code']) ?></option>
                <?php endforeach; ?>
            </select>
            <div style="display: flex; justify-content: space-between; gap: 4%;">
                <div style=" width: 48%; float: left;">
                <label>Tháng</label>
                <select name="month" required>
                    <option value="">-- Chọn tháng --</option>
                    <option value="01">Tháng 1</option>
                    <option value="02">Tháng 2</option>
                    <option value="03">Tháng 3</option>
                    <option value="04">Tháng 4</option>
                    <option value="05">Tháng 5</option>
                    <option value="06">Tháng 6</option>
                    <option value="07">Tháng 7</option>
                    <option value="08">Tháng 8</option>
                    <option value="09">Tháng 9</option>
                    <option value="10">Tháng 10</option>
                    <option value="11">Tháng 11</option>
                    <option value="12">Tháng 12</option>
                </select>
                </div>
            <div style=" width: 48%; float: right;">
                <label>Năm</label>
                <input type="text" name="year" maxlength="4" placeholder="VD: 2025" required>
                </div>
            </div>
            <button type="button" id="findMeterBtn" style="background: #27ae60; margin-top: 14px;">Tìm chỉ số</button>
                            <label>Tiền phòng</label>
                <input type="number" name="tien_phong" value="1200000" min="0" required>

            <!-- Electricity and Water Section -->
            <div class="ew" style="display: flex; justify-content: space-between; gap: 4%;">

                <div class="left" style=" width: 49%; float: left;">

                    <h3 style="margin-top: 20px; color: #0d3a66; ">Thông tin điện</h3>


                    <labe style="display: none;;">Chọn chỉ số điện</labe>
                    <select style="display:none;" name="so_dien_select" id="so_dien_select">
                        <option value="">-- Chọn chỉ số điện --</option>
                    </select>

                    <label>Chỉ số cũ (CSC)</label>
                    <input type="text" name="e_old" value="0" readonly style="background:#f3f3f3;">

                    <label>Chỉ số mới (CSM)</label>
                    <input type="text" name="e_new" value="0" readonly style="background:#f3f3f3;">

                    <label>Lượng tiêu thụ (DTT)</label>
                    <input type="text" name="e_used" value="0" readonly style="background:#f3f3f3;">

                    <label>Đơn giá (₫/kWh)</label>
                    <input type="number" name="e_unit_price" value="3000" min="0" required>

                    <label>Thành tiền: <span id="e_total_display">0</span> ₫</label>
                    <input type="hidden" name="e_total" value="0">
                    <!-- </div> -->
                </div>
                <div class="right" style="width: 49%; float: right;">
                    <!-- Water Section -->
                    <h3 style=" width:50%;margin-top: 20px; color: #0d3a66;">Thông tin nước</h3>
                    <label style="display:none;">Chọn chỉ số nước</label>
                    <select name="so_nuoc_select" style="display:none;" id="so_nuoc_select">
                        <option value="">-- Chọn chỉ số nước --</option>
                    </select>

                    <label>Chỉ số cũ (CSC)</label>
                    <input type="text" name="w_old" value="0" readonly style="background:#f3f3f3;">

                    <label>Chỉ số mới (CSM)</label>
                    <input type="text" name="w_new" value="0" readonly style="background:#f3f3f3;">

                    <label>Lượng tiêu thụ (DTT)</label>
                    <input type="text" name="w_used" value="0" readonly style="background:#f3f3f3;">

                    <label>Đơn giá (₫/m³)</label>
                    <input type="number" name="w_unit_price" value="15000" min="0" required>

                    <label>Thành tiền: <span id="w_total_display">0</span> ₫</label>
                    <input type="hidden" name="w_total" value="0">
                </div>
            </div>
            <br>
            <!-- Room Fee & Service Fee -->
            <div class="dv">

                <h3 style="margin-top: 20px; color: #0d3a66;">Chi phí khác</h3>

                <label>Phí dịch vụ</label>
                <input type="number" name="service_fee" value="0" min="0">

                <label>Giảm giá</label>
                <input type="number" name="discount" min="0" value="0">

                <label style="display:none;">Nội dung chuyển khoản</label>
                <input type="text" name="addinfo" style="display:none;" readonly style="background:#f3f3f3;">

            </div>
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

        <!-- Hidden detailed breakdown -->
        <!-- <div class="summary-item">
            <label>Tiền phòng:</label>
            <span id="room_fee_display">1,200,000</span> ₫
        </div>

        <div class="summary-item">
            <label>Tiền điện:</label>
            <span id="e_total_display">0</span> ₫
        </div>

        <div class="summary-item">
            <label>Tiền nước:</label>
            <span id="w_total_display">0</span> ₫
        </div>

        <div class="summary-item">
            <label>Phí dịch vụ:</label>
            <span id="service_fee_display">0</span> ₫
        </div> -->

        <div class="summary-item" style="border-top: 1px solid rgba(255,255,255,0.3); padding-top: 14px; margin-top: 14px;">
            <label>Tổng tiền:</label>
            <span id="amount_display">1,200,000</span> ₫
        </div>

        <div class="summary-item">
            <label>Giảm giá:</label>
            <span id="discount_display">0</span> ₫
        </div>

        <div class="summary-item" style="border-top: 1px solid rgba(255,255,255,0.3); padding-top: 14px;">
            <label>Cần thanh toán:</label>
            <span id="payable_display">1,200,000</span> ₫
        </div>

        <div style="margin-top:14px;font-size:13px;color:rgba(255,255,255,0.85);text-align:center;">
            Bao gồm điện, nước, phòng và dịch vụ.
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>