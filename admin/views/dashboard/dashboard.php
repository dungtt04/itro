<?php
$title = 'Dashboard';
$headContent = '
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  /* Modern Dashboard Styles */
      body { font-family: Arial, sans-serif; background: #f6f8fa; }

  .dashboard {
    max-width: 100%;
    background: #f7fafc;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(9, 61, 98, 0.25);
    padding: clamp(16px, 4vw, 32px);
    margin: 0 8px;
  }

  .dashboard-main {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
  }

  /* Dashboard Header */
  .dashboard-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: clamp(1rem, 3vw, 2rem);
    padding-bottom: 1rem;
    border-bottom: 2px solid #e2e8f0;
  }

  .dashboard-topbar h1 {
    font-size: 1.875rem;
    font-weight: 600;
    color: #1a202c;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .dashboard-topbar h1::before {

    font-size: 1.5rem;
  }

  .dashboard-topbar .form-month {
    background: #edf2f7;
    padding: clamp(12px, 2vw, 20px);
    text-align: left;
    color: #4a5568;
    font-weight: 500;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .dashboard-topbar .form-month select,
  .dashboard-topbar .form-month input {
    min-width: 80px;
    max-width: 120px;
    flex: 1;
  }

  .dashboard-topbar .form-month button {
    white-space: nowrap;
  }

  /* Section Headers */
  .dashboard-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e2e8f0;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .dashboard-section-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  /* Two Column Layout for charts */
  .dashboard-charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 550px), 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
  }

  /* Three Column Layout for revenue stats */
  .dashboard-revenue-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
  }

  /* Info Grid */
  .dashboard-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 500px), 1fr));
    gap: 1.5rem;
  }

  /* Additional spacing */
  .dashboard-spacer {
    margin-top: 2.5rem;
    margin-bottom: 1.5rem;
  }

  /* Stat Cards */
  .dashboard-stats-grid {
    display: grid;
    /* Force 3 cards per row on desktop */
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
    align-items: stretch;
  }

  .dashboard-stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .dashboard-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
  }

  .dashboard-stat-card small {
    color: #718096;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.025em;
  }

  .dashboard-stat-card strong {
    display: block;
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-top: 0.5rem;
  }

  /* Chart Sections */
  .dashboard-chart-section {
    background: white;
    border-radius: 1rem;
    padding: clamp(1rem, 3vw, 2rem);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(226, 232, 240, 0.7);
    margin-bottom: clamp(1.5rem, 4vw, 2.5rem);
    position: relative;
    overflow: hidden;
  }

  .dashboard-chart-section::before {

    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #2563eb);
    opacity: 0.8;
  }

  .dashboard-chart-section h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f5f9;
  }

  .dashboard-chart-section h3::before {
    font-size: 1.375rem;
  }

  /* Forms */
  .dashboard form {
    margin-bottom: 2rem;
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
    background: #f8fafc;
    padding: 1rem;
    border-radius: 0.75rem;
  }

  .dashboard select,
  .dashboard input[type=number] {
    padding: 0.75rem 1.25rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    background: white;
    font-size: 0.875rem;
    color: #1e293b;
    min-width: 120px;
    transition: all 0.3s ease;
    font-weight: 500;
  }

  .dashboard select:hover,
  .dashboard input[type=number]:hover {
    border-color: #94a3b8;
  }

  .dashboard select:focus,
  .dashboard input[type=number]:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
  }

  .dashboard button {
    background: linear-gradient(to right, #2563eb, #3b82f6);
    color: white;
    padding: 0.75rem 1.75rem;
    border-radius: 0.75rem;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
  }

  .dashboard button:hover {
    background: linear-gradient(to right, #1d4ed8, #2563eb);
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);
  }

  /* Table Container */
  .table-container {
    max-height: 400px;
    overflow-y: auto;
  }

  /* Tables */
  .dashboard table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(226, 232, 240, 0.7);
  }

  .dashboard th {
    background: #f8fafc;
    padding: 1.25rem 1rem;
    font-weight: 600;
    color: #1e293b;
    border-bottom: 2px solid #e2e8f0;
    position: relative;
  }

  .dashboard th::after {

    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #3b82f6, transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .dashboard th:hover::after {
    opacity: 1;
  }

  .dashboard td {
    padding: 1.25rem 1rem;
    color: #334155;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }

  .dashboard tr:last-child td {
    border-bottom: none;
  }

  .dashboard tr {
    transition: all 0.2s ease;
  }

  .dashboard tr:hover td {
    background: #f1f5f9;
    color: #1e293b;
  }

  /* Action Buttons */
  .dashboard-btn {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(to right, #059669, #10b981);
    color: white;
    padding: 0.625rem 1.25rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    gap: 0.5rem;
    box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2);
  }

  .dashboard-btn:hover {
    background: linear-gradient(to right, #047857, #059669);
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(5, 150, 105, 0.3);
  }

  .dashboard-btn::before {
    content: "✓";
    font-size: 1rem;
    font-weight: bold;
  }

  /* Responsive Design */
  @media(max-width: 768px) {
    .dashboard {
      margin: 0;
      border-radius: 0;
    }

    .dashboard-topbar {
      flex-direction: column;
      gap: 1rem;
      text-align: center;
    }

    .dashboard-topbar h1 {
      font-size: 1.5rem;
    }

    .dashboard-topbar .form-month {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      flex-wrap: nowrap;
      overflow-x: auto;
      white-space: nowrap;
      padding: 10px 12px;
      max-width: 100%;
      box-sizing: border-box;
    }

    .dashboard-section-header {
      flex-direction: column;
      align-items: flex-start;
      text-align: left;
    }

    .dashboard-section-header h2 {
      font-size: 1.25rem;
    }

    .dashboard-section-header button {
      width: 100%;
    }

    .dashboard-stats-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 0.75rem;
    }

    @media(max-width: 480px) {
      .dashboard-stats-grid {
        grid-template-columns: 1fr;
      }
    }

    .dashboard-revenue-grid {
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .dashboard-info-grid {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    .dashboard-charts-grid {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    .dashboard form {
      flex-direction: column;
      align-items: stretch;
      gap: 0.75rem;
    }

    .dashboard button {
      width: 100%;
    }

    .table-container {
      margin: 0 -1rem;
      padding: 0 1rem;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .dashboard table {
      min-width: 100%;
      font-size: 0.85rem;
    }

    .dashboard td, 
    .dashboard th {
      padding: 0.75rem 0.5rem;
    }

    /* Smaller text on mobile */
    .dashboard-stat-card small {
      font-size: 0.75rem;
    }

    .dashboard-stat-card strong {
      font-size: 1.25rem;
    }

    /* Adjust chart sizes */
    .dashboard canvas {
      max-height: 250px !important;
    }

    /* Better touch targets */
    .dashboard button {
      min-height: 44px;
    }

    .dashboard-btn {
      padding: 6px 8px;
      font-size: 0.75rem;
    }
  }

  @media(max-width: 1024px) {
    .dashboard-stats-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .dashboard-revenue-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .dashboard-charts-grid {
      grid-template-columns: 1fr;
    }

    .dashboard-info-grid {
      grid-template-columns: 1fr;
    }

    .dashboard-chart-section canvas {
      max-height: 300px;
    }
  }

  @media(max-width: 1200px) {
    .dashboard-stats-grid {
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 1rem;
    }
  }

  /* Custom Scrollbar */
  .dashboard ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }

  .dashboard ::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
  }

  .dashboard ::-webkit-scrollbar-thumb {
    background: #94a3b8;
    border-radius: 4px;
  }

  .dashboard ::-webkit-scrollbar-thumb:hover {
    background: #64748b;
  }
  /* Tables trong info-grid */
  .info-grid table {
    width: 100%;
    border-collapse: collapse;
    background: white;
  }

  .info-grid th {
    background: linear-gradient(135deg, #093d62 0%, #0f5a8f 100%);
    color: white;
    padding: 14px 12px;
    font-weight: 600;
    text-align: left;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
    border: none;
  }

  .info-grid td {
    padding: 14px 12px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.9rem;
    color: #334155;
    transition: background-color 0.2s ease;
  }

  .info-grid tr:hover td {
    background-color: #f0f7ff;
  }

  .info-grid tr:last-child td {
    border-bottom: none;
  }

  .info-grid tr td:first-child {
    font-weight: 500;
    color: #1e293b;
  }

  /* Empty state */
  .info-grid tr td[colspan] {
    text-align: center;
    color: #94a3b8;
    font-style: italic;
    padding: 24px 12px;
  }

  /* Amount column */
  .info-grid tr td:nth-child(3) {
    font-weight: 600;
    color: #2e7d32;
  }

  /* Action button */
  .dashboard-btn {
    display: inline-block;
    background: linear-gradient(to right, #059669, #10b981);
    color: white;
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    white-space: nowrap;
  }

  .dashboard-btn:hover {
    background: linear-gradient(to right, #047857, #059669);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
  }

  .dashboard-btn:active {
    transform: translateY(0);
  }

  .dashboard-btn::before {
    content: "✓ ";
    margin-right: 4px;
  }

  /* Responsive tables */
  @media(max-width: 768px) {
    .info-grid th,
    .info-grid td {
      padding: 10px 8px;
      font-size: 0.85rem;
    }

    .dashboard-btn {
      padding: 6px 10px;
      font-size: 0.8rem;
    }
  }</style>
';
ob_start();
?>
<!-- <div class="sidebar">
  <h2>🏠 iTro Admin</h2>
  <a href="?controller=dashboard">📊 Dashboard</a>
  <a href="?controller=room">🛏️ Quản lý phòng</a>
  <a href="?controller=tenant">👤 Khách thuê</a>
  <a href="?controller=invoice">💰 Hóa đơn</a>
  <a href="?controller=config">⚙️ Cấu hình</a>
</div> -->
<div class="container">


  <div class="dashboard">
    <div class="dashboard-main">
      <!-- HEADER với bộ lọc -->
      <div class="dashboard-topbar">
        <h1>TỔNG QUAN NHÀ TRỌ</h1>
        <form method="get" class="form-month">
          <input type="hidden" name="controller" value="dashboard">
          <select name="month" style="padding:6px 8px;border-radius:6px;border:1px solid #e2e8f0;background:white;">
            <option value="">Chọn tháng</option>
            <?php for ($m = 1; $m <= 12; $m++): $mm = str_pad($m, 2, '0', STR_PAD_LEFT); ?>
              <option value="<?= $mm ?>" <?= $mm == $month ? 'selected' : '' ?>><?= $mm ?></option>
            <?php endfor; ?>
          </select>
          <input type="number" name="year" value="<?= htmlspecialchars($year) ?>" min="2020" max="2100" style="width:86px;padding:6px 8px;border-radius:6px;border:1px solid #e2e8f0;">
          <button type="submit" style="padding:6px 10px;border-radius:6px;background:#3b82f6;color:#fff;border:none;cursor:pointer;">Xem</button>
        </form>
      </div>

      <!-- SECTION 1: Tổng quan cơ bản -->
      <div class="dashboard-stats-grid">
        <div class="dashboard-stat-card">
          <small>Tổng khách thuê</small>
          <strong><?= isset($totalCustomersCount) ? number_format($totalCustomersCount) : '-' ?></strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Phòng còn trống</small>
          <strong><?= isset($vacantRoomsCount) ? number_format($vacantRoomsCount) : '-' ?></strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Khách mới (7 ngày)</small>
          <strong><?= count($newCustomers) ?></strong>
        </div>
      </div>

      <!-- SECTION 2: Thống kê tiêu thụ -->
      <div class="dashboard-spacer">
        <div class="dashboard-section-header">
          <h2>THỐNG KÊ TIÊU THỤ</h2>
        </div>
      </div>

      <div class="dashboard-charts-grid">
        <div class="dashboard-chart-section">
          <h3>Thống kê điện</h3>
          <canvas id="electricityChart" height="200"></canvas>
        </div>
        <div class="dashboard-chart-section">
          <h3>Thống kê nước</h3>
          <canvas id="waterChart" height="200"></canvas>
        </div>
      </div>

      <div class="dashboard-stats-grid">
        <div class="dashboard-stat-card">
          <small>Tổng điện tiêu thụ</small>
          <strong><?= number_format($totalElectricityConsumption) ?> kWh</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Tổng nước tiêu thụ</small>
          <strong style="color:#1e7e34;"><?= number_format($totalWaterConsumption) ?> m³</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Hóa đơn chưa thanh toán</small>
          <strong><?= count($unpaidInvoices) ?></strong>
        </div>
      </div>

      <!-- SECTION 3: Thống kê doanh thu tháng -->
      <div class="dashboard-spacer">
        <div class="dashboard-section-header">
          <h2>Doanh thu tháng này</h2>
        </div>
      </div>

      <div class="dashboard-revenue-grid">
        <div class="dashboard-stat-card">
          <small>Doanh thu (Sau chiết khấu)</small>
          <strong style="color: #2e7d32;"><?= isset($monthlyRevenueStats['total_revenue']) ? number_format((int)$monthlyRevenueStats['total_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Doanh thu (Trước chiết khấu)</small>
          <strong><?= isset($monthlyRevenueStats['gross_revenue']) ? number_format((int)$monthlyRevenueStats['gross_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Tiền phòng</small>
          <strong><?= isset($monthlyRevenueStats['room_revenue']) ? number_format((int)$monthlyRevenueStats['room_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Tiền điện</small>
          <strong><?= isset($monthlyRevenueStats['electricity_revenue']) ? number_format((int)$monthlyRevenueStats['electricity_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Tiền nước</small>
          <strong style="color: #1e7e34;"><?= isset($monthlyRevenueStats['water_revenue']) ? number_format((int)$monthlyRevenueStats['water_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Phí dịch vụ</small>
          <strong><?= isset($monthlyRevenueStats['service_revenue']) ? number_format((int)$monthlyRevenueStats['service_revenue']) : '-' ?> đ</strong>
        </div>
      </div>

      <!-- Doanh thu theo phòng -->
      <?php if (!empty($monthlyRevenueByRoom)): ?>
      <div style="background: #fff; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; margin-top: 2rem; border: 1px solid #e2e8f0;">
        <h3 style="margin-top: 0; color: #093d62; margin-bottom: 1.5rem;">🏘️ Doanh thu theo phòng - Tháng <?= str_pad($statMonth, 2, '0', STR_PAD_LEFT) ?>/<?= $statYear ?></h3>
        <div style="overflow-x: auto;">
          <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
              <tr style="background: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 10px; text-align: left; font-weight: 600;">Phòng</th>
                <th style="padding: 10px; text-align: right; font-weight: 600;">Tiền phòng</th>
                <th style="padding: 10px; text-align: right; font-weight: 600;">Tiền điện</th>
                <th style="padding: 10px; text-align: right; font-weight: 600;">Tiền nước</th>
                <th style="padding: 10px; text-align: right; font-weight: 600;">Phí dịch vụ</th>
                <th style="padding: 10px; text-align: right; font-weight: 600;">Tổng</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($monthlyRevenueByRoom as $room): ?>
              <tr style="border-bottom: 1px solid #e2e8f0;">
                <td style="padding: 10px; font-weight: 500;"><?= htmlspecialchars($room['room']) ?></td>
                <td style="padding: 10px; text-align: right;"><?= number_format((int)($room['room_revenue'] ?? 0)) ?> đ</td>
                <td style="padding: 10px; text-align: right;"><?= number_format((int)($room['electricity_revenue'] ?? 0)) ?> đ</td>
                <td style="padding: 10px; text-align: right;"><?= number_format((int)($room['water_revenue'] ?? 0)) ?> đ</td>
                <td style="padding: 10px; text-align: right;"><?= number_format((int)($room['service_revenue'] ?? 0)) ?> đ</td>
                <td style="padding: 10px; text-align: right; font-weight: 600; color: #2e7d32;"><?= number_format((int)($room['total_revenue'] ?? 0)) ?> đ</td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php endif; ?>

      <!-- SECTION 4: Thống kê doanh thu năm -->
      <div class="dashboard-spacer">
        <div class="dashboard-section-header">
          <h2>📅 Doanh thu năm <?= $statYearOnly ?></h2>
          <a href="index.php?controller=revenue&action=monthly" style="text-decoration: none;">
            <button style="background: #093d62; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 500;">
              Xem chi tiết →
            </button>
          </a>
        </div>
      </div>

      <div class="dashboard-revenue-grid">
        <div class="dashboard-stat-card">
          <small>Tổng doanh thu (Sau chiết khấu)</small>
          <strong style="color: #2e7d32; font-size: 1.25rem;"><?= isset($yearlyRevenueStats['total_revenue']) ? number_format((int)$yearlyRevenueStats['total_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Tổng doanh thu (Trước chiết khấu)</small>
          <strong><?= isset($yearlyRevenueStats['gross_revenue']) ? number_format((int)$yearlyRevenueStats['gross_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Tiền phòng</small>
          <strong><?= isset($yearlyRevenueStats['room_revenue']) ? number_format((int)$yearlyRevenueStats['room_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Tiền điện</small>
          <strong><?= isset($yearlyRevenueStats['electricity_revenue']) ? number_format((int)$yearlyRevenueStats['electricity_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Tiền nước</small>
          <strong style="color: #1e7e34;"><?= isset($yearlyRevenueStats['water_revenue']) ? number_format((int)$yearlyRevenueStats['water_revenue']) : '-' ?> đ</strong>
        </div>
        <div class="dashboard-stat-card">
          <small>Phí dịch vụ</small>
          <strong><?= isset($yearlyRevenueStats['service_revenue']) ? number_format((int)$yearlyRevenueStats['service_revenue']) : '-' ?> đ</strong>
        </div>
      </div>

      <!-- SECTION 5: Chi tiết khách hàng và hóa đơn chưa thanh toán -->
      <div class="dashboard-spacer">
        <div class="dashboard-section-header">
          <h2>📋 Chi tiết và cảnh báo</h2>
        </div>
      </div>

      <div class="dashboard-info-grid">
        <!-- Khách thuê mới -->
        <div class="dashboard-chart-section">
          <h3>👤 Khách thuê mới (7 ngày qua)</h3>
          <div class="table-container">
            <table>
              <tr>
                <th>Tên</th>
                <th>Phòng</th>
                <th>Điện thoại</th>
                <th>Ngày tạo</th>
              </tr>
              <?php foreach ($newCustomers as $c): ?>
                <tr>
                  <td><?= htmlspecialchars($c['name']) ?></td>
                  <td><?= htmlspecialchars($c['room']) ?></td>
                  <td><?= htmlspecialchars($c['phone']) ?></td>
                  <td><?= htmlspecialchars($c['created_at']) ?></td>
                </tr>
              <?php endforeach; ?>
              <?php if (empty($newCustomers)): ?><tr>
                  <td colspan="4" style="text-align:center;">Không có khách mới</td>
                </tr><?php endif; ?>
            </table>
          </div>
        </div>

        <!-- Hóa đơn chưa thanh toán -->
        <div class="dashboard-chart-section">
          <h3>⚠️ Hóa đơn chưa thanh toán</h3>
          <div class="table-container">
            <table>
              <tr>
                <th>Phòng</th>
                <th>Tháng/Năm</th>
                <th>Số tiền</th>
                <th>Thao tác</th>
              </tr>
              <?php foreach ($unpaidInvoices as $h): ?>
                <tr>
                  <td><?= htmlspecialchars($h['room']) ?></td>
                  <td><?= htmlspecialchars($h['mmyy']) ?></td>
                  <td><?= number_format($h['total_discount']) ?> đ</td>
                  <td><a href="index.php?controller=invoice&action=mark_paid&id=<?= $h['id'] ?>" class="dashboard-btn" onclick="return confirm('Xác nhận thanh toán hóa đơn này?');">Thanh toán</a></td>
                </tr>
              <?php endforeach; ?>
              <?php if (empty($unpaidInvoices)): ?><tr>
                  <td colspan="4" style="text-align:center;">Không có hóa đơn</td>
                </tr><?php endif; ?>
            </table>
          </div>
        </div>
      </div>


      <!-- Doanh thu -->
      <!-- <div class="dashboard-chart-section">
        <h3>📈 Thống kê doanh thu</h3>
        <div style="display:flex;flex-wrap:wrap;gap:24px;">
          <div style="flex:1;min-width:300px;">
            <form method="get">
              <input type="hidden" name="controller" value="dashboard">
              <b>Theo tháng:</b>
              <select name="stat_month">
                <?php for ($m = 1; $m <= 12; $m++): $mm = str_pad($m, 2, '0', STR_PAD_LEFT); ?>
                  <option value="<?= $mm ?>" <?= $mm == $statMonth ? 'selected' : '' ?>><?= $mm ?></option>
                <?php endfor; ?>
              </select>
              <select name="stat_year">
                <?php for ($y = 2023; $y <= date('Y') + 1; $y++): ?>
                  <option value="<?= $y ?>" <?= $y == $statYear ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
              </select>
              <button>Xem</button>
            </form>
            <table>
              <tr>
                <th style="text-align: left;">Tổng doanh thu</th>
                <td><?= number_format($tongThu) ?> đ</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tiền phòng</th>
                <td><?= number_format($tienPhong) ?> đ</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tiền điện (e_total)</th>
                <td><?= number_format($thuDien) ?> đ</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tiền nước (w_total)</th>
                <td><?= number_format($thuNuoc) ?> đ</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tiền dịch vụ</th>
                <td><?= number_format($thuDichVu) ?> đ</td>
              </tr>
            </table>
          </div>
          <div style="flex:1;min-width:300px;">
            <form method="get">
              <input type="hidden" name="controller" value="dashboard">
              <b>Theo năm:</b>
              <select name="stat_year_only">
                <?php for ($y = 2023; $y <= date('Y') + 1; $y++): ?>
                  <option value="<?= $y ?>" <?= $y == $statYearOnly ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
              </select>
              <button>Xem</button>
            </form>
            <table>
              <tr>
                <th style="text-align: left;">Tổng doanh thu</th>
                <td><?= number_format($tongThuNam) ?> đ</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tiền phòng</th>
                <td><?= number_format($tienPhongNam) ?> đ</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tiền điện (e_total)</th>
                <td><?= number_format($thuDienNam) ?> đ</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tiền nước (w_total)</th>
                <td><?= number_format($thuNuocNam) ?> đ</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tiền dịch vụ</th>
                <td><?= number_format($thuDichVuNam) ?> đ</td>
              </tr>
              <tr style="border-top: 2px solid #e2e8f0; padding-top: 8px;">
                <th style="text-align: left;">Tổng điện tiêu thụ</th>
                <td><?= number_format($tongDienTieuThuNam) ?> kWh</td>
              </tr>
              <tr>
                <th style="text-align: left;">Tổng nước tiêu thụ</th>
                <td><?= number_format($tongNuocTieuThuNam) ?> m³</td>
              </tr>
            </table>
          </div>
        </div>

      </div> -->
    </div>
  </div>
  <script>
    const labels = <?= json_encode($labels) ?>;
    const electricityData = <?= json_encode($electricityData) ?>;
    const waterData = <?= json_encode($waterData) ?>;

    function createChart(ctx, label, data, color) {
      new Chart(ctx, {
        type: "bar",
        data: {
          labels,
          datasets: [{
            label,
            data,
            backgroundColor: color
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
    createChart(document.getElementById("electricityChart"), "Điện tiêu thụ (kWh)", electricityData, "#4299e1");
    createChart(document.getElementById("waterChart"), "Nước tiêu thụ (m³)", waterData, "#48bb78");

    // Biểu đồ doanh thu theo tháng
    const monthlyRevenueData = {
      labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
      datasets: [{
        label: 'Tổng doanh thu',
        data: <?= json_encode($monthlyRevenueData ?? []) ?>,
        borderColor: '#3b82f6',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        fill: true,
        tension: 0.4
      }, {
        label: 'Tiền phòng',
        data: <?= json_encode($monthlyRoomRevenueData ?? []) ?>,
        borderColor: '#10b981',
        backgroundColor: 'rgba(16, 185, 129, 0.1)',
        fill: true,
        tension: 0.4
      }, {
        label: 'Tiền điện nước',
        data: <?= json_encode($monthlyUtilityRevenueData ?? []) ?>,
        borderColor: '#f59e0b',
        backgroundColor: 'rgba(245, 158, 11, 0.1)',
        fill: true,
        tension: 0.4
      }]
    };

    new Chart(document.getElementById('monthlyRevenueChart'), {
      type: 'line',
      data: monthlyRevenueData,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  label += new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' đ';
                }
                return label;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
              }
            }
          }
        }
      }
    });

    // Biểu đồ doanh thu theo năm
    const yearlyRevenueData = {
      labels: <?= json_encode($yearLabels ?? []) ?>,
      datasets: [{
        label: 'Tổng doanh thu',
        data: <?= json_encode($yearlyRevenueData ?? []) ?>,
        borderColor: '#3b82f6',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        fill: true,
        tension: 0.4
      }, {
        label: 'Tiền phòng',
        data: <?= json_encode($yearlyRoomRevenueData ?? []) ?>,
        borderColor: '#10b981',
        backgroundColor: 'rgba(16, 185, 129, 0.1)',
        fill: true,
        tension: 0.4
      }, {
        label: 'Tiền điện nước',
        data: <?= json_encode($yearlyUtilityRevenueData ?? []) ?>,
        borderColor: '#f59e0b',
        backgroundColor: 'rgba(245, 158, 11, 0.1)',
        fill: true,
        tension: 0.4
      }]
    };

    new Chart(document.getElementById('yearlyRevenueChart'), {
      type: 'line',
      data: yearlyRevenueData,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  label += new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' đ';
                }
                return label;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
              }
            }
          }
        }
      }
    });
  </script>

  <?php
  $content = ob_get_clean();
  include __DIR__ . "/../layout.php";
  ?>