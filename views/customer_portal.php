
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
    .customer-portal {
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
    .btn-cus {
        padding: 14px 0;
        text-align: center;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 500;
        text-decoration: none;
    }
    .btn-cus:first-child {
        background-color: #093d62;
        color: #fff;
    }
    .btn-cus:last-child {
        background-color: #fff;
        color: #093d62;
        border: 2px solid #093d62;
    }   
</style>
<header>
    <title>Cổng thông tin khách hàng</title>
</header>
<!-- Giao diện chính cho khách hàng -->
<div class="customer-portal" style="max-width:500px;margin:32px auto;padding:32px 24px;background:#fff;border-radius:12px;box-shadow:0 2px 12px #0001;">
    <h2 style="text-align:center;color:#093d62;margin-bottom:28px;">NHÀ TRỌ CHÚ QUẢNG <br><hr>  TRANG DÀNH CHO KHÁHC HÀNG</h2>
    <div style="display:flex;flex-direction:column;gap:18px;">
        <a href="index.php?controller=customerportal&action=lookup" class="btn-cus" style="padding:14px 0;background:#093d62;color:#fff;text-align:center;border-radius:8px;font-size:18px;font-weight:500;text-decoration:none;">Tra cứu hóa đơn</a>
        <a href="index.php?controller=customerportal&action=declare" class="btn-cus" style="padding:14px 0;background:#fff;color:#093d62;text-align:center;border:2px solid #093d62;border-radius:8px;font-size:18px;font-weight:500;text-decoration:none;">Khai báo thông tin khách hàng</a>
    </div>
</div>
