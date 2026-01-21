<?php
$title = 'Thống kê doanh thu theo năm';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .revenue-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    .revenue-header { margin-bottom: 30px; }
    .revenue-header h1 { color: #093d62; margin: 0 0 20px 0; }
    .filter-group { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .filter-group select, .filter-group input { padding: 8px 12px; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 14px; }
    .filter-group button { padding: 8px 16px; background: #093d62; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; }
    .filter-group button:hover { background: #1e7e34; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 30px; }
    .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #093d62; }
    .stat-card.success { border-left-color: #2e7d32; }
    .stat-card.warning { border-left-color: #f59e0b; }
    .stat-card.info { border-left-color: #3b82f6; }
    .stat-label { color: #666; font-size: 14px; margin-bottom: 5px; }
    .stat-value { font-size: 24px; font-weight: bold; color: #093d62; }
    .stat-card.success .stat-value { color: #2e7d32; }
    .stat-card.warning .stat-value { color: #f59e0b; }
    .stat-card.info .stat-value { color: #3b82f6; }
    .table-container { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f1f5f9; padding: 15px; text-align: left; font-weight: 600; color: #333; border-bottom: 2px solid #e2e8f0; }
    td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; }
    tr:hover { background: #f8fafc; }
    .text-right { text-align: right; }
    .text-success { color: #2e7d32; font-weight: 600; }
    .tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; }
    .tab { padding: 12px 20px; cursor: pointer; color: #666; border-bottom: 2px solid transparent; margin-bottom: -2px; font-weight: 500; }
    .tab.active { color: #093d62; border-bottom-color: #093d62; }
    .tab:hover { color: #093d62; }
    a { color: #093d62; text-decoration: none; }
    a:hover { text-decoration: underline; }
    
    /* Mobile: ẩn các cột không cần thiết */
    @media (max-width: 768px) {
        .table-mobile-hidden { display: none; }
        .mobile-message { display: block; background: #fff3cd; color: #856404; padding: 12px 15px; margin-top: 10px; border-radius: 6px; font-size: 13px; text-align: center; }
    }
    @media (min-width: 769px) {
        .mobile-message { display: none; }
    }
</style>';

ob_start();
?>

<div class="revenue-container">
    <div class="revenue-header">
        <h1>Thống kê doanh thu theo năm</h1>
    </div>

    <div class="tabs">
        <a href="index.php?controller=revenue&action=monthly" class="tab">Theo Tháng</a>
        <div class="tab active">Theo Năm</div>
        <a href="index.php?controller=revenue&action=comparison" class="tab">So sánh</a>
    </div>

    <div class="filter-group">
        <form method="get" action="index.php" style="display: flex; gap: 15px; align-items: flex-end;">
            <input type="hidden" name="controller" value="revenue">
            <input type="hidden" name="action" value="yearly">
            <div>
                <label style="display: block; font-size: 12px; color: #666; margin-bottom: 5px;">Năm</label>
                <select name="year">
                    <?php for ($y = 2023; $y <= date('Y'); $y++): ?>
                        <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <button type="submit">Xem thống kê</button>
        </form>
    </div>

    <?php if ($yearlyStats): ?>
    <div class="stats-grid">
        <div class="stat-card success">
            <div class="stat-label">Tổng doanh thu năm</div>
            <div class="stat-value"><?= number_format((int)($yearlyStats['total_revenue'] ?? 0)) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">đ</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Doanh thu trước giảm</div>
            <div class="stat-value"><?= number_format((int)($yearlyStats['gross_revenue'] ?? 0)) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">đ</div>
        </div>
        <div class="stat-card info">
            <div class="stat-label">Tiền phòng</div>
            <div class="stat-value"><?= number_format((int)($yearlyStats['room_revenue'] ?? 0)) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">đ</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tiền điện</div>
            <div class="stat-value"><?= number_format((int)($yearlyStats['electricity_revenue'] ?? 0)) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">đ</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tiền nước</div>
            <div class="stat-value"><?= number_format((int)($yearlyStats['water_revenue'] ?? 0)) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">đ</div>
        </div>
        <div class="stat-card warning">
            <div class="stat-label">Phí dịch vụ</div>
            <div class="stat-value"><?= number_format((int)($yearlyStats['service_revenue'] ?? 0)) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">đ</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Số hóa đơn</div>
            <div class="stat-value"><?= (int)($yearlyStats['invoice_count'] ?? 0) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">cái</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Số phòng</div>
            <div class="stat-value"><?= (int)($yearlyStats['total_rooms'] ?? 0) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">phòng</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Doanh thu trung bình</div>
            <div class="stat-value"><?= number_format((int)($yearlyStats['avg_revenue'] ?? 0)) ?></div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">đ/hóa đơn</div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($monthlyRevenueInYear)): ?>
    <div class="table-container">
        <h3 style="padding: 20px 15px 0 15px; margin: 0 0 10px 0; color: #093d62;">Doanh thu chi tiết theo tháng trong năm <?= $year ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th class="text-right table-mobile-hidden">Tiền phòng</th>
                    <th class="text-right table-mobile-hidden">Tiền điện</th>
                    <th class="text-right table-mobile-hidden">Tiền nước</th>
                    <th class="text-right table-mobile-hidden">Phí dịch vụ</th>
                    <th class="text-right">Tổng trước giảm</th>
                    <th class="text-right">Tổng doanh thu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthlyRevenueInYear as $monthData): ?>
                <tr>
                    <td><strong>Tháng <?= (int)$monthData['month'] ?></strong></td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)($monthData['room_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)($monthData['electricity_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)($monthData['water_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)($monthData['service_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right"><?= number_format((int)($monthData['gross_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right text-success"><?= number_format((int)($monthData['total_revenue'] ?? 0)) ?> đ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mobile-message">Truy cập hệ thống trên máy tính để xem đầy đủ thông tin</div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
