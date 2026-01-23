<?php
$title = 'So sánh doanh thu qua các năm';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .revenue-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    .revenue-header { margin-bottom: 30px; }
    .revenue-header h1 { color: #093d62; margin: 0 0 20px 0; }
    .table-container { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
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
        <h1>So sánh doanh thu qua các năm</h1>
    </div>

    <div class="tabs">
        <a href="index.php?controller=revenue&action=monthly" class="tab">Theo Tháng</a>
        <a href="index.php?controller=revenue&action=yearly" class="tab">Theo Năm</a>
        <div class="tab active">So sánh</div>
    </div>

    <?php if (!empty($yearlyAllStats)): ?>
    <div class="table-container">
        <h3 style="padding: 20px 15px 0 15px; margin: 0 0 10px 0; color: #093d62;">📊 Bảng so sánh doanh thu tất cả các năm</h3>
        <table>
            <thead>
                <tr>
                    <th>Năm</th>
                    <th class="text-right table-mobile-hidden">Tiền phòng</th>
                    <th class="text-right table-mobile-hidden">Tiền điện</th>
                    <th class="text-right table-mobile-hidden">Tiền nước</th>
                    <th class="text-right table-mobile-hidden">Phí dịch vụ</th>
                    <th class="text-right">Tổng trước giảm</th>
                    <th class="text-right">Tổng doanh thu</th>
                    <th class="text-right table-mobile-hidden">Số hóa đơn</th>
                    <th class="text-right table-mobile-hidden">DT/HĐ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalAllYears = 0;
                $totalRoomAllYears = 0;
                $totalElecAllYears = 0;
                $totalWaterAllYears = 0;
                $totalServiceAllYears = 0;
                $totalGrossAllYears = 0;
                $totalInvoicesAllYears = 0;
                
                foreach ($yearlyAllStats as $stat): 
                    $totalAllYears += (int)($stat['total_revenue'] ?? 0);
                    $totalRoomAllYears += (int)($stat['room_revenue'] ?? 0);
                    $totalElecAllYears += (int)($stat['electricity_revenue'] ?? 0);
                    $totalWaterAllYears += (int)($stat['water_revenue'] ?? 0);
                    $totalServiceAllYears += (int)($stat['service_revenue'] ?? 0);
                    $totalGrossAllYears += (int)($stat['gross_revenue'] ?? 0);
                    $totalInvoicesAllYears += (int)($stat['invoice_count'] ?? 0);
                    
                    $avgPerInvoice = ($stat['invoice_count'] ?? 0) > 0 ? ((int)($stat['total_revenue'] ?? 0)) / ((int)($stat['invoice_count'] ?? 0)) : 0;
                ?>
                <tr>
                    <td><strong><?= $stat['year'] ?></strong></td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)($stat['room_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)($stat['electricity_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)($stat['water_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)($stat['service_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right"><?= number_format((int)($stat['gross_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right text-success"><?= number_format((int)($stat['total_revenue'] ?? 0)) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= (int)($stat['invoice_count'] ?? 0) ?></td>
                    <td class="text-right table-mobile-hidden"><?= number_format((int)$avgPerInvoice) ?> đ</td>
                </tr>
                <?php endforeach; ?>
                <tr style="background: #f1f5f9; font-weight: 600; border-top: 2px solid #e2e8f0;">
                    <td><strong>Tổng cộng</strong></td>
                    <td class="text-right table-mobile-hidden"><?= number_format($totalRoomAllYears) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format($totalElecAllYears) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format($totalWaterAllYears) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= number_format($totalServiceAllYears) ?> đ</td>
                    <td class="text-right"><?= number_format($totalGrossAllYears) ?> đ</td>
                    <td class="text-right text-success"><?= number_format($totalAllYears) ?> đ</td>
                    <td class="text-right table-mobile-hidden"><?= $totalInvoicesAllYears ?></td>
                    <td class="text-right table-mobile-hidden"><?= number_format($totalInvoicesAllYears > 0 ? $totalAllYears / $totalInvoicesAllYears : 0) ?> đ</td>
                </tr>
            </tbody>
        </table>
        <div class="mobile-message">Truy cập hệ thống trên máy tính để xem đầy đủ thông tin</div>
    </div>
    <?php else: ?>
    <div style="background: white; padding: 40px; text-align: center; border-radius: 8px; color: #666;">
        <p>Không có dữ liệu doanh thu</p>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
