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
    
    .button-group {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-primary {
        background: #093d62;
        color: #fff;
    }
    
    .btn-success {
        background: #047857;
        color: #fff;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
    }

    .modal-content {
        position: relative;
        background: #fff;
        width: 90%;
        max-width: 500px;
        margin: 60px auto;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }

    .modal h3 {
        margin-top: 0;
        color: #1e293b;
    }

    .close {
        position: absolute;
        right: 24px;
        top: 24px;
        font-size: 24px;
        cursor: pointer;
        color: #64748b;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #1e293b;
        font-weight: 500;
    }

    .form-hint {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 4px;
    }
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
    
    <div class="button-group">
        <a href="#" class="btn btn-primary" onclick="showAddForm()">
            Thêm phòng
        </a>
        <a href="#" class="btn btn-success" onclick="showBulkModal()">
            Tạo nhiều phòng
        </a>
    </div>

    <?php if (!empty($error)): ?><div class="error"><?= $error ?></div><?php endif; ?>
    
    <!-- Modal thêm một phòng -->
    <div id="addRoomForm" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideAddForm()">&times;</span>
            <h3>Thêm phòng mới</h3>
            <form method="post" action="index.php?controller=room&action=add" class="add-form">
                <div class="form-group">
                    <label for="room_code">Mã phòng:</label>
                    <input type="text" id="room_code" name="room_code" required>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <input type="text" id="description" name="description" placeholder="Tuỳ chọn">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%">Thêm phòng</button>
            </form>
        </div>
    </div>

    <!-- Modal tạo nhiều phòng -->
    <div id="bulkCreateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideBulkModal()">&times;</span>
            <h3>Tạo nhiều phòng</h3>
            <form method="post" action="index.php?controller=room&action=add">
                <div class="form-group">
                    <label for="quantity">Số lượng phòng cần tạo:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="50" required>
                    <div class="form-hint">Hệ thống sẽ tự động tạo mã phòng tăng dần từ mã phòng lớn nhất hiện tại</div>
                </div>
                <input type="hidden" name="action_type" value="bulk">
                <button type="submit" class="btn btn-success" style="width:100%">Tạo phòng</button>
            </form>
        </div>
    </div>

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
                            <!-- <a href="index.php?controller=room&action=electric_water&room=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#093d62; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;">Điện nước</a> -->
                            <a href="index.php?controller=invoice&action=list&room=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#093d62; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;">Hóa đơn</a>
                            <a href="index.php?controller=room&action=print_tam_tru&room=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#093d62; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;">In CT01</a>

                            <?php
                                $statusNorm = strtolower(trim($r['status'] ?? ''));
                                $isVacant = $statusNorm === '' || in_array($statusNorm, ['còn trống','con trong','0','empty','available','vacant']);
                                if ($isVacant):
                            ?>
                                <a href="index.php?controller=room&action=rent&room=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#10b981; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;">Cho thuê</a>
                            <?php else: ?>
                                <a href="index.php?controller=room&action=vacate&room=<?= urlencode($r['room_code']) ?>" class="action-btn" style="background:#ef4444; color:white; text-decoration:none; border-radius: 2px; padding:5px 5px;" onclick="return confirm('Xác nhận trả phòng <?= htmlspecialchars($r['room_code']) ?>?');">Trả phòng</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
// Add JavaScript for modal functionality
?>
<script>
function showAddForm() {
    document.getElementById('addRoomForm').style.display = 'block';
}

function hideAddForm() {
    document.getElementById('addRoomForm').style.display = 'none';
}

function showBulkModal() {
    document.getElementById('bulkCreateModal').style.display = 'block';
}

function hideBulkModal() {
    document.getElementById('bulkCreateModal').style.display = 'none';
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = 'none';
    }
}

// Close modals when pressing Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.getElementById('addRoomForm').style.display = 'none';
        document.getElementById('bulkCreateModal').style.display = 'none';
    }
});
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';