<?php
$title = 'Khai báo khách mới';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f0f4f8; color: #333; }
    .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    label { display: block; margin-top: 12px; font-weight: 500; color: #093d62; }
    input[type=text], input[type=date], select { width: 100%; padding: 8px; border: 1px solid #bfc7d1; border-radius: 6px; font-size: 15px; margin-top: 4px; }
    button { margin-top: 18px; width: 100%; background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 10px; font-size: 16px; font-weight: 500; cursor: pointer; }
    .error { color: #d93025; background: #fff0f0; border: 1.5px solid #f8d7da; border-radius: 6px; padding: 10px; margin-bottom: 10px; text-align: center; }
    .back-link { display: block; margin-bottom: 18px; color: #093d62; text-decoration: none; font-weight: 500; }
</style>';
ob_start();
?>
<div class="container">
    <a href="index.php?controller=customer&action=list" class="back-link">&larr; Quay lại danh sách khách thuê</a>
    <h2>Khai báo khách mới</h2>
    <?php if (!empty($error)): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <?php $prefillRoom = $_GET['room'] ?? ''; ?>
    <form method="post" action="index.php?controller=customer&action=add">
        <label>Phòng số</label>
        <select name="room" required>
            <option value="">-- Chọn phòng --</option>
            <?php foreach($roomList as $r): ?>
                <option value="<?= htmlspecialchars($r['room_code']) ?>" <?= $prefillRoom && $prefillRoom == $r['room_code'] ? 'selected' : '' ?>><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Họ tên</label>
        <input type="text" name="name" required>
        <label>Số CCCD</label>
        <input type="text" name="cccd" required>
        <label>Ngày sinh</label>
        <input type="date" name="dob" required>
        <label>Ngày cấp CCCD</label>
        <input type="date" name="cccd_date" required>
        <label>Nơi cấp CCCD</label>
        <input type="text" name="cccd_place" required>
        <label>Nơi thường trú</label>
        <input type="text" name="address" required>
        <label>Số điện thoại</label>
        <input type="text" name="phone" required>
        <button type="submit">Lưu khách thuê</button>
    </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
