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
    .customer-declare {
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
    a {
        display: inline-block;
        margin-bottom: 16px;
        color: #093d62;
        text-decoration: none;
        font-weight: 500;
    }
    label {
        font-weight: 500;
        color: #093d62;
    }
    input[type="text"] {
        width: 100%;
        padding: 10px 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-top: 4px;
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
<!-- Form khai báo thông tin khách hàng -->
<div class="customer-declare" style="max-width:480px;margin:32px auto;padding:28px 20px;background:#fff;border-radius:12px;box-shadow:0 2px 12px #0001;">
    <h2 style="text-align:center;color:#093d62;margin-bottom:22px;">Khai báo thông tin khách hàng</h2>
    <a href="index.php?controller=customerportal" title="Quay lại trang tra cứu hóa đơn khách hàng">Quay lại Cổng thông tin</a>
    <form method="post" action="index.php?controller=customer&action=declare" style="display:flex;flex-direction:column;gap:16px;">
        <label>Họ tên
            <input type="text" name="name" required placeholder="Nhập họ tên" style="width:100%;padding:10px 12px;border-radius:6px;border:1px solid #ccc;margin-top:4px;">
        </label>
        <label>Số điện thoại
            <input type="text" name="phone" required placeholder="Nhập số điện thoại" style="width:100%;padding:10px 12px;border-radius:6px;border:1px solid #ccc;margin-top:4px;">
        </label>
        <label>Số phòng
            <input type="text" name="room" required placeholder="Nhập số phòng" style="width:100%;padding:10px 12px;border-radius:6px;border:1px solid #ccc;margin-top:4px;">
        </label>
        <label>CMND/CCCD
            <input type="text" name="idcard" required placeholder="Nhập số CMND/CCCD" style="width:100%;padding:10px 12px;border-radius:6px;border:1px solid #ccc;margin-top:4px;">
        </label>
        <label>Địa chỉ
            <input type="text" name="address" required placeholder="Nhập địa chỉ" style="width:100%;padding:10px 12px;border-radius:6px;border:1px solid #ccc;margin-top:4px;">
        </label>
        <button type="submit" style="padding:12px 0;background:#093d62;color:#fff;border:none;border-radius:8px;font-size:17px;font-weight:500;">Gửi khai báo</button>
    </form>
    <?php if (!empty($success)) { ?>
        <div style="margin-top:18px;color:green;text-align:center;">Khai báo thành công!</div>
    <?php } ?>
</div>
