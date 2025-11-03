<?php
$title = 'Thêm phòng mới';
$headContent = '<style>
    .container { max-width: 400px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    input[type=text] { width: 100%; padding: 10px; margin: 10px 0 18px 0; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; }
    button { width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    .error { color: #d93025; background: #fff0f0; border: 1.5px solid #f8d7da; border-radius: 6px; padding: 10px; margin-bottom: 10px; text-align: center; }
    .back-link { display: block; margin-bottom: 18px; color: #093d62; text-decoration: none; font-weight: 500; }
</style>';
ob_start();
?>
<div class="container">
    <a href="index.php?controller=room&action=list" class="back-link">&larr; Quay lại danh sách phòng</a>
    <h2>Thêm phòng mới</h2>
    <?php if (!empty($error)): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <input type="text" name="room_code" placeholder="Mã phòng" required autofocus>
        <input type="text" name="description" placeholder="Mô tả (tuỳ chọn)">
        <button type="submit">Thêm phòng</button>
    </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
