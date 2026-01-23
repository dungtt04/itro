<?php
$title = 'Thêm đặt cọc mới';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { color: #093d62; text-align: center; margin-bottom: 30px; }
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
    .button-group { margin-top: 30px; display: flex; gap: 10px; }
    button, a.btn { padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500; border: none; cursor: pointer; transition: background 0.2s; }
    .btn-primary { background: #093d62; color: #fff; }
    .btn-primary:hover { background: #1e7e34; }
    .btn-secondary { background: #999; color: #fff; padding: 10px 20px; }
    .btn-secondary:hover { background: #666; }
    .error { color: #d32f2f; margin-top: 5px; font-size: 14px; }
    .success { color: #2e7d32; margin-top: 5px; font-size: 14px; }
    .two-column { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
    .modal.show { display: block; }
    .modal-content { background-color: #fff; margin: 5% auto; padding: 30px; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 2px 20px rgba(0,0,0,0.3); }
    .modal-header { color: #093d62; font-weight: 600; font-size: 18px; margin-bottom: 20px; }
    .close-modal { float: right; cursor: pointer; font-size: 28px; color: #999; }
    .close-modal:hover { color: #333; }
    .section-title { font-weight: 600; color: #093d62; margin-top: 20px; margin-bottom: 15px; border-bottom: 2px solid #e3eafc; padding-bottom: 10px; }
    .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
    .checkbox-group input[type="checkbox"] { width: auto; }
    .customer-select-group { display: flex; gap: 10px; align-items: flex-end; }
    .customer-select-group select { flex: 1; }
    .customer-select-group button { padding: 10px 15px; width: auto; }
    @media (max-width: 600px) {
        .two-column { grid-template-columns: 1fr; }
        .customer-select-group { flex-direction: column; align-items: stretch; }
        .customer-select-group button { width: 100%; }
    }
</style>';

ob_start();
?>

<div class="container">
    <h2>Thêm Đặt Cọc Mới</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=deposit&action=add">
        <div class="section-title">Thông tin phòng</div>
        
        <div class="form-group">
            <label for="room_id">Phòng <span style="color: red;">*</span></label>
            <select name="room_id" id="room_id" required>
                <option value="">-- Chọn phòng --</option>
                <?php foreach ($allRooms as $room): ?>
                    <option value="<?= $room['id'] ?>">
                       Phòng số <?= htmlspecialchars($room['room_code']) ?> 
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="section-title">Thông tin khách hàng</div>

        <div class="form-group">
            <label for="customer_id">Chọn khách hàng hiện tại</label>
            <div class="customer-select-group">
                <select name="customer_id" id="customer_id">
                    <option value="0">-- Chọn khách hàng hoặc thêm mới --</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>">
                            <?= htmlspecialchars($customer['name']) ?> 
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="btn-primary" onclick="openAddCustomerModal()">Thêm khách mới</button>
            </div>
        </div>

        <div class="form-group">
            <label for="customer_name">Tên khách hàng <span style="color: red;">*</span></label>
            <input type="text" name="customer_name" id="customer_name" required placeholder="Nhập tên khách hàng">
            <small style="color: #666;">Nếu chọn khách hàng từ danh sách, trường này sẽ tự động điền</small>
        </div>

        <div id="newCustomerFields" style="display: none; background: #f8fafc; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
            <div class="form-group">
                <label for="customer_cccd">CCCD</label>
                <input type="text" name="customer_cccd" id="customer_cccd" placeholder="Số CCCD">
            </div>
            <div class="form-group">
                <label for="customer_dob">Ngày sinh</label>
                <input type="date" name="customer_dob" id="customer_dob">
            </div>
            <div class="form-group">
                <label for="customer_cccd_date">Ngày cấp CCCD</label>
                <input type="date" name="customer_cccd_date" id="customer_cccd_date">
            </div>
            <div class="form-group">
                <label for="customer_cccd_place">Nơi cấp CCCD</label>
                <input type="text" name="customer_cccd_place" id="customer_cccd_place" placeholder="Nơi cấp CCCD">
            </div>
            <div class="form-group">
                <label for="customer_phone">Số điện thoại</label>
                <input type="tel" name="customer_phone" id="customer_phone" placeholder="Số điện thoại">
            </div>
            <div class="form-group">
                <label for="customer_address">Địa chỉ</label>
                <input type="text" name="customer_address" id="customer_address" placeholder="Địa chỉ">
            </div>
            <div class="form-group">
                <label for="customer_type_of_tenant">Loại khách</label>
                <select name="customer_type_of_tenant" id="customer_type_of_tenant">
                    <option value="chính">Chính</option>
                    <option value="phụ">Phụ</option>
                </select>
            </div>
        </div>

        <div class="section-title">Thông tin cọc</div>

        <div class="form-group">
            <label for="deposit_amount">Số tiền cọc <span style="color: red;">*</span></label>
            <input type="number" name="deposit_amount" id="deposit_amount" required min="0" step="1000" placeholder="Nhập số tiền cọc" value="">
        </div>

        <div class="button-group">
            <button type="submit" class="btn-primary">Thêm</button>
            <a href="index.php?controller=deposit&action=list" class="btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<!-- Modal thêm khách hàng mới -->
<div id="addCustomerModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeAddCustomerModal()">&times;</span>
        <div class="modal-header">Thêm khách hàng mới</div>
        
        <div class="two-column">
            <!-- Cột 1 -->
            <div>
                <div class="form-group">
                    <label for="modalCustomerName">Tên khách hàng <span style="color: red;">*</span></label>
                    <input type="text" id="modalCustomerName" placeholder="Nhập tên khách hàng">
                </div>

                <div class="form-group">
                    <label for="modalCustomerDob">Ngày sinh</label>
                    <input type="date" id="modalCustomerDob">
                </div>

                <div class="form-group">
                    <label for="modalCustomerCccd">Số CCCD</label>
                    <input type="text" id="modalCustomerCccd" placeholder="Số CCCD">
                </div>

                <div class="form-group">
                    <label for="modalCustomerAddress">Địa chỉ</label>
                    <input type="text" id="modalCustomerAddress" placeholder="Địa chỉ">
                </div>
            </div>

            <!-- Cột 2 -->
            <div>
                <div class="form-group">
                    <label for="modalCustomerCccdDate">Ngày cấp CCCD</label>
                    <input type="date" id="modalCustomerCccdDate">
                </div>

                <div class="form-group">
                    <label for="modalCustomerCccdPlace">Nơi cấp CCCD</label>
                    <input type="text" id="modalCustomerCccdPlace" placeholder="Nơi cấp CCCD">
                </div>

                <div class="form-group">
                    <label for="modalCustomerPhone">Số điện thoại</label>
                    <input type="tel" id="modalCustomerPhone" placeholder="Số điện thoại">
                </div>

                <div class="form-group">
                    <label for="modalCustomerTypeOfTenant">Loại khách</label>
                    <select id="modalCustomerTypeOfTenant">
                        <option value="chính">Chính</option>
                        <option value="phụ">Phụ</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="button-group">
            <button type="button" class="btn-primary" onclick="addCustomerFromModal()">Thêm</button>
            <button type="button" class="btn-secondary" onclick="closeAddCustomerModal()">Đóng</button>
        </div>
    </div>
</div>

<script>
const customerSelect = document.getElementById('customer_id');
const customerNameInput = document.getElementById('customer_name');
const newCustomerFields = document.getElementById('newCustomerFields');

// Khi chọn khách hàng từ danh sách
customerSelect.addEventListener('change', function() {
    const newCustomerFields = document.getElementById('newCustomerFields');
    
    if (this.value === '0') {
        newCustomerFields.style.display = 'block';
        customerNameInput.value = '';
        customerNameInput.removeAttribute('readonly');
    } else {
        const selectedOption = this.options[this.selectedIndex];
        const customerName = selectedOption.text.split(' - ')[0];
        customerNameInput.value = customerName;
        customerNameInput.setAttribute('readonly', 'readonly');
        newCustomerFields.style.display = 'none';
    }
});

function openAddCustomerModal() {
    document.getElementById('addCustomerModal').classList.add('show');
    // Reset customer_id về 0 khi mở modal thêm khách mới
    customerSelect.value = '0';
    customerSelect.dispatchEvent(new Event('change'));
}

function closeAddCustomerModal() {
    document.getElementById('addCustomerModal').classList.remove('show');
    document.getElementById('modalCustomerName').value = '';
    document.getElementById('modalCustomerCccd').value = '';
    document.getElementById('modalCustomerDob').value = '';
    document.getElementById('modalCustomerCccdDate').value = '';
    document.getElementById('modalCustomerCccdPlace').value = '';
    document.getElementById('modalCustomerPhone').value = '';
    document.getElementById('modalCustomerAddress').value = '';
    document.getElementById('modalCustomerTypeOfTenant').value = 'chính';
}

function addCustomerFromModal() {
    const name = document.getElementById('modalCustomerName').value.trim();
    if (!name) {
        alert('Vui lòng nhập tên khách hàng!');
        return;
    }

    customerNameInput.value = name;
    document.getElementById('customer_cccd').value = document.getElementById('modalCustomerCccd').value;
    document.getElementById('customer_dob').value = document.getElementById('modalCustomerDob').value;
    document.getElementById('customer_cccd_date').value = document.getElementById('modalCustomerCccdDate').value;
    document.getElementById('customer_cccd_place').value = document.getElementById('modalCustomerCccdPlace').value;
    document.getElementById('customer_phone').value = document.getElementById('modalCustomerPhone').value;
    document.getElementById('customer_address').value = document.getElementById('modalCustomerAddress').value;
    document.getElementById('customer_type_of_tenant').value = document.getElementById('modalCustomerTypeOfTenant').value;
    customerSelect.value = '0';
    newCustomerFields.style.display = 'block';
    closeAddCustomerModal();
}

// Đóng modal khi click ngoài
window.onclick = function(event) {
    const modal = document.getElementById('addCustomerModal');
    if (event.target === modal) {
        closeAddCustomerModal();
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
