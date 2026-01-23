<?php
$title = 'Thêm phòng mới';
$headContent = '<style>
    .container { max-width: 400px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; margin-bottom: 1.5rem; }
    input[type=text], input[type=number] { width: 100%; padding: 10px; margin: 10px 0 18px 0; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; }
    button { width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    button:hover { background: #0c4c7d; }
    .error { color: #d93025; background: #fff0f0; border: 1.5px solid #f8d7da; border-radius: 6px; padding: 10px; margin-bottom: 10px; text-align: center; }
    .back-link { display: block; margin-bottom: 18px; color: #093d62; text-decoration: none; font-weight: 500; }
    .divider { margin: 2rem 0; text-align: center; position: relative; }
    .divider::before { content: ""; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #e2e8f0; }
    .divider span { position: relative; background: #fff; padding: 0 1rem; color: #64748b; font-size: 0.875rem; }
    .hint { font-size: 0.875rem; color: #64748b; margin: -0.75rem 0 1rem; }
    .form-group { margin-bottom: 1rem; }
    .form-title { font-size: 1.125rem; color: #1e293b; margin-bottom: 1rem; }
</style>';
ob_start();
?>
<div class="container">
    <a href="index.php?controller=room&action=list" class="back-link">&larr; Quay lại danh sách phòng</a>
    <h2>Thêm phòng</h2>
    <?php if (!empty($error)): ?><div class="error"><?= $error ?></div><?php endif; ?>
    
    <div class="form-group">
        <div class="form-title">Thêm một phòng</div>
        <form method="post">
            <input type="text" name="room_code" placeholder="Mã phòng" required>
            <input type="text" name="description" placeholder="Mô tả (tuỳ chọn)">
            <button type="submit" name="action_type" value="single">Thêm phòng</button>
        </form>
    </div>

    <div class="divider"><span>HOẶC</span></div>

    <div class="form-group">
        <div class="form-title">Tạo nhiều phòng</div>
        <form method="post">
            <input type="number" name="quantity" placeholder="Số lượng phòng cần tạo" required min="1" max="50">
            <div class="hint">Hệ thống sẽ tự động tạo mã phòng tăng dần từ mã phòng lớn nhất hiện tại</div>
            <button type="submit" name="action_type" value="bulk" style="background: #047857">Tạo hàng loạt</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
