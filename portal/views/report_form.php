<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo sự cố</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>
<div class="container">
    <h2>Báo cáo sự cố thiết bị</h2>
    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="result-message">Đã gửi báo cáo sự cố thành công!</div>
    <?php endif; ?>
    <form method="post">
        <label>Phòng:
            <select name="room_id" required>
                <option value="">-- Chọn phòng --</option>
                <?php if (!empty($rooms)) foreach ($rooms as $r): ?>
                    <option value="<?= htmlspecialchars($r['id']) ?>"><?= htmlspecialchars($r['room_code']) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Thiết bị gặp sự cố:
            <input type="text" name="type" required placeholder="Ví dụ: Máy lạnh, Quạt, Đèn...">
        </label><br>
        <label>Chi tiết:
            <textarea name="detail" rows="3" style="width:100%" required></textarea>
        </label><br>
        <button type="submit">Gửi báo cáo</button>
    </form>
</div>
</body>
</html>
