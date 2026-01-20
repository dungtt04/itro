<?php
$isInvoiceExist = !empty($h);

$title = $isInvoiceExist
    ? 'In hóa đơn ' . $h['addinfo']
    : 'Hóa đơn không tồn tại';
$headContent = 
'<style>
  body { font-family: Arial, sans-serif; background: #f0f4f8; color: #333;}
  .container { max-width: 700px; margin: 40px auto 40px 40px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
  .infor{ position: fixed; right: 20px; top: 50%; transform: translateY(-50%); width: 300px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 20px; z-index: 1000; }
  .invoice{  width: 500px; margin: 20px auto; }
  h2, h3 { text-align: center; margin: 5px 0; }
  .button { text-align: center; }
      .btn-print {  margin:0 auto 18px auto; background:#093d62; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-size:16px; font-weight:500; cursor:pointer; text-decoration:none; width:max-content; }
    .btn-print:hover { background:#1e7e34; }
    .infor a {  margin:0 auto 18px auto; background: #ff0000ff; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-size:16px; font-weight:500; cursor:pointer; text-decoration:none; width:max-content; }
    .infor a:hover { background: #c90000ff; }
  .info { font-size: 14px; text-align: center; margin-bottom: 20px; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
  th, td { padding: 6px; text-align: left; border-bottom: 1px solid #ccc; }
  .total { font-weight: bold; text-align: right; }
  .note { font-size: 13px; margin-top: 10px; }
  .qr { border: 1px solid #000; width: 120px; height: 120px; }
  .footer_invoice { text-align: center; margin-top: 20px; font-size: 14px; color: #555; }
  .invoice-infor { font-size: 12px; color: #777; text-align: center; margin-top: 10px; }
  .container3{ max-width: 500px; margin: 100px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; text-align: center; }
  @media print {
    body { margin: 0; padding: 0; background-color: #fff; }
    .container{ box-shadow: none; margin: 0; padding: 0; border-radius: 0; }
    .infor { display: none; }
    .menu-bar, footer { display: none; }
    h2, h3, .info, table, .total, .note, .footer, .invoice-infor { page-break-inside: avoid; }
  }
  @media (max-width: 800px) {
    .container {  margin: 0; border-radius: 0; box-shadow: none; padding: 20px; }
    .infor {display: none; }
    .invoice { width: 100%; margin: 0; }
    
  }
</style>';
ob_start();

?>
<!-- <title>In hóa đơn <?= htmlspecialchars($h['addinfo']) ?> </title> -->
<?php if (!empty($h)): ?>
<div class="container">
  <div class="infor">
    <div class="content">
      <h3>Xem hóa đơn <?= htmlspecialchars($h['addinfo']) ?></h3>
      <b>Thông tin hóa đơn</b>
      <table>
        <tr>
          <td>Mã hóa đơn:</td>
          <td><?= htmlspecialchars($h['addinfo']) ?></td>
        </tr>
        <tr>
          <td>Phòng số:</td>
          <td><?= htmlspecialchars($h['room']) ?></td>
        </tr>
        <tr>
          <td>Tháng:</td>
          <td><?= date('m/Y', strtotime($h['mmyy'])) ?></td>
        </tr>
        <tr>
          <td>Trạng thái:</td>
          <td><?= htmlspecialchars($h['status']) ?></td>
        </tr>
      </table>
    </div> <br>
    <div class="button">
      <button class="btn-print" id="printBtn" onclick="window.print()">In hóa đơn</button>
      <a clss="btn-close" href="index.php?controller=invoice">Quay lại</a>
    </div>
    <!-- <div class="thongtin">
      Xem trước hóa đơn phòng <?= htmlspecialchars($h['room']) ?>, tháng  <?= date('m/Y', strtotime($h['mmyy'])) ?>
    </div> -->
  </div>

  
  <div class="invoice">
  <!-- <title>Hóa đơn <?= htmlspecialchars($h['id']) ?></title> -->
  <!-- <div class="container"></div> -->
    <h2>NHÀ TRỌ CHÚ QUẢNG</h2>
    <div class="info">
      Địa chỉ: Đội 6, Minh Thành, Lai Khê, TP.Hải Phòng<br>
      Điện thoại: 0352.153.772
    </div>
    <h3>HÓA ĐƠN DỊCH VỤ PHÒNG TRỌ</h3>
    <table>
      <tr style="text-align: center">
        <td><strong>Phòng:</strong> <?= htmlspecialchars($h['room']) ?></td>
        <td><strong>Tháng:</strong>  <?= htmlspecialchars($h['mmyy'])?></td>
      </tr>
    </table>
    <table>
      <thead>
        <tr>
          <th>DỊCH VỤ</th>
          <th>CSC</th>
          <th>CSM</th>
          <th>SL</th>
          <th>ĐƠN GIÁ</th>
          <th>THÀNH TIỀN</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Tiền phòng</td>
          <td></td>
          <td></td>
          <td></td>
          <td><?= number_format($h['tien_phong']) ?></td>
          <td><?= number_format($h['tien_phong']) ?></td>
        </tr>
        <tr>
          <td>Tiền điện</td>
          <td><?= isset($h['e_old']) && $h['e_old'] !== null ? htmlspecialchars($h['e_old']) : '' ?></td>
          <td><?= isset($h['e_new']) && $h['e_new'] !== null ? htmlspecialchars($h['e_new']) : '' ?></td>
          <td><?= isset($h['e_used']) && $h['e_used'] !== null ? htmlspecialchars($h['e_used']) : '' ?></td>
          <td>
            <?= isset($h['e_unit_price']) && $h['e_unit_price'] !== null ? number_format($h['e_unit_price']) : '3000' ?>
          </td>
          <td><?= isset($h['e_total']) && $h['e_total'] !== null ? number_format($h['e_total']) : '' ?></td>
        </tr>
        <tr>
          <td>Tiền nước</td>
          <td><?= isset($h['w_old']) && $h['w_old'] !== null ? htmlspecialchars($h['w_old']) : '' ?></td>
          <td><?= isset($h['w_new']) && $h['w_new'] !== null ? htmlspecialchars($h['w_new']) : '' ?></td>
          <td><?= isset($h['w_used']) && $h['w_used'] !== null ? htmlspecialchars($h['w_used']) : '' ?></td>
          <td>
            <?= isset($h['w_unit_price']) && $h['w_unit_price'] !== null ? number_format($h['w_unit_price']) : '15000' ?>
          </td>
          <td><?= isset($h['w_total']) && $h['w_total'] !== null ? number_format($h['w_total']) : '' ?></td>
        </tr>
        <tr>
          <td>Dịch vụ</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td><?= number_format($h['service_fee'] ?? 0) ?></td>
        </tr>
        <tr style="font-weight: bold;">
          <td style="text-align:right" colspan="5">Tổng</td>
          <td>
             <?= number_format($h['tong_tien']) ?>
          </td>
        </tr>
        <tr>
          <td style="text-align:right" colspan="5">Giảm giá</td>
          <td>
            <?= isset($h['discount']) ? number_format($h['discount']) : '0' ?>
          </td>
        </tr>
        <tr style="font-weight: bold;">
          <td  style="text-align:right" colspan="5">Cần thanh toán</td>
          <td>
             <?= isset($h['total_discount']) ? number_format($h['total_discount']) : number_format($h['tong_tien']) ?>
          </td>
      </tbody>
    </table>
    <div class="note">
      <?php if($h['status'] === 'Đã thanh toán'): ?>
        <strong> Hóa đơn đã được thanh toán.</strong>
        <p>Thời gian thanh toán:
          <?= date('d/m/Y  H:i:s', strtotime($h['updated_at'])) ?>
  
        </p>
      <?php else: ?>
      <table>
        <tr>
          <td rowspan="3" style="text-align: center; ">
            <img src="https://img.vietqr.io/image/VCB-0341001529970-qr_only.png?amount=<?= isset($h['total_discount']) ? $h['total_discount'] : $h['tong_tien'] ?>&addInfo=<?= urlencode($h['addinfo']) ?>&accountName=BUI%20THI%20THANG" alt="QR" class="qr">
          </td>
          <td>
            Quý khách vui lòng thanh toán hóa đơn
            trong vòng 3 ngày kể từ ngày tạo hóa đơn
          </td>
        </tr>
  
        <tr>
          <td style="text-align: left;">
            Ngày tạo: <?= date('d/m/Y h:i:s', strtotime($h['created_at'])) ?>
          </td>
        </tr>
        <tr>
          <td style="text-align: left;">
            Mã hóa đơn: <?= htmlspecialchars($h['addinfo']) ?>
          </td>
      </table>
      <?php endif; ?>
      <!-- Quý khách vui lòng thanh toán hóa đơn
      trong vòng 3 ngày kể từ ngày tạo hóa đơn<br><br>
     <table>
      <tr>
          <td style="width: 50%;"> Ngày tạo: <?= date('d/m/Y h:i:s', strtotime($h['created_at'])) ?></td>
          <td style="width: 50%; text-align: right;">Mã giao dịch: <?= htmlspecialchars($h['addinfo']) ?></td>
      </tr>
      <tr>
          <td colspan="2" class="center">
              Người tạo: dungtt_host
          </td>
      </tr>
      <!-- <tr>
          <td colspan="2" class="center">
            <strong>Quý khách vui lòng quét mã QR bên dưới để thanh toán</strong>
          </td>
      </tr> -->
     <!-- </table> -->
    </div>
    <!-- <div style="margin-top: 10px; text-align:center;">
      <img src="<?= htmlspecialchars($h['qr_url']) ?>" alt="QR" class="qr" style="width:90px;height:90px;">
    </div> -->
    <div class="footer_invoice">Cảm ơn quý khách!</div>
    <hr>
    <div style="text-align:center; ">
      <!-- <img src="https://barcode.tec-it.com/barcode.ashx?data=<?= urlencode($h['addinfo']) ?>&code=Code128&translate-esc=true" alt="Barcode" style="height:50px; margin-bottom:5px;" /> -->
      <!-- <br> -->
      <p style="font-family: 'Libre Barcode 128', 'Courier New', Courier, monospace; font-size:100px; letter-spacing:2px; margin:0;">
        <?= htmlspecialchars($h['addinfo']) ?>
      </p>
      <!-- <div style="font-size:12px; color:#555;">Mã giao dịch: <?= htmlspecialchars($h['addinfo']) ?></div> -->
      <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap" rel="stylesheet">
    <!-- </br> -->
  </div>
</div>
<?php else: ?>
<div class="container3">
  <h2>Hóa đơn không tồn tại</h2>
  <div style="text-align: center; margin-top: 20px;">
    <a href="index.php?controller=invoice" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #093d62; color: #fff; text-decoration: none; border-radius: 6px;">Quay lại</a>
  </div>
</div>
<?php endif; ?> 
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
