<?php
// Block style view for electricity & water
$title = 'Danh sách điện nước các phòng';
$headContent = '<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; }
    .container { max-width: 1000px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
    .electricity-water { display: flex; flex-wrap: wrap; gap: 20px; }
    .month { width: calc(33.333% - 20px); background-color: #fff; border: 1px solid #ddd; border-radius: 6px; box-shadow: 0 2px 6px #093d6240; padding: 16px; box-sizing: border-box; margin-bottom: 10px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 8px; width: 25%; text-align: left; }
    th { background-color: #fff; }
    td {width:30px;}
    @media (max-width: 900px) {
        .month { width: calc(50% - 20px);
        table { width: 100%; }
    }
    @media (max-width: 600px) {
        .electricity-water { flex-direction: column; gap: 12px; }
        .month { width: 100%; min-width: 0; }
        table {  }
    }
    @media print {
        .h1{text-align: center; font-size: 24px; margin-bottom: 20px;}
        .menu-bar, .main-content .footer, footer, h2,.electricity-water, form, button[onclick^="printBangChiSo"] { display: none !important; }
        #print-table-view { display: block !important; }
        body { background: #fff !important; }
        .container {
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            width: 100% !important;
            max-width: 100% !important;
        }
    }
</style>';
require_once __DIR__ . '/../models/RoomModel.php';
require_once __DIR__ . '/../models/ElectricityModel.php';
require_once __DIR__ . '/../models/WaterModel.php';
// Lấy danh sách phòng và dữ liệu điện nước đã lọc từ controller
// $rooms, $electricity, $water đã được truyền vào
// Tạo map room_id => điện/nước mới nhất
$map_e = [];

foreach ($electricity as $e) {
    if (!isset($map_e[$e['room_id']]) || $e['month'] > $map_e[$e['room_id']]['month']) {
        $map_e[$e['room_id']] = $e;
    }
}
$map_w = [];
foreach ($water as $w) {
    if (!isset($map_w[$w['room_id']]) || $w['month'] > $map_w[$w['room_id']]['month']) {
        $map_w[$w['room_id']] = $w;
    }
}
/* Giải thích code từ dòng 21 đến dòng 31:
Dòng 21: Tạo mảng $map_e để lưu trữ thông tin điện của từng phòng, với khóa là room_id.
Dòng 22-25: Duyệt qua từng bản ghi điện, nếu phòng chưa có trong $map_e hoặc tháng của bản ghi hiện tại lớn hơn tháng đã lưu, cập nhật thông tin điện mới nhất cho phòng đó.
Dòng 26: Tạo mảng $map_w tương tự cho thông tin nước
Dòng 27-30: Duyệt qua từng bản ghi nước, nếu phòng chưa có trong $map_w hoặc tháng của bản ghi hiện tại lớn hơn tháng đã lưu, cập nhật thông tin nước mới nhất cho phòng đó.
*/
// Nếu có lọc phòng, chỉ hiển thị phòng đã lọc
if (isset($_GET['room']) && $_GET['room']) {
    $rooms = array_filter($rooms, function ($r) {
        return isset($_GET['room']) && $_GET['room'] == $r['room_code'];
    });
}
ob_start();
?>
<div class="container">
    <!-- //Hiển thị tiêu đề khi không có lọc là CHỈ SỐ ĐIỆN NƯỚC CÁC PHÒNG, khi có lọc sẽ hiển thị CHỈ SỐ ĐIỆN NƯỚC PHÒNG <số phòng> -->
    <h2><?= isset($_GET['room']) && $_GET['room'] ? 'CHỈ SỐ ĐIỆN NƯỚC PHÒNG ' . htmlspecialchars($_GET['room']) : 'CHỈ SỐ ĐIỆN NƯỚC CÁC PHÒNG' ?></h2>
    <!-- <h3>CHỈ SỐ ĐIỆN NƯỚC CÁC PHÒNG</h3> -->
    <form method="get" style="margin-bottom:18px; display:flex; gap:16px; align-items:center;">
        <input type="hidden" name="controller" value="room">
        <input type="hidden" name="action" value="electric_water">
        <label>Phòng:
            <select name="room" onchange="this.form.submit()">
                <option value="">Tất cả</option>
                <?php foreach ($rooms as $r): ?>
                    <option value="<?= htmlspecialchars($r['room_code']) ?>" <?= (isset($_GET['room']) && $_GET['room'] == $r['room_code']) ? 'selected' : '' ?>><?= htmlspecialchars($r['room_code']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit" style="padding:6px 18px; font-size:15px; border-radius:6px; background:#093d62; color:#fff; border:none;">Lọc</button>
        <a href="index.php?controller=room&action=electric_water" style="background:#bfc7d1; color:#093d62; padding:6px 18px; font-size:15px; border-radius:6px; text-decoration:none;">Xóa lọc</a>
        <a href="index.php?controller=room&action=add_electric_water" style="background:#bfc7d1; color:#093d62; padding:6px 18px; font-size:15px; border-radius:6px; text-decoration:none;">Thêm chỉ số điện, nước</a>
        <button onclick="printBangChiSo()" style="background:#093d62; color:#fff; padding:8px 22px; border-radius:6px; font-size:16px; border:none; margin: 18px 0 18px 0; cursor:pointer;">In chỉ số</button>
    </form>

    <br>

    <div class="electricity-water">
        <?php
        // Gom tất cả các tháng có dữ liệu điện hoặc nước của từng phòng
        foreach ($rooms as $r) {
            $room_id = $r['id'];
            // Lấy tất cả các tháng có điện hoặc nước của phòng này
            $months = [];
            foreach ($electricity as $e) {
                if ($e['room_id'] == $room_id) $months[$e['month']] = true;
            }
            foreach ($water as $w) {
                if ($w['room_id'] == $room_id) $months[$w['month']] = true;
            }
            krsort($months); // Sắp xếp tháng giảm dần
            foreach (array_keys($months) as $month) {
                // Lấy bản ghi điện và nước theo tháng/phòng
                $e = null;
                $w = null;
                foreach ($electricity as $item) {
                    if ($item['room_id'] == $room_id && $item['month'] == $month) {
                        $e = $item;
                        break;
                    }
                }
                foreach ($water as $item) {
                    if ($item['room_id'] == $room_id && $item['month'] == $month) {
                        $w = $item;
                        break;
                    }
                }
        ?>
                <div class="month">
                    <h3>Tháng: <?= htmlspecialchars($month) ?></h3>
                    <h3>Phòng <?= htmlspecialchars($r['room_code']) ?></h3>
                    <table>
                        <tr>
                            <th colspan="2">Điện</th>
                            <th colspan="2">Nước</th>
                        </tr>
                        <tr>
                            <th>CSC</th>
                            <td><?= $e ? $e['CSC'] : '-' ?></td>
                            <th>CSC</th>
                            <td><?= $w ? $w['CSC'] : '-' ?></td>
                        </tr>
                        <tr>
                            <th>CSM</th>
                            <td><?= $e ? $e['CSM'] : '-' ?></td>
                            <th>CSM</th>
                            <td><?= $w ? $w['CSM'] : '-' ?></td>
                        </tr>
                        <tr>
                            <th>Tiêu thụ</th>
                            <td><?= $e ? $e['DTT'] : '-' ?></td>
                            <th>Tiêu thụ</th>
                            <td><?= $w ? $w['DTT'] : '-' ?></td>
                        </tr>
                    </table>
                    <div style="text-align:center; margin-top:10px;">
                        <a href="index.php?controller=room&action=print_electric_water&room_code=<?= urlencode($r['room_code']) ?>&month=<?= urlencode($month) ?>" target="_blank" style="display:inline-block; background:#093d62; color:#fff; padding:6px 18px; border-radius:6px; text-decoration:none; font-size:15px;">In chỉ số</a>
                    </div>
                </div>
        <?php }
        } ?>
    </div>
</div>

<div id="print-table-view" style="display:none;">
    <style>
        /*Viết CSS cho class title, cho class img căn trái, class h1 căn phải, cho class title có margin-bottom 20px*/
        .title { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .title .img { flex: 0 0 auto; }
        .title .h1 {margin-right: 25px; flex: 1; text-align: right; font-size: 24px; color: #093d62; }
        .title img { max-width: 120px; height: auto; }
    </style>
    <div class="title">
        <div class="img">
            <img src="../itro-logo.png" alt="" width="120px" height="">
        </div>
    <h3 class="h1"><?= isset($_GET['room']) && $_GET['room'] ? 'BẢNG CHỈ SỐ ĐIỆN NƯỚC PHÒNG ' . htmlspecialchars($_GET['room']) : 'BẢNG CHỈ SỐ ĐIỆN NƯỚC CÁC PHÒNG' ?></h3>
    </div>
    <!-- <h3 style="text-align:center;"><?= isset($_GET['room']) && $_GET['room'] ? 'BẢNG CHỈ SỐ ĐIỆN NƯỚC PHÒNG ' . htmlspecialchars($_GET['room']) : 'BẢNG CHỈ SỐ ĐIỆN NƯỚC CÁC PHÒNG' ?></h3> -->
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Phòng</th>
                <th>Tháng</th>
                <th>CSC điện</th>
                <th>CSM điện</th>
                <th>Tiêu thụ điện</th>
                <th>CSC nước</th>
                <th>CSM nước</th>
                <th>Tiêu thụ nước</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rooms as $r) {
                $room_id = $r['id'];
                $months = [];
                foreach ($electricity as $e) {
                    if ($e['room_id'] == $room_id) $months[$e['month']] = true;
                }
                foreach ($water as $w) {
                    if ($w['room_id'] == $room_id) $months[$w['month']] = true;
                }
                krsort($months);
                foreach (array_keys($months) as $month) {
                    $e = null;
                    $w = null;
                    foreach ($electricity as $item) {
                        if ($item['room_id'] == $room_id && $item['month'] == $month) {
                            $e = $item;
                            break;
                        }
                    }
                    foreach ($water as $item) {
                        if ($item['room_id'] == $room_id && $item['month'] == $month) {
                            $w = $item;
                            break;
                        }
                    }
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($r['room_code']) . '</td>';
                    echo '<td>' . htmlspecialchars($month) . '</td>';
                    echo '<td>' . ($e ? $e['CSC'] : '-') . '</td>';
                    echo '<td>' . ($e ? $e['CSM'] : '-') . '</td>';
                    echo '<td>' . ($e ? $e['DTT'] : '-') . '</td>';
                    echo '<td>' . ($w ? $w['CSC'] : '-') . '</td>';
                    echo '<td>' . ($w ? $w['CSM'] : '-') . '</td>';
                    echo '<td>' . ($w ? $w['DTT'] : '-') . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
    <p style="margin-top: 20px; color:#bfc7d1">Bảng chỉ số được in từ hệ thống <a href="itro.22web.org">

        <img src="../itro-logo.png" width="20px" alt="">
    </a>
</p>
</div>
<style>
    @media print {

        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }

        #print-table-view {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
    }
</style>
<script>
    function printBangChiSo() {
        document.getElementById('print-table-view').style.display = 'block';
        window.print();
        setTimeout(function() {
            document.getElementById('print-table-view').style.display = 'none';
        }, 500);
    }
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>