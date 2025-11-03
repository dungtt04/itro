<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả khai báo</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>
    <?php include 'views/partials/header.php'; ?>

<div class="container">
    <h2>Kết quả khai báo khách mới</h2>
    <?php if ($success): ?>
        <div class="result-message">Đã lưu thông tin khách thành công!</div>
    <?php else: ?>
        <div class="error-message">Có lỗi xảy ra, vui lòng thử lại.</div>
    <?php endif; ?>
    <a href="?action=customer_create">Quay lại</a>
</div>
<?php include 'views/partials/footer.php'; ?>

</body>
</html>
