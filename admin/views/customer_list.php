<?php
$title = 'Quản lý khách thuê';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 100%; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    h2 { text-align: center; color: #093d62; }
    table { width: 100%; border-collapse: collapse; margin-top: 24px; }
    th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
    th { background: #e3eafc; color: #093d62; }
    tr:nth-child(even) { background: #f8fafc; }
    .add-btn { display: inline-block; background: #093d62; color: #fff; padding: 8px 18px; border-radius: 6px; text-decoration: none; font-weight: 500; margin-bottom: 18px; }
    .filter-form { margin-bottom: 18px; }
    .filter-form select { padding: 6px 12px; border-radius: 5px; border: 1px solid #bfc7d1; font-size: 15px; }
    .action-btn { display: inline-block; background: #093d62; color: #fff; padding: 6px 14px; border-radius: 5px; text-decoration: none; font-size: 14px; margin-right: 6px; transition: background 0.2s, color 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px #093d6240; border: none; cursor: pointer; }
    .action-btn:hover, .action-btn:focus { background: #1e7e34; color: #fff; box-shadow: 0 4px 16px #093d6240; }
    // .print-tamtru-btn {
    //     display: inline-block;
    //     background: #007bff;
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
    @media (max-width: 700px) {
        table, thead, tbody, th, td, tr { display: block; }
        thead { display: none; }
        tr { margin-bottom: 18px; border: 1px solid #bfc7d1; border-radius: 8px; background: #fff; box-shadow: 0 2px 8px #093d6240; }
        td { border: none; border-bottom: 1px solid #eee; position: relative; padding-left: 48%; min-height: 38px; }
        td:before { position: absolute; left: 12px; top: 8px; width: 44%; white-space: nowrap; font-weight: bold; color: #093d62; }
        td[data-label]:before { content: attr(data-label); }
        .detail-row { display: none; }
        .show-detail .detail-row { display: block; }
        /* Thêm CSS cho chi tiết khách thuê trên mobile */
        .detail-row td {
            background: #f8fafc;
            border-radius: 0 0 8px 8px;
            box-shadow: none;
            padding: 16px 12px 12px 12px;
        }
        .detail-row b {
            color: #093d62;
            font-size: 15px;
        }
        .detail-row .acton {
            margin-top: 14px !important;
            text-align: right;
            margin-right: 0 !important;
            margin-bottom: 0 !important;
        }
        .detail-row .action-btn {
            margin: 4px 2px;
            padding: 7px 10px;
            font-size: 14px;
        }
    }
</style>';
ob_start();
// Lấy danh sách phòng cho bộ lọc
require_once __DIR__ . '/../models/RoomModel.php';
$roomList = RoomModel::getAll();
$selectedRoom = $_GET['room'] ?? '';
$recordsPerPage = $_GET['records'] ?? 10; // Số lượng bản ghi trên mỗi trang, mặc định là 10
$currentPage = $_GET['page'] ?? 1; // Trang hiện tại, mặc định là 1

if ($recordsPerPage === 'all') {
    $paginatedCustomers = $customers; // Hiển thị tất cả bản ghi
    $totalPages = 1; // Chỉ có một trang
} else {
    $recordsPerPage = (int)$recordsPerPage;
    $totalRecords = count($customers); // Tổng số bản ghi
    $totalPages = ceil($totalRecords / $recordsPerPage); // Tổng số trang

    // Lấy danh sách khách thuê theo trang
    $startIndex = ($currentPage - 1) * $recordsPerPage;
    $paginatedCustomers = array_slice($customers, $startIndex, $recordsPerPage);
}
?>
<div class="container">
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div id="success-toast" style="position:fixed;top:32px;right:32px;z-index:9999;background:#1e7e34;color:#fff;padding:14px 28px;border-radius:8px;box-shadow:0 2px 12px #093d6240;font-size:16px;animation:fadeIn 0.5s;">
            <?= $_SESSION['success_message'];
            unset($_SESSION['success_message']); ?>
        </div>
        <script>
            setTimeout(function() {
                var toast = document.getElementById('success-toast');
                if (toast) toast.style.display = 'none';
            }, 3500);
        </script>
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }
        </style>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error_message'])): ?>
        <div id="success-toast" style="position:fixed;top:32px;right:32px;z-index:9999;background:#1e7e34;color:#fff;padding:14px 28px;border-radius:8px;box-shadow:0 2px 12px #093d6240;font-size:16px;animation:fadeIn 0.5s;">
            <?= $_SESSION['error_message'];
            unset($_SESSION['error_message']); ?>
        </div>
        <script>
            setTimeout(function() {
                var toast = document.getElementById('success-toast');
                if (toast) toast.style.display = 'none';
            }, 3500);
        </script>
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }
        </style>
    <?php endif; ?>
    <h2>Quản lý khách thuê</h2>
    <form method="get" class="filter-form">
        <input type="hidden" name="controller" value="customer">
        <input type="hidden" name="action" value="list">
        <label for="room">Lọc theo phòng:</label>
        <select name="room" id="room" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <?php foreach ($roomList as $r): ?>
                <option value="<?= htmlspecialchars($r['room_code']) ?>" <?= $selectedRoom == $r['room_code'] ? 'selected' : '' ?>><?= htmlspecialchars($r['room_code']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="sort">Sắp xếp theo:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="room" <?= ($_GET['sort'] ?? '') == 'room' ? 'selected' : '' ?>>Phòng</option>
            <option value="name" <?= ($_GET['sort'] ?? '') == 'name' ? 'selected' : '' ?>>Tên</option>
        </select>

        <select name="order" id="order" onchange="this.form.submit()">
            <option value="ASC" <?= ($_GET['order'] ?? '') == 'ASC' ? 'selected' : '' ?>>Tăng dần (A–Z)</option>
            <option value="DESC" <?= ($_GET['order'] ?? '') == 'DESC' ? 'selected' : '' ?>>Giảm dần (Z–A)</option>
        </select>

        <label for="records">Hiển thị:</label>
        <select name="records" id="records" onchange="this.form.submit()">
            <option value="5" <?= $recordsPerPage == 5 ? 'selected' : '' ?>>5</option>
            <option value="10" <?= $recordsPerPage == 10 ? 'selected' : '' ?>>10</option>
            <option value="15" <?= $recordsPerPage == 15 ? 'selected' : '' ?>>15</option>
            <option value="20" <?= $recordsPerPage == 20 ? 'selected' : '' ?>>20</option>
            <option value="all" <?= $recordsPerPage === 'all' ? 'selected' : '' ?>>Tất cả</option>
        </select>
    </form>
    <a href="index.php?controller=customer&action=add" class="add-btn">+ Khai báo khách mới</a>
    <a href="index.php?controller=customer&action=list_tra_phong" class="add-btn">Khách trả phòng</a>
    <a href="#" onclick="printCustomerList();return false;" class="add-btn" style="background:#1e7e34;">In danh sách</a>
    <form id="bulkForm" method="post" action="index.php?controller=customer&action=print_ct01_bulk" style="display:inline;">
        <button type="submit" class="add-btn" style="background:#093d62;">In CT01</button>
    </form>

    <table>
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>Phòng</th>
                <th>Họ tên</th>
                <th>Ngày sinh</th>
                <th>Số CCCD</th>
                <th class="desktop-only">Ngày cấp</th>
                <th class="desktop-only">Nơi cấp</th>
                <th class="desktop-only">Nơi cư trú</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paginatedCustomers as $c): ?>
                <?php if (!$selectedRoom || $c['room'] == $selectedRoom): ?>
                    <?php if (isset($c['status']) && $c['status'] === 'Trả phòng') continue; ?>
                    <tr class="main-row">
                        <td style="text-align: center;" data-label="Chọn"><input type="checkbox" name="ids[]" value="<?= $c['id'] ?>" form="bulkForm"></td>
                        <td style="text-align: center;" data-label="Phòng"><?= htmlspecialchars($c['room']) ?></td>
                        <td data-label="Họ tên"><?= htmlspecialchars($c['name']) ?></td>
                        <td style="text-align: center;" data-label="Ngày sinh">
                            <?php $dob = $c['dob'] ? date('d/m/Y', strtotime($c['dob'])) : '';
                            echo htmlspecialchars($dob); ?>
                        </td>
                        <td style="text-align:center;" data-label="Số CCCD"><?= htmlspecialchars($c['cccd']) ?></td>
                        <td style="text-align:center;" class="desktop-only" data-label="Ngày cấp">
                            <?php $cccd_date = $c['cccd_date'] ? date('d/m/Y', strtotime($c['cccd_date'])) : '';
                            echo htmlspecialchars($cccd_date); ?>
                        </td>
                        <td style="text-align:center;" class="desktop-only" data-label="Nơi cấp"><?= htmlspecialchars($c['cccd_place']) ?></td>
                        <td class="desktop-only" data-label="Nơi cư trú"><?= htmlspecialchars($c['address']) ?></td>
                        <td data-label="Thao tác">
                            <button class="action-btn" onclick="toggleDetail(this)">Xem chi tiết</button>
                            <button class="action-btn" style="background:#ffc107;color:#093d62;" onclick="showEditForm(this, <?= $c['id'] ?>);return false;">Sửa</button>
                        </td>
                    </tr>
                    <tr class="detail-row" style="display:none;">
                        <td colspan="9">
                            <div style="padding:10px 0 0 0;">
                                <b>Ngày cấp:</b> <?= htmlspecialchars($cccd_date) ?><br>
                                <b>Nơi cấp:</b> <?= htmlspecialchars($c['cccd_place']) ?><br>
                                <b>Đồng ý chia sẻ dữ liệu:</b> <?php if ($c['policy_status'] === 'accept') echo "Đồng ý"; else echo "Chưa đồng ý"; ?><br>
                                <b>Thường trú:</b> <?= htmlspecialchars($c['address']) ?><br>
                                <b>SĐT:</b> <?= htmlspecialchars($c['phone']) ?><br>
                                <div class="acton" style="margin-top:10px; text-align:right; margin-right: 20px; margin-bottom: 10px;">
                                    <a href="index.php?controller=customer&action=tra_phong&id=<?= $c['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn trả phòng khách thuê này?');" class="action-btn" style="background:#d93025;color:white; text-decoration:none; margin:5px 5px; border-radius: 2px; padding:5px 5px;">Trả phòng</a>
                                    <?php if ($c['type_of_tenant'] === 'Chính'): ?>
                                        <!-- <a href="index.php?controller=customer&action=edit&id<?= $c['id'] ?>" class="action-btn" style="background:#1e7e34; color:white; text-decoration:none; margin:5px 5px; border-radius: 2px; padding:5px 5px;">Sửa</a> -->
                                        <a href="index.php?controller=customer&action=contract&id=<?= $c['id'] ?>" target="_blank" class="action-btn" style="background:#093d62; color:white; text-decoration:none; margin:5px 5px; border-radius: 2px; padding:5px 5px;">In hợp đồng</a>
                                    <?php endif; ?>
                                    <a href="index.php?controller=customer&action=print_ct01&id=<?= $c['id'] ?>" target="_blank" class="action-btn" style="background:#093d62; color:white; text-decoration:none; margin:5px 5px; border-radius: 2px; padding:5px 5px;">In CT01</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- Form sửa khách thuê, ẩn mặc định -->
                    <tr class="edit-row" id="edit-row-<?= $c['id'] ?>" style="display:none;">
                        <td colspan="9">
                            <form method="post" action="index.php?controller=customer&action=edit&id=<?= $c['id'] ?>" class="edit-customer-form" style="background:#f8fafc;padding:18px 12px;border-radius:8px;box-shadow:0 2px 8px #093d6240;">
                                <div style="display:flex;flex-wrap:wrap;gap:18px;">
                                    <div style="flex:1 1 180px;">
                                        <label>Họ tên:<br>
                                            <input type="text" name="name" value="<?= htmlspecialchars($c['name']) ?>" required style="width:100%;padding:6px;">
                                        </label>
                                    </div>
                                    <div style="flex:1 1 120px;">
                                        <label>Ngày sinh:<br>
                                            <input type="date" name="dob" value="<?= htmlspecialchars($c['dob']) ?>" style="width:100%;padding:6px;">
                                        </label>
                                    </div>
                                    <div style="flex:1 1 120px;">
                                        <label>Số CCCD:<br>
                                            <input type="text" name="cccd" value="<?= htmlspecialchars($c['cccd']) ?>" style="width:100%;padding:6px;">
                                        </label>
                                    </div>
                                    <div style="flex:1 1 120px;">
                                        <label>Ngày cấp:<br>
                                            <input type="date" name="cccd_date" value="<?= htmlspecialchars($c['cccd_date']) ?>" style="width:100%;padding:6px;">
                                        </label>
                                    </div>
                                    <div style="flex:1 1 120px;">
                                        <label>Nơi cấp:<br>
                                            <input type="text" name="cccd_place" value="<?= htmlspecialchars($c['cccd_place']) ?>" style="width:100%;padding:6px;">
                                        </label>
                                    </div>
                                    <div style="flex:2 1 220px;">
                                        <label>Nơi cư trú:<br>
                                            <input type="text" name="address" value="<?= htmlspecialchars($c['address']) ?>" style="width:100%;padding:6px;">
                                        </label>
                                    </div>
                                    <div style="flex:1 1 120px;">
                                        <label>SĐT:<br>
                                            <input type="text" name="phone" value="<?= htmlspecialchars($c['phone']) ?>" style="width:100%;padding:6px;">
                                        </label>
                                    </div>
                                    <div style="flex:1 1 140px;">
                                        <label>Loại khách:<br>
                                            <select name="type_of_tenant" style="width:100%;padding:6px;">
                                                <option value="Chính" <?= $c['type_of_tenant'] === 'Chính' ? 'selected' : '' ?>>Chính</option>
                                                <option value="Phụ" <?= $c['type_of_tenant'] === 'Phụ' ? 'selected' : '' ?>>Phụ</option>
                                            </select>
                                        </label>
                                    </div>

                                </div>
                                <div style="margin-top:14px;text-align:right;">
                                    <button type="submit" class="action-btn" style="background:#1e7e34;">Lưu</button>
                                    <button type="button" class="action-btn" style="background:#bfc7d1;color:#093d62;" onclick="hideEditForm(<?= $c['id'] ?>)">Hủy</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($recordsPerPage !== 'all'): ?>
        <div style="text-align:right; margin-top:20px;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?controller=customer&action=list&records=<?= $recordsPerPage ?>&page=<?= $i ?>&sort=<?= $_GET['sort'] ?? 'room' ?>&order=<?= $_GET['order'] ?? 'ASC' ?>" class="action-btn" style="<?= $i == $currentPage ? 'background:#1e7e34;' : '' ?>"><?= $i ?></a>

            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>
<script>
    function toggleDetail(btn) {
        var mainRow = btn.closest('tr');
        var detailRow = mainRow.nextElementSibling;
        if (detailRow && detailRow.classList.contains('detail-row')) {
            if (detailRow.style.display === 'table-row' || detailRow.style.display === '') {
                detailRow.style.display = 'none';
                btn.textContent = 'Xem chi tiết';
            } else {
                detailRow.style.display = 'table-row';
                btn.textContent = 'Ẩn chi tiết';
            }
        }
    }

    function printCustomerList() {
        // Lấy bảng danh sách khách thuê (chỉ lấy các dòng chính, không lấy detail-row)
        var table = document.querySelector('.container table');
        var thead = table.tHead.cloneNode(true);
        // Xóa cột "Thao tác" và "SĐT" ở thead
        thead.rows[0].deleteCell(thead.rows[0].cells.length - 1); // Thao tác
        // giải thích 
        // Xóa cột "SĐT" ở thead
        // thead.rows[0].deleteCell(thead.rows[0].cells.length - 1); // SĐT

        var rows = table.querySelectorAll('tr.main-row');
        var style = `
            <style>
                body { font-family: Times New Roman, sans-serif; font-size: 14px; background: #fff; }
                h2 { text-align: center; color: black; }
                table { width: 100%; border-collapse: collapse; margin-top: 24px; }
                th, td { border: 1px solid #bfc7d1; padding: 8px 6px; text-align: left; font-size: 15px; }
                th { background: #e3eafc; color: black; text-align: center; }
                tr:nth-child(even) { background: #f8fafc; }
            </style>
        `;
        var html = '<div class="title"><b>NHÀ TRỌ CHÚ QUẢNG</b><p>Hộ gia đình: <b>Ông Tăng Tiến Quảng</b></p><p><b>Địa chỉ:</b> Đội 6, thôn Minh Thành, xã Lai Khê, TP Hải Phòng</p><p><b?>Điện thoại:</b> 0352.153.772</p> </div><h2>DANH SÁCH LƯU TRÚ</h2> <p style="text-align:center">Ngày xuất: ' + new Date().toLocaleDateString() + '</p> <table>' + thead.outerHTML + '<tbody>';

        rows.forEach(function(row) {
            var clone = row.cloneNode(true);
            // Xóa cột "Thao tác" và "SĐT" ở mỗi dòng
            clone.deleteCell(clone.cells.length - 1); // Thao tác
            // clone.deleteCell(clone.cells.length - 1); // SĐT
            html += clone.outerHTML;
        });
        html += '</tbody></table>';
        var printWindow = window.open('', '', 'width=1000,height=700');
        printWindow.document.write('<html><head><title>In danh sách khách thuê</title>' + style + '</head><body>' + html + '</body></html>');
        printWindow.document.close();
        printWindow.focus();
        setTimeout(function() {
            printWindow.print();
        }, 300);
    }

    function showEditForm(btn, id) {
        // Ẩn tất cả form sửa khác
        document.querySelectorAll('.edit-row').forEach(function(row) {
            row.style.display = 'none';
        });
        // Hiện form sửa của khách này
        var editRow = document.getElementById('edit-row-' + id);
        if (editRow) {
            editRow.style.display = '';
            // Cuộn tới form sửa
            editRow.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    }

    function hideEditForm(id) {
        var editRow = document.getElementById('edit-row-' + id);
        if (editRow) editRow.style.display = 'none';
    }

    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('input[name="ids[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }, this);
    });

    // Validate bulk form submission
    document.getElementById('bulkForm').addEventListener('submit', function(e) {
        var checkboxes = document.querySelectorAll('input[name="ids[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Vui lòng chọn khách thuê cần in');
            e.preventDefault();
            return false;
        }
    });
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>