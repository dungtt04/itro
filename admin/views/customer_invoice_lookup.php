<style>
    body {
        font-family: 'Roboto', Arial, sans-serif;
        background: #f6f8fa;
        min-height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .customer-lookup {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.01);
        padding: 32px 24px;
        width: 100%;
    }
    h2 {
        color: #093d62;
        text-align: center;
        margin-bottom: 28px;
    }
    input[type="text"], input[type="number"], select {
        width: 100%;
        padding: 10px;
        margin-top: 4px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    button {
        padding: 12px 0;
        background-color: #093d62;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 17px;
        font-weight: 500;
    }
</style>
<!-- Form tra cứu hóa đơn cho khách hàng -->
<div class="customer-lookup" style="max-width:480px;margin:32px auto;padding:28px 20px;background:#fff;border-radius:12px;box-shadow:0 2px 12px #0001;">
    <h2 style="text-align:center;color:#093d62;margin-bottom:22px;">Tra cứu hóa đơn</h2>
    <form method="get" action="index.php" style="display:flex;flex-direction:column;gap:16px;" onsubmit="this.controller.value='customerportal';this.action.value='lookup';">
        <input type="hidden" name="controller" value="customerportal">
        <input type="hidden" name="action" value="lookup">
        <label>Số phòng
            <input type="text" name="room" required placeholder="Nhập số phòng" style="width:100%;padding:10px 12px;border-radius:6px;border:1px solid #ccc;margin-top:4px;">
        </label>
        <label>Tháng
            <select name="month" style="width:100%;padding:10px 12px;border-radius:6px;border:1px solid #ccc;margin-top:4px;">
                <option value="">-- Chọn tháng --</option>
                <?php for($i=1;$i<=12;$i++) echo "<option value='$i'>$i</option>"; ?>
            </select>
        </label>
        <label>Năm
            <input type="number" name="year" min="2020" max="2100" required placeholder="Nhập năm" style="width:100%;padding:10px 12px;border-radius:6px;border:1px solid #ccc;margin-top:4px;">
        </label>
        <button type="submit" style="padding:12px 0;background:#093d62;color:#fff;border:none;border-radius:8px;font-size:17px;font-weight:500;">Tra cứu</button>
    </form>
    <?php if (isset($invoices)) { ?>
        <?php if (empty($invoices)) { ?>
            <div style="margin-top:24px;text-align:center;color:#d93025;font-weight:500;">Không tìm thấy hóa đơn phù hợp!</div>
        <?php } else { ?>
        <div style="margin-top:24px;">
            <h3 style="color:#093d62;font-size:18px;">Kết quả hóa đơn:</h3>
            <table style="width:100%;margin-top:10px;border-collapse:collapse;">
                <tr style="background:#f5f5f5;"><th>Tháng</th><th>Năm</th><th>Số phòng</th><th>Số tiền</th><th>Trạng thái</th></tr>
                <?php foreach($invoices as $inv) { ?>
                <tr>
                    <td><?= htmlspecialchars($inv['mmyy'] ?? $inv['month']) ?></td>
                    <td><?= isset($inv['mmyy']) ? substr($inv['mmyy'],2) : htmlspecialchars($inv['year']) ?></td>
                    <td><?= htmlspecialchars($inv['room']) ?></td>
                    <td><?= number_format($inv['amount']) ?> đ</td>
                    <td><?= $inv['status'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php } ?>
    <?php } ?>
</div>
