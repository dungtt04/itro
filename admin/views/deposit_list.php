<?php
$title = 'Quản lý đặt cọc';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1200px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; margin-bottom: 24px; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 12px 8px; text-align: left; font-size: 14px; }
    th { background: #e3eafc; color: #093d62; font-weight: 600; }
    tr:nth-child(even) { background: #f8fafc; }
    .add-btn { display: inline-block; background: #093d62; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500; margin-bottom: 20px; transition: background 0.2s; }
    .add-btn:hover { background: #1e7e34; }
    .action-btn { display: inline-block; background: #093d62; color: #fff; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-right: 4px; border: none; cursor: pointer; transition: background 0.2s; }
    .action-btn:hover { background: #1e7e34; }
    .action-btn.danger { background: #d32f2f; }
    .action-btn.danger:hover { background: #b71c1c; }
    .status-badge { display: inline-block; padding: 6px 10px; border-radius: 4px; font-size: 12px; font-weight: 500; line-height: 1.5; }
    .status-badge small { display: block; font-size: 11px; margin-top: 2px; margin-bottom: 2px; }
    .status-paid { background: #c8e6c9; color: #2e7d32; }
    .status-unpaid { background: #ffccbc; color: #d84315; }
    .status-refunded { background: #c8e6c9; color: #2e7d32; }
    .status-notrefunded { background: #ffcdd2; color: #c62828; }
    .text-center { text-align: center; }
    .empty-message { text-align: center; color: #666; padding: 40px 20px; }
    .amount { text-align: right; font-weight: 500; }
    @media (max-width: 900px) {
        .container { padding: 20px; }
        th, td { padding: 8px 4px; font-size: 12px; }
        .action-btn { padding: 4px 8px; font-size: 11px; }
    }
</style>';

ob_start();
?>

<div class="container">
    <h2>Quản lý Đặt Cọc</h2>
    
    <a href="index.php?controller=deposit&action=add" class="add-btn">+ Thêm đặt cọc mới</a>

    <?php if (empty($deposits)): ?>
        <div class="empty-message">
            <p>Không có bản ghi đặt cọc nào</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr style="text-align: center;">
                    <th>STT</th>
                    <th>Phòng</th>
                    <th>Họ tên khách hàng</th>
                    <th>Số tiền cọc</th>
                    <th>Trạng thái cọc</th>
                    <th>Trạng thái thuê phòng</th>
                    <th>Số tiền hoàn</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deposits as $index => $deposit): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($deposit['room_code'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($deposit['customer_name'] ?? $deposit['name'] ?? 'N/A') ?></td>
                        <td class="amount"><?= number_format($deposit['deposit_amount'], 0, ',', '.') ?> đ</td>
                        <td class="text-center">
                            <span class="status-badge <?= $deposit['deposit_status'] === 'Đã cọc' ? 'status-paid' : 'status-unpaid' ?>">
                                <?php if ($deposit['deposit_status'] === 'Đã cọc'): ?>
                                    Đã cọc (<?= $deposit['deposit_at'] ? date('d/m/Y', strtotime($deposit['deposit_at'])) : '-' ?>)
                                <?php else: ?>
                                    Chưa cọc
                                <?php endif; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if ($deposit['refund_status'] === 'Chưa trả phòng'): ?>
                                <span class="status-badge status-unpaid">Đang thuê</span>
                            <?php elseif ($deposit['refund_status'] === 'Đã hoàn'): ?>
                                <span class="status-badge status-paid">Đã hoàn (<?= $deposit['refund_at'] ? date('d/m/Y', strtotime($deposit['refund_at'])) : '-' ?>)</span>
                            <?php else: ?>
                                <span class="status-badge status-notrefunded">
                                    Không hoàn<br>
                                    <small><?= htmlspecialchars($deposit['refund_reason'] ?? '') ?></small><br>
                                    (<?= $deposit['refund_at'] ? date('d/m/Y', strtotime($deposit['refund_at'])) : '-' ?>)
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="amount"><?= $deposit['refund_amount'] ? number_format($deposit['refund_amount'], 0, ',', '.') . ' đ' : '-' ?></td>
                        <td style="white-space: nowrap;">
                            <?php if ($deposit['deposit_status'] === 'Chưa cọc'): ?>
                                <button class="action-btn" onclick="confirmPayment(<?= $deposit['id'] ?>)">Thanh toán</button>
                            <?php endif; ?>
                            
                            <?php if ($deposit['refund_status'] !== 'Đã hoàn' && $deposit['refund_status'] !== 'Không hoàn' && $deposit['deposit_status'] === 'Đã cọc'): ?>
                                <a href="index.php?controller=deposit&action=refund&id=<?= $deposit['id'] ?>" class="action-btn" title="Trả phòng/cọc">Trả phòng</a>
                            <?php endif; ?>
                            
                            <?php if ($deposit['refund_status'] === 'Đã hoàn' || $deposit['refund_status'] === 'Không hoàn'): ?>
                                <a href="index.php?controller=deposit&action=delete&id=<?= $deposit['id'] ?>" class="action-btn danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
function confirmPayment(depositId) {
    if (confirm('Bạn chắc chắn muốn thanh toán cọc?')) {
        window.location.href = 'index.php?controller=deposit&action=payment&id=' + depositId;
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
