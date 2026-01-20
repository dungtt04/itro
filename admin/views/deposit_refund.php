<?php
$title = 'Trả phòng/cọc';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 700px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { color: #093d62; text-align: center; margin-bottom: 30px; }
    .deposit-info { background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #093d62; }
    .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
    .info-label { font-weight: 600; color: #093d62; }
    .info-value { color: #333; }
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    input[type="date"],
    select,
    textarea { width: 100%; padding: 10px 12px; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
    input:focus,
    select:focus,
    textarea:focus { outline: none; border-color: #093d62; box-shadow: 0 0 5px #093d6240; }
    .refund-options { margin: 20px 0; }
    .refund-option { background: #f8fafc; padding: 15px; border-radius: 6px; margin-bottom: 15px; border: 2px solid #e3eafc; cursor: pointer; transition: all 0.2s; }
    .refund-option:hover { border-color: #093d62; background: #f0f4fa; }
    .refund-option.selected { border-color: #093d62; background: #e3eafc; }
    .refund-option input[type="radio"] { margin-right: 10px; cursor: pointer; }
    .option-title { font-weight: 600; color: #093d62; margin-bottom: 10px; }
    .refund-details { display: none; background: #fff; padding: 15px; border-radius: 6px; border-left: 3px solid #093d62; margin-top: 10px; }
    .refund-details.show { display: block; }
    .amount { text-align: right; font-weight: 500; color: #d84315; }
    .checkbox-group { display: flex; align-items: center; gap: 10px; }
    .checkbox-group input[type="checkbox"] { width: auto; }
    .button-group { margin-top: 30px; display: flex; gap: 10px; }
    button, a.btn { padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500; border: none; cursor: pointer; transition: background 0.2s; }
    .btn-primary { background: #093d62; color: #fff; }
    .btn-primary:hover { background: #1e7e34; }
    .btn-secondary { background: #999; color: #fff; padding: 10px 20px; }
    .btn-secondary:hover { background: #666; }
    .error { color: #d32f2f; margin-top: 5px; font-size: 14px; }
    .success { color: #2e7d32; margin-top: 5px; font-size: 14px; }
</style>';

ob_start();
?>

<div class="container">
    <h2>Trả Phòng / Trả Cọc</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Thông tin đặt cọc -->
    <div class="deposit-info">
        <div class="info-row">
            <span class="info-label">Phòng:</span>
            <span class="info-value"><?= htmlspecialchars($deposit['room_code']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Khách hàng:</span>
            <span class="info-value"><?= htmlspecialchars($deposit['customer_name'] ?? $deposit['name'] ?? 'N/A') ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Số tiền cọc:</span>
            <span class="info-value amount"><?= number_format($deposit['deposit_amount'], 0, ',', '.') ?> đ</span>
        </div>
        <div class="info-row">
            <span class="info-label">Trạng thái cọc:</span>
            <span class="info-value"><?= htmlspecialchars($deposit['deposit_status']) ?></span>
        </div>
    </div>

    <form method="POST" action="index.php?controller=deposit&action=refund">
        <input type="hidden" name="deposit_id" value="<?= $deposit['id'] ?>">

        <div class="form-group">
            <label>Cách trả phòng <span style="color: red;">*</span></label>
            <div class="refund-options">
                <!-- Trả cọc -->
                <div class="refund-option" onclick="selectRefundType('return', event)">
                    <div class="option-title">
                        <input type="radio" name="refund_type" value="return" id="refund_return"> 
                        Trả cọc
                    </div>
                    <div style="color: #666; font-size: 13px;">Hoàn lại tiền cọc cho khách hàng</div>
                </div>

                <!-- Không trả cọc -->
                <div class="refund-option" onclick="selectRefundType('no_return', event)">
                    <div class="option-title">
                        <input type="radio" name="refund_type" value="no_return" id="refund_no_return">
                        Không trả cọc
                    </div>
                    <div style="color: #666; font-size: 13px;">Giữ lại tiền cọc (có nhập lý do)</div>
                </div>
            </div>
        </div>

        <!-- Chi tiết cho Trả cọc -->
        <div id="refund_return_details" class="refund-details">
            <div class="form-group">
                <label for="refund_amount">Số tiền hoàn</label>
                <input type="number" name="refund_amount" id="refund_amount" min="0" step="1000" placeholder="Nhập số tiền hoàn">
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="use_full_amount" name="use_full_amount" value="1" onchange="toggleRefundAmount()">
                <label for="use_full_amount" style="margin-bottom: 0;">Theo số tiền cọc (<?= number_format($deposit['deposit_amount'], 0, ',', '.') ?> đ)</label>
            </div>
        </div>

        <!-- Chi tiết cho Không trả cọc -->
        <div id="refund_no_return_details" class="refund-details">
            <div class="form-group">
                <label for="refund_reason">Lý do không trả cọc <span style="color: red;">*</span></label>
                <textarea name="refund_reason" id="refund_reason" rows="4" placeholder="Nhập lý do không trả cọc..."></textarea>
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-primary">Lưu</button>
            <a href="index.php?controller=deposit&action=list" class="btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<script>
const depositAmount = <?= $deposit['deposit_amount'] ?>;

function selectRefundType(type, event) {
    // Deselect all options
    document.querySelectorAll('.refund-option').forEach(el => el.classList.remove('selected'));
    
    // Select clicked option
    event.currentTarget.classList.add('selected');
    
    // Set radio button
    const radio = event.currentTarget.querySelector('input[type="radio"]');
    radio.checked = true;
    
    // Show/hide details
    document.getElementById('refund_return_details').classList.remove('show');
    document.getElementById('refund_no_return_details').classList.remove('show');
    
    if (type === 'return') {
        document.getElementById('refund_return_details').classList.add('show');
    } else if (type === 'no_return') {
        document.getElementById('refund_no_return_details').classList.add('show');
    }
}

function toggleRefundAmount() {
    const checkbox = document.getElementById('use_full_amount');
    const input = document.getElementById('refund_amount');
    
    if (checkbox.checked) {
        input.value = depositAmount;
        input.disabled = true;
    } else {
        input.value = '';
        input.disabled = false;
    }
}

// Validate form
document.querySelector('form').addEventListener('submit', function(e) {
    const refundType = document.querySelector('input[name="refund_type"]:checked');
    
    if (!refundType) {
        e.preventDefault();
        alert('Vui lòng chọn cách trả phòng!');
        return;
    }

    if (refundType.value === 'return') {
        const useFullAmount = document.getElementById('use_full_amount').checked;
        const refundAmount = parseFloat(document.getElementById('refund_amount').value || 0);
        
        if (!useFullAmount && (!refundAmount || refundAmount <= 0)) {
            e.preventDefault();
            alert('Vui lòng nhập số tiền hoàn hoặc chọn theo số tiền cọc!');
            return;
        }
        
        if (!useFullAmount && refundAmount > depositAmount) {
            e.preventDefault();
            alert('Số tiền hoàn không thể vượt quá số tiền cọc (' + depositAmount + ' đ)!');
            return;
        }
    } else if (refundType.value === 'no_return') {
        const refundReason = document.getElementById('refund_reason').value.trim();
        if (!refundReason) {
            e.preventDefault();
            alert('Vui lòng nhập lý do không trả cọc!');
        }
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
