<?php 
require_once __DIR__ . '/../config/languages.php';
// Debug information
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
  <meta charset="UTF-8">
  <title><?php echo t('service_bill'); ?></title>
  <link rel="shortcut icon" href="portal/itro-logo-vuong.png" type="image/x-icon">
  <style>
    body {
      font-family: 'Inter', 'Segoe UI', sans-serif;
      background: #eef2f7;
      margin: 0;
      padding: 0;
      color: #222;
    }

    .container {
      max-width: 960px;
      margin: 40px auto;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
      padding: 30px 40px;
      position: relative;
    }

    .invoice-layout {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      gap: 40px;
    }

    .invoice-left {
      flex: 1;
    }

    .qr-fixed {
      width: 160px;
      text-align: center;
      position: sticky;
      top: 120px;
    }

    .qr-fixed img {
      width: 140px;
      height: 140px;
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 8px;
      background: #fff;
    }

    .header {
      text-align: center;
      margin-bottom: 35px;
      padding-bottom: 15px;
      border-bottom: 3px solid #0d47a1;
    }

    .header h2 {
      font-size: 28px;
      color: #0d47a1;
      margin-bottom: 6px;
      letter-spacing: 1px;
    }

    .header p {
      margin: 2px 0;
      font-size: 15px;
      color: #333;
    }

    .invoice-card {
      border: 1px solid #dce3f0;
      border-radius: 10px;
      margin-bottom: 35px;
      padding: 25px;
      background: #fafbff;
    }

    .section-title {
      font-weight: 700;
      color: #1a237e;
      margin: 20px 0 10px;
      font-size: 17px;
      text-transform: uppercase;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px 20px;
      margin-bottom: 10px;
    }

    .info-item {
      background: #fff;
      border: 1px solid #e0e4ec;
      border-radius: 8px;
      padding: 8px 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .info-label {
      font-weight: 600;
      color: #555;
    }

    .info-value {
      color: #0d47a1;
      font-weight: 600;
    }

    .sub-table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
    }

    .sub-table th {
      background: #1a237e;
      color: #fff;
      padding: 8px;
      font-weight: 500;
      text-align: center;
    }

    .sub-table td {
      padding: 8px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    .highlight {
      background: #e3f2fd;
      font-weight: bold;
      color: #0d47a1;
    }

    .total-section {
      background: #f0f4ff;
      border-radius: 10px;
      padding: 15px;
      margin-top: 20px;
    }

    .total-section div {
      display: flex;
      justify-content: space-between;
      padding: 6px 0;
      font-size: 15px;
    }

    .total-section .total-pay {
      font-weight: 700;
      color: #1a237e;
      font-size: 18px;
      border-top: 2px solid #ccc;
      padding-top: 10px;
      margin-top: 5px;
    }
    .home-btn {
      display: block;
      background-color: #0a3d91;
      color: white;
      text-decoration: none;
      padding: 14px;
      margin: 12px 0;
      border-radius: 10px;
      text-align: center;
      font-size: 1.05em;
      font-weight: 600;
      transition: all 0.25s ease;
    }

    .error-message {
      text-align: center;
      padding: 25px;
      font-size: 18px;
      color: #c62828;
      background: #ffebee;
      border-radius: 8px;
    }

    @media print {
      body {
        background: #fff !important;
        color: #000 !important;
      }
      header, footer, .back-link {
        display: none !important;
      }
      .container {
        width: 100%;
        margin: 0;
        padding: 0;
        box-shadow: none;
        border: none;
      }
      .invoice-card {

        border-radius: 0 !important;
        padding: 10px;
        background: #fff !important;
        color: #000 !important;
      }
      .section-title {
        color: #000 !important;
      }
      .sub-table {
        border: 1px solid #000;
        border-radius: 0;
      }
      .sub-table th, .sub-table td {
        border: 1px solid #000;
        background: #fff !important;
        color: #000 !important;
      }
      .info-item {
        border-radius: 0 !important;
        background: #fff !important;
        color: #000 !important;
      }
      .total-section {
        background: #fff !important;
        border-radius: 0 !important;
      }
      .highlight {
        background: #fff !important;
        color: #000 !important;
      }
      /* Ẩn QR nếu hóa đơn đã thanh toán */
      .qr-fixed, .qr-box {
        position: relative;
        text-align: center;
        margin-top: 15px;
      }
    }
  </style>
</head>
<body>
  <?php include 'portal/views/partials/header.php'; ?>
  <div class="container">
    <div class="header">
      <h2><?php echo t('motel_name'); ?></h2>
      <p><?php echo t('motel_address'); ?></p>
      <p><?php echo t('motel_phone'); ?></p>
    </div>
    <h2 style="text-align:center;"><?php echo t('service_bill'); ?></h2>

    <?php if (!empty($results)): ?>
      <?php foreach ($results as $row): ?>
        <?php
        require_once __DIR__ . '/../config/database.php';
        $electric = null;
        $water = null;
        if ($row['electricity_id']) {
          $stmt2 = $pdo->prepare('SELECT * FROM electricity WHERE id = ?');
          $stmt2->execute([$row['electricity_id']]);
          $electric = $stmt2->fetch();
        }
        if ($row['water_id']) {
          $stmt3 = $pdo->prepare('SELECT * FROM water WHERE id = ?');
          $stmt3->execute([$row['water_id']]);
          $water = $stmt3->fetch();
        }
        $so_nguoi = isset($row['so_nguoi']) ? (int)$row['so_nguoi'] : 1;
        $phi_dv = $so_nguoi === 1 ? 30000 : ($so_nguoi === 2 ? 50000 : 0);
        ?>

        <?php 
        $paid_status = t('status_paid'); // Add translation for payment status
        if ($row['status'] !== $paid_status): ?>
          <div class="invoice-layout">
            <div class="invoice-left">
        <?php endif; ?>

        <div class="invoice-card">
          <div class="section-title"><?php echo t('general_info'); ?></div>
          <div class="info-grid">
            <div class="info-item"><span class="info-label"><?php echo t('room'); ?></span><span class="info-value"><?= $room ?></span></div>
            <div class="info-item"><span class="info-label"><?php echo t('month'); ?></span><span class="info-value"><?= $month ?>/<?= $year ?></span></div>
            <div class="info-item"><span class="info-label"><?php echo t('room_fee'); ?></span><span class="info-value"><?= number_format($row['tien_phong']) ?> đ</span></div>
            <div class="info-item"><span class="info-label"><?php echo t('service_fee'); ?></span><span class="info-value"><?= number_format($phi_dv) ?> đ</span></div>
          </div>

          <div class="section-title"><?php echo t('electricity_details'); ?></div>
          <?php if ($electric): ?>
            <table class="sub-table">
              <tr>
                <th><?php echo t('previous_reading'); ?></th>
                <th><?php echo t('current_reading'); ?></th>
                <th><?php echo t('consumption'); ?></th>
                <th><?php echo t('unit_price'); ?></th>
                <th><?php echo t('total_amount'); ?></th>
              </tr>
              <tr>
                <td><?= sprintf("%06d", (int)$electric['CSC']) ?></td>
                <td><?= sprintf("%06d", (int)$electric['CSM']) ?></td>
                <td><?= htmlspecialchars($electric['DTT']) ?></td>
                <td><?= number_format($electric['unit_price']) ?></td>
                <td class="highlight"><?= number_format($electric['total']) ?> đ</td>
              </tr>
            </table>
          <?php endif; ?>

          <div class="section-title"><?php echo t('water_details'); ?></div>
          <?php if ($water): ?>
            <table class="sub-table">
              <tr>
                <th><?php echo t('previous_reading'); ?></th>
                <th><?php echo t('current_reading'); ?></th>
                <th><?php echo t('consumption'); ?></th>
                <th><?php echo t('unit_price'); ?></th>
                <th><?php echo t('total_amount'); ?></th>
              </tr>
              <tr>
                <td><?= sprintf("%06d", (int)$water['CSC']) ?></td>
                <td><?= sprintf("%06d", (int)$water['CSM']) ?></td>
                <td><?= htmlspecialchars($water['DTT']) ?></td>
                <td><?= number_format($water['unit_price']) ?></td>
                <td class="highlight"><?= number_format($water['total']) ?> đ</td>
              </tr>
            </table>
          <?php endif; ?>

          <div class="section-title"><?php echo t('summary'); ?></div>
          <div class="total-section">
            <div><span><?php echo t('total_amount'); ?>:</span><span><?= number_format($row['tong_tien']) ?> đ</span></div>
            <div><span><?php echo t('discount'); ?>:</span><span>- <?= number_format($row['discount']) ?> đ</span></div>
            <div class="total-pay"><span><?php echo t('amount_to_pay'); ?>:</span><span><?= number_format($row['total_discount']) ?> đ</span></div>
          </div>

          <?php if ($row['status'] === $paid_status): ?>
            <p style="text-align:center;"><?php echo t('bill_paid'); ?></p>
          <?php endif; ?>
        </div>

        <?php if ($row['status'] !== 'Đã thanh toán'): ?>
            </div>
            <?php if (!empty($row['qr_url'])): ?>
              <div class="qr-fixed">
                <img src="<?= htmlspecialchars($row['qr_url']) ?>" alt="QR Payment">
                <div style="margin-top:6px;color:#555;"><?php echo t('scan_to_pay'); ?></div>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

      <?php endforeach; ?>
    <?php else: ?>
      <div class="error-message"><?php echo t('no_bill_found'); ?></div>
    <?php endif; ?>
      <a class="home-btn" href="http://itro.dungtt.id.vn"><?php echo t('lookup_another'); ?></a>
  </div>
    </div>
  <?php include 'portal/views/partials/footer.php'; ?>
</body>
</html>
