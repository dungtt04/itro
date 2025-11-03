<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khai báo khách mới</title>
    <link rel="shortcut icon" href="itro-logo-vuong.png" type="image/x-icon">

    <link rel="stylesheet" href="views/style.css">
</head>
<body>
    <?php include 'views/partials/header.php'; ?>

<div class="container">
    <h2>Khai báo thông tin khách mới</h2>
    <form method="post">
        <label>Phòng:
            <select name="room" id="room-select" required>
                <option value="">-- Chọn phòng --</option>
                <?php if (!empty($rooms)) foreach ($rooms as $r): ?>
                    <option value="<?= htmlspecialchars($r['room_code']) ?>" data-roomid="<?= htmlspecialchars($r['id']) ?>">
                        <?= htmlspecialchars($r['room_code']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <input type="hidden" name="room_id" id="room-id-hidden">
        <label>Họ tên: <input type="text" name="name" required></label><br>
        <label>CCCD: <input type="text" name="cccd" required></label><br>
        <label>Ngày sinh: <input type="date" name="dob" required></label><br>
        <label>Ngày cấp CCCD: <input type="date" name="cccd_date" required></label><br>
        <label>Nơi cấp CCCD: <input type="text" name="cccd_place" required></label><br>
        <label>Địa chỉ thường trú: <input type="text" name="address" required></label><br>
        <label>Số điện thoại: <input type="text" name="phone" required></label><br>
        <button type="submit">Khai báo</button>
    </form>
</div>
<?php include 'views/partials/footer.php'; ?>

<script>
    const roomSelect = document.getElementById('room-select');
    const roomIdHidden = document.getElementById('room-id-hidden');
    roomSelect.addEventListener('change', function() {
        const selected = roomSelect.options[roomSelect.selectedIndex];
        roomIdHidden.value = selected.getAttribute('data-roomid') || '';
    });
</script>

</body>
</html>
