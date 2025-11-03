<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết hóa đơn</title>
        <link rel="shortcut icon" href="itro-logo-vuong.png" type="image/x-icon">

    <link rel="stylesheet" href="views/style.css">
</head>
<body>
<div class="container">
    <h2>Chi tiết hóa đơn phòng <?= htmlspecialchars($bill['room'] ?? '') ?></h2>
    <?php if ($bill): ?>
        <table>
            <tr><th>Tháng/Năm</th><td><?= htmlspecialchars($bill['mmyy']) ?></td></tr>
            <tr><th>Tiền phòng</th><td><?= number_format($bill['tien_phong']) ?> đ</td></tr>
            <tr><th>Số người</th><td><?= htmlspecialchars($bill['so_nguoi']) ?></td></tr>
            <tr><th>Tiền điện</th><td><?= $electric ? number_format($electric['total']) . ' đ' : 'Không có' ?></td></tr>
            <tr><th>Tiền nước</th><td><?= $water ? number_format($water['total']) . ' đ' : 'Không có' ?></td></tr>
            <tr><th>Phí dịch vụ khác</th><td><?= number_format($bill['addinfo']) ?></td></tr>
            <tr><th>Tổng tiền</th><td><b><?= number_format($bill['tong_tien']) ?> đ</b></td></tr>
                        <tr><th>Giảm giá</th><td><b><?= number_format($bill['disscount']) ?> đ</b></td></tr>
            <tr><th><b>Cần thanh toán</b></th><td><b><?= number_format($bill['total_disscounr']) ?> đ</b></td></tr>

            <tr><th>Trạng thái</th><td><?= htmlspecialchars($bill['status']) ?></td></tr>
        </table>
        <br>
        <a href="?action=history_search">Quay lại tra cứu</a>
    <?php else: ?>
        <div class="error-message">Không tìm thấy hóa đơn.</div>
        <a href="?action=history_search">Quay lại tra cứu</a>
    <?php endif; ?>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết hóa đơn</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>
<div class="container">
    <h2>Chi tiết hóa đơn phòng <?= htmlspecialchars($bill['room'] ?? '') ?></h2>
    <?php if ($bill): ?>
        <table>
            <tr><th>Tháng/Năm</th><td><?= htmlspecialchars($bill['mmyy']) ?></td></tr>
            <tr><th>Tiền phòng</th><td><?= number_format($bill['tien_phong']) ?> đ</td></tr>
            <tr><th>Số người</th><td><?= htmlspecialchars($bill['so_nguoi']) ?></td></tr>
            <tr><th>Tiền điện</th><td><?= $electric ? number_format($electric['total']) . ' đ' : 'Không có' ?></td></tr>
            <tr><th>Tiền nước</th><td><?= $water ? number_format($water['total']) . ' đ' : 'Không có' ?></td></tr>
            <tr><th>Phí dịch vụ khác</th><td><?= number_format($bill['addinfo']) ?></td></tr>
            <tr><th>Tổng tiền</th><td><b><?= number_format($bill['tong_tien']) ?> đ</b></td></tr>
            <tr><th>Trạng thái</th><td><?= htmlspecialchars($bill['status']) ?></td></tr>
        </table>
        <br>
        <a href="?action=history_search">Quay lại tra cứu</a>
    <?php else: ?>
        <div class="error-message">Không tìm thấy hóa đơn.</div>
        <a href="?action=history_search">Quay lại tra cứu</a>
    <?php endif; ?>
</div>
</body>
</html>
