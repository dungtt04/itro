<?php
$title = 'Hệ thống quản lý nhà trọ iTrọ';
$headContent = '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    .dashboard-flex { display: flex; gap: 32px; flex-wrap: wrap; }
    .dashboard-left { flex: 1.1; min-width: 340px; }
    .dashboard-right { flex: 1.2; min-width: 340px; }
    .chart-block { margin-bottom: 32px; }
    form { text-align: center; margin-bottom: 18px; }
    select, input[type=number] { padding: 6px 10px; border-radius: 6px; border: 1px solid #bfc7d1; font-size: 15px; margin: 0 6px; }
    button { padding: 7px 18px; border-radius: 6px; background: #093d62; color: #fff; border: none; font-weight: 500; cursor: pointer; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
    th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
    th { background: #e3eafc; color: #093d62; }
    .dashboard-stats-flex { display: flex; gap: 32px; margin-bottom: 32px; flex-wrap: wrap; }
    .dashboard-stats-flex > div { flex: 1; min-width: 320px; }
    @media (max-width: 900px) {
      .dashboard-flex, .dashboard-stats-flex { flex-direction: column; gap: 18px; }
      .dashboard-left, .dashboard-right, .dashboard-stats-flex > div { min-width: 0; }
    }
    @media (max-width: 600px) {
      .container { padding: 10px 2vw; }
      table, th, td { font-size: 14px; }
      h2, h3 { font-size: 18px; }
    }
</style>';
ob_start();
?>
<div class="container">
    <h2>HỆ THỐNG QUẢN LÝ NHÀ TRỌ </h2>
    <label class="text-align: center;"> Chọn nhà trọ muốn xem thống kê:
                <select style="text-align:center;" name="">
                    <option>Nhà trọ chú Quảng</option>
            </select>
            </label>
    <div class="dashboard-flex">
      <div class="dashboard-left">
        <h2>Thống kê sử dụng điện, nước</h2>
        <form method="get" action="">
            <input type="hidden" name="controller" value="dashboard">
            <label>Tháng</label>
            <select name="month">
                <?php for($m=1;$m<=12;$m++): $mm = str_pad($m,2,'0',STR_PAD_LEFT); ?>
                    <option value="<?= $mm ?>" <?= $mm==$month?'selected':'' ?>><?= $mm ?></option>
                <?php endfor; ?>
            </select>
            <label>Năm</label>
            <input type="number" name="year" value="<?= htmlspecialchars($year) ?>" min="2020" max="2100" style="width:90px;">
            <button type="submit">Xem</button>
        </form>
        <div class="chart-block">
            <canvas id="electricityChart" height="120"></canvas>
        </div>
        <div class="chart-block">
            <canvas id="waterChart" height="120"></canvas>
        </div>
      </div>
      <div class="dashboard-right">
        <!-- Viết CSS cho class title này thẻ h3 căn trái, a căn phải -->
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <h3 style="text-align:left;">Khách thuê mới (7 ngày gần nhất)</h3>
          <a style="text-align:right;text-decoration:none;" href="/index.php?controller=customer">Xem tất cả</a>
        </div>
        <table>
            <tr>
                <th>Tên</th><th>Phòng</th><th>Ngày tạo</th><th>Điện thoại</th>
            </tr>
            <?php foreach($newCustomers as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['room']) ?></td>
                <td><?= htmlspecialchars($c['created_at']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($newCustomers)): ?><tr><td colspan="4" style="text-align:center;">Không có khách mới</td></tr><?php endif; ?>
        </table>
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <h3 style="text-align:left;">Hóa đơn chứa thanh toán</h3>
          <a style="text-align:right;text-decoration:none;" href="/index.php?controller=invoice">Xem tất cả</a>
        </div>
        <table style="width:100%;border-collapse:collapse;">
            <tr style="background:#e3eafc;color:#093d62;">
                <th>Phòng</th><th>Tháng/Năm</th><th>Thao tác</th>
            </tr>
            <?php foreach($unpaidInvoices as $h): ?>
            <tr>
                <td><?= htmlspecialchars($h['room']) ?></td>
                <td><?= htmlspecialchars($h['mmyy']) ?></td>
                <!-- <td><?= number_format($h['amount']) ?></td>
                <td><?= htmlspecialchars($h['created_at']) ?></td> -->
                <td>
                    <a href="index.php?controller=invoice&action=mark_paid&id=<?= $h['id'] ?>" onclick="return confirm('Xác nhận thanh toán hóa đơn này?');" style="background:#1e7e34;color:#fff;padding:6px 16px;border-radius:6px;text-decoration:none;font-weight:500;">Thanh toán</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($unpaidInvoices)): ?><tr><td colspan="5" style="text-align:center;">Không có hóa đơn chưa thanh toán</td></tr><?php endif; ?>
        </table>
        <!-- Thêm mục hiển thị số phòng trống (đếm số phòng có trạng thái 'Còn trống') -->
        <?php
        // Giả sử biến $rooms chứa danh sách các phòng, mỗi phòng là 1 mảng có key 'status'
        $emptyRooms = 0;
        if (!empty($rooms) && is_array($rooms)) {
            foreach ($rooms as $room) {
          if (isset($room['status']) && $room['status'] === 'Còn trống') {
              $emptyRooms++;
          }
            }
        }
        ?>
        <div style="margin: 18px 0; padding: 14px; background: #e3eafc; border-radius: 8px; color: #093d62; font-weight: 500;">
            Số phòng còn trống: <b><?= $emptyRooms ?></b>
        </div>
      <?php
      // Giả sử biến $customers chứa danh sách khách thuê, mỗi khách là 1 mảng có key 'status'
      $activeCustomers = 0;
      if (!empty($customers) && is_array($customers)) {
        foreach ($customers as $cus) {
          if (isset($cus['status']) && $cus['status'] === 'Đang thuê') {
            $activeCustomers++;
          }
        }
      }
      ?>
      <div style="margin: 18px 0; padding: 14px; background: #e3eafc; border-radius: 8px; color: #093d62; font-weight: 500;">
        Số khách đang thuê: <b><?= $activeCustomers ?></b>
      </div>
      </div>
    </div>
    <!-- <hr/>
    <hr/> -->

    <!-- <div class="dashboard-stats-flex" style="display:flex;gap:32px;margin-bottom:32px;flex-wrap:wrap;">
      <div style="flex:1;min-width:320px;">
        <form method="get" style="margin-bottom:10px;">
          <input type="hidden" name="controller" value="dashboard">
          <b>Thống kê doanh thu theo tháng:</b>
          <select name="stat_month">
            <?php for($m=1;$m<=12;$m++): $mm = str_pad($m,2,'0',STR_PAD_LEFT); ?>
              <option value="<?= $mm ?>" <?= $mm==$statMonth?'selected':'' ?>><?= $mm ?></option>
            <?php endfor; ?>
          </select>
          <select name="stat_year">
            <?php for($y=2023;$y<=date('Y')+1;$y++): ?>
              <option value="<?= $y ?>" <?= $y==$statYear?'selected':'' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
          <button type="submit">Xem tháng</button>
        </form>
        <h3 style="margin-top:0;">Thống kê doanh thu tháng <?= htmlspecialchars($statMonth) ?>/<?= htmlspecialchars($statYear) ?></h3>
        <table style="margin-bottom:18px;">
          <tr><th>Tổng thu</th><td><?= number_format($tongThu) ?> đ</td></tr>
          <tr><th>Thu điện</th><td><?= number_format($thuDien) ?> đ</td></tr>
          <tr><th>Thu nước</th><td><?= number_format($thuNuoc) ?> đ</td></tr>
          <tr><th>Khấu trừ nộp điện (2326/kWh)</th><td><?= number_format($nopDien) ?> đ</td></tr>
          <tr><th>Khấu trừ nộp nước (12.500/m³)</th><td><?= number_format($nopNuoc) ?> đ</td></tr>
          <tr><th>Lợi nhuận sau trừ</th><td><b><?= number_format($loiNhuan) ?> đ</b></td></tr>
        </table>
      </div>
      <div style="flex:1;min-width:320px;">
        <form method="get" style="margin-bottom:10px;">
          <input type="hidden" name="controller" value="dashboard">
          <b>Thống kê doanh thu theo năm:</b>
          <select name="stat_year_only">
            <?php for($y=2023;$y<=date('Y')+1;$y++): ?>
              <option value="<?= $y ?>" <?= $y==$statYearOnly?'selected':'' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
          <button type="submit">Xem năm</button>
        </form>
        <h3 style="margin-top:0;">Thống kê doanh thu năm <?= htmlspecialchars($statYearOnly) ?></h3>
        <table>
          <tr><th>Tổng thu</th><td><?= number_format($tongThuNam) ?> đ</td></tr>
          <tr><th>Thu điện</th><td><?= number_format($thuDienNam) ?> đ</td></tr>
          <tr><th>Thu nước</th><td><?= number_format($thuNuocNam) ?> đ</td></tr>
          <tr><th>Khấu trừ nộp điện (2326/kWh)</th><td><?= number_format($nopDienNam) ?> đ</td></tr>
          <tr><th>Khấu trừ nộp nước (12.500/m³)</th><td><?= number_format($nopNuocNam) ?> đ</td></tr>
          <tr><th>Lợi nhuận sau trừ</th><td><b><?= number_format($loiNhuanNam) ?> đ</b></td></tr>
        </table>
      </div>
    </div> -->
</div>
<script>
const labels = <?= json_encode($labels) ?>;
const electricityData = <?= json_encode($electricityData) ?>;
const waterData = <?= json_encode($waterData) ?>;
const ctx1 = document.getElementById('electricityChart').getContext('2d');
const ctx2 = document.getElementById('waterChart').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Số điện tiêu thụ (kWh)',
            data: electricityData,
            backgroundColor: '#093d62',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Số nước tiêu thụ (m³)',
            data: waterData,
            backgroundColor: '#1e7e34',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<!-- <footer style="text-align:center; color:#888; font-size:15px; margin-top:32px; padding:18px 0 0 0;">
    &copy; 2025 Copyright by Tang Tien Dung
</footer> -->
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
