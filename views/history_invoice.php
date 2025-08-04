<style>
  body { font-family: Arial, sans-serif; width: 500px; margin: 20px auto; padding: 20px; }
  h2, h3 { text-align: center; margin: 5px 0; }
  .center { text-align: center; }
  .info { font-size: 14px; text-align: center; margin-bottom: 20px; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
  th, td { padding: 6px; text-align: left; border-bottom: 1px solid #ccc; }
  .total { font-weight: bold; text-align: right; }
  .note { font-size: 13px; margin-top: 10px; }
  .qr { border: 1px solid #000; width: 120px; height: 120px; }
  .footer { text-align: center; margin-top: 20px; font-size: 14px; color: #555; }
  .invoice-infor { font-size: 12px; color: #777; text-align: center; margin-top: 10px; }
  @media print {
    /* body {  font-family: 'Courier New', Courier, monospace;} */
    button { display: none; }
    h2, h3, .info, table, .total, .note, .footer, .invoice-infor { page-break-inside: avoid; }
  }
</style>

<title>Hóa đơn <?= htmlspecialchars($h['id']) ?></title>

  <button id="printBtn" onclick="window.print()">In hóa đơn</button>
  <h2>NHÀ TRỌ CHÚ QUẢNG</h2>
  <div class="info">
    Địa chỉ: Đội 6, Minh Thành, Lai Khê, TP.Hải Phòng<br>
    Điện thoại: 0352.153.772
  </div>
  <h3>HÓA ĐƠN DỊCH VỤ PHÒNG TRỌ</h3>
  <table>
    <tr style="text-align: center">
      <td><strong>Phòng:</strong> <?= htmlspecialchars($h['room']) ?></td>
      <td><strong>Tháng:</strong> <?= htmlspecialchars($h['mmyy']) ?></td>
    </tr>
  </table>
  <table>
    <thead>
      <tr>
        <th>DỊCH VỤ</th>
        <th>CSC</th>
        <th>CSM</th>
        <th>SỐ LƯỢNG</th>
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
        <td><?= isset($h['CSC']) && $h['CSC'] !== null ? htmlspecialchars($h['CSC']) : '' ?></td>
        <td><?= isset($h['CSM']) && $h['CSM'] !== null ? htmlspecialchars($h['CSM']) : '' ?></td>
        <td><?= isset($h['DTT']) && $h['DTT'] !== null ? htmlspecialchars($h['DTT']) : '' ?></td>
        <td>3.000</td>
        <td><?= isset($h['tien_dien']) && $h['tien_dien'] !== null ? number_format($h['tien_dien']) : '' ?></td>
      </tr>
      <tr>
        <td>Tiền nước</td>
        <td><?= isset($h['CSC_NUOC']) && $h['CSC_NUOC'] !== null ? htmlspecialchars($h['CSC_NUOC']) : '' ?></td>
        <td><?= isset($h['CSM_NUOC']) && $h['CSM_NUOC'] !== null ? htmlspecialchars($h['CSM_NUOC']) : '' ?></td>
        <td><?= isset($h['DTT_NUOC']) && $h['DTT_NUOC'] !== null ? htmlspecialchars($h['DTT_NUOC']) : '' ?></td>
        <td>15.000</td>
        <td><?= isset($h['tien_nuoc']) && $h['tien_nuoc'] !== null ? number_format($h['tien_nuoc']) : '' ?></td>
      </tr>
      <tr>
        <td>Dịch vụ</td>
        <td></td>
        <td></td>
        <td><?= $h['so_nguoi'] ?></td>
        <td><?= ($h['so_nguoi'] == 0 ? '0' : ($h['so_nguoi'] == 1 ? '30.000' : '50.000')) ?></td>
        <td><?= number_format($h['so_nguoi'] == 0 ? 0 : ($h['so_nguoi'] == 1 ? 30000 : 50000)) ?></td>
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
    <table>
      <tr>
        <td rowspan="3" style="text-align: center; ">
          <img src="<?= htmlspecialchars($h['qr_url']) ?>" alt="QR" class="qr">
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
  <div class="footer">Cảm ơn quý khách!</div>
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
<?php
// $content = ob_get_clean();
// require __DIR__ . '/layout.php';
// ?>
