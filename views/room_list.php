<?php
// <?php
$title = 'Quản lý phòng';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .add-form { margin-bottom: 18px; }
    .add-form input, .add-form textarea { padding: 7px; border-radius: 5px; border: 1px solid #bfc7d1; margin-right: 8px; }
    .add-form button { background: #093d62; color: #fff; border: none; border-radius: 6px; padding: 7px 18px; font-weight: 500; }
    .error { color: #d93025; background: #fff0f0; border: 1.5px solid #f8d7da; border-radius: 6px; padding: 10px; margin-bottom: 10px; text-align: center; }
    // .print-tamtru-btn {
    //     display: inline-block;
    //     background: #093D62;
    //     color: #fff;
    //     padding: 8px 18px;
    //     border-radius: 6px;
    //     text-decoration: none;
    //     font-weight: 500;
    //     margin-bottom: 18px;
    //     margin-left: 6px;
    //     border: none;
    //     cursor: pointer;
    //     transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    //     box-shadow: 0 2px 8px #093d6240;
    // }
    // .print-tamtru-btn:hover, .print-tamtru-btn:focus {
    //     background: #0056b3;
    //     color: #fff;
    //     box-shadow: 0 4px 16px #093d6240;
    // }
    /* Responsive cho mobile */
    @media (max-width: 700px) {
        .container {
            max-width: 100%;
            padding: 10px 2px;
            border-radius: 0;
            box-shadow: none;
        }
        table {
            border: none;
        }
        thead {
            display: none;
        }
        tr {
            display: block;
            margin-bottom: 18px;
            border: 1px solid #e3eafc;
            border-radius: 8px;
            background: #f8fafc;
            box-shadow: 0 1px 4px #093d6220;
            padding: 8px 0;
        }
        td {
            display: flex;
            align-items: center;
            border: none;
            border-bottom: 1px solid #e3eafc;
            position: relative;
            padding: 10px 8px 10px 40%;
            min-height: 38px;
            font-size: 15px;
            width: 100%;
            box-sizing: border-box;
        }
        td:last-child {
            border-bottom: none;
        }
        td:before {
            content: attr(data-label);
            position: absolute;
            left: 12px;
            top: 10px;
            width: 38%;
            min-width: 90px;
            font-weight: bold;
            color: #093d62;
            font-size: 14px;
            white-space: nowrap;
        }
        .add-form input, .add-form textarea {
            width: 100%;
            margin-bottom: 8px;
        }
        .add-form button {
            width: 100%;
        }
        .action-btn {
            display: block;
            width: 100%;
            margin: 6px 0;
            text-align: center;
        }


        /* Sửa thao tác thành mỗi nút 1 hàng */
        td[data-label="Thao tác"] > div {
            flex-direction: column !important;
            gap: 0 !important;
        }
        td[data-label="Thao tác"] .action-btn {
            margin: 6px 0 !important;
        }
    }
</style>';
ob_start();
?>
<div class="container">
    <h2>Quản lý phòng</h2>
    <form method="post" action="index.php?controller=room&action=add" class="add-form">
        <input type="text" name="room_code" placeholder="Mã phòng" required>
        <input type="text" name="description" placeholder="Mô tả (tuỳ chọn)">
        <button type="submit">Thêm phòng</button>
    </form>
    <?php if (!empty($error)): ?><div class="error"><?= $error ?></div><?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Mã phòng</th>
                <!-- <th>Mô tả</th> -->
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $r): ?>
                <tr>
                    <td data-label="Mã phòng"><?= htmlspecialchars($r['room_code']) ?></td>
                    <!-- <td data-label="Mô tả"><?= htmlspecialchars($r['description']) ?></td> -->
                    <td data-label="Trạng thái"><?= htmlspecialchars($r['status']) ?></td>
                    <td data-label="Thao tác">
                        <div style="display: flex; flex-direction: row; gap: 8px;">
                            <a href="index.php?controller=customer&action=list&room=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#093d62; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;">Khách thuê</a>
                            <a href="index.php?controller=room&action=electric_water&room=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#093d62; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;">Điện nước</a>
                            <a href="index.php?controller=invoice&action=list&room=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#093d62; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;">Hóa đơn</a>
                            <!-- <a href="index.php?controller=room&action=print_tam_tru&room_code=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#093d62; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;">In tờ khai CT01</a> -->
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';