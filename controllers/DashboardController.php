<?php
// controllers/DashboardController.php
require_once __DIR__ . '/../models/ElectricityModel.php';
require_once __DIR__ . '/../models/WaterModel.php';
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/QRModel.php';
require_once __DIR__ . '/../room_helper.php';
$year = $_GET['year'] ?? date('Y');
$month = $_GET['month'] ?? date('m');
$rooms = getRoomList($pdo);
$labels = [];
$electricityData = [];
$waterData = [];
foreach ($rooms as $r) {
    $labels[] = $r['room_code'];
    $e = ElectricityModel::getByRoomAndMonth($r['id'], $year.'-'.$month);
    $w = WaterModel::getByRoomAndMonth($r['id'], $year.'-'.$month);
    $electricityData[] = $e ? (int)$e['DTT'] : 0;
    $waterData[] = $w ? (int)$w['DTT'] : 0;
}
$newCustomers = CustomerModel::getNewIn7Days();
$unpaidInvoices = QRModel::getUnpaid();
$pdo = $pdo ?? null;
$selectedMonth = $month;
$selectedYear = $year;
if (isset($_GET['stat_month'])) {
    $statMonth = $_GET['stat_month'];
    $statYear = $_GET['stat_year'] ?? $year;
} else {
    $statMonth = $month;
    $statYear = $year;
}
if (isset($_GET['stat_year_only'])) {
    $statYearOnly = $_GET['stat_year_only'];
} else {
    $statYearOnly = $year;
}
// Thống kê doanh thu tháng
$monthKey = $statYear.'-'.$statMonth;
$electricityList = ElectricityModel::getListByMonth($monthKey);
$waterList = WaterModel::getListByMonth($monthKey);
$invoices = $pdo->prepare("SELECT * FROM nhatro_history WHERE mmyy=?");
$invoices->execute([$statMonth.$statYear]);
$invoices = $invoices->fetchAll();
$tongThu = 0; $thuDien = 0; $thuNuoc = 0; $tienPhong = 0;
foreach($invoices as $inv) {
    $tongThu += (int)$inv['amount'];
    // Lấy số điện từ bảng electricity
    $so_dien = 0;
    if (!empty($inv['electricity_id'])) {
        $stmt = $pdo->prepare("SELECT DTT FROM electricity WHERE id = ?");
        $stmt->execute([$inv['electricity_id']]);
        $row = $stmt->fetch();
        if ($row && isset($row['DTT'])) $so_dien = (int)$row['DTT'];
    }
    $thuDien += $so_dien * 3000;
    // Lấy số nước từ bảng water
    $so_nuoc = 0;
    if (!empty($inv['water_id'])) {
        $stmt = $pdo->prepare("SELECT DTT FROM water WHERE id = ?");
        $stmt->execute([$inv['water_id']]);
        $row = $stmt->fetch();
        if ($row && isset($row['DTT'])) $so_nuoc = (int)$row['DTT'];
    }
    $thuNuoc += $so_nuoc * 15000;
    $tienPhong += (int)$inv['tien_phong'];
}
$nopDien = 0; $nopNuoc = 0;
foreach($electricityList as $e) { $nopDien += (int)$e['DTT'] * 2326; }
foreach($waterList as $w) { $nopNuoc += (int)$w['DTT'] * 12500; }
$loiNhuan = $tongThu - $nopDien - $nopNuoc;
// Thống kê doanh thu năm
$invoicesYear = $pdo->prepare("SELECT * FROM nhatro_history WHERE mmyy LIKE ?");
$invoicesYear->execute(['%'.$statYearOnly]);
$invoicesYear = $invoicesYear->fetchAll();
$tongThuNam = 0; $thuDienNam = 0; $thuNuocNam = 0; $tienPhongNam = 0;
foreach($invoicesYear as $inv) {
    $tongThuNam += (int)$inv['amount'];
    // Lấy số điện từ bảng electricity
    $so_dien = 0;
    if (!empty($inv['electricity_id'])) {
        $stmt = $pdo->prepare("SELECT DTT FROM electricity WHERE id = ?");
        $stmt->execute([$inv['electricity_id']]);
        $row = $stmt->fetch();
        if ($row && isset($row['DTT'])) $so_dien = (int)$row['DTT'];
    }
    $thuDienNam += $so_dien * 3000;
    // Lấy số nước từ bảng water
    $so_nuoc = 0;
    if (!empty($inv['water_id'])) {
        $stmt = $pdo->prepare("SELECT DTT FROM water WHERE id = ?");
        $stmt->execute([$inv['water_id']]);
        $row = $stmt->fetch();
        if ($row && isset($row['DTT'])) $so_nuoc = (int)$row['DTT'];
    }
    $thuNuocNam += $so_nuoc * 15000;
    $tienPhongNam += (int)$inv['tien_phong'];
}
$electricityYear = $pdo->prepare("SELECT * FROM electricity WHERE month LIKE ?");
$electricityYear->execute([$statYearOnly.'-%']);
$nopDienNam = 0;
foreach($electricityYear->fetchAll() as $e) { $nopDienNam += (int)$e['DTT'] * 2326; }
$waterYear = $pdo->prepare("SELECT * FROM water WHERE month LIKE ?");
$waterYear->execute([$statYearOnly.'-%']);
$nopNuocNam = 0;
foreach($waterYear->fetchAll() as $w) { $nopNuocNam += (int)$w['DTT'] * 12500; }
$loiNhuanNam = $tongThuNam - $nopDienNam - $nopNuocNam;
include __DIR__ . '/../views/dashboard.php';
// <?php
// // controllers/DashboardController.php
// require_once __DIR__ . '/../models/ElectricityModel.php';
// require_once __DIR__ . '/../models/WaterModel.php';
// require_once __DIR__ . '/../models/CustomerModel.php';
// require_once __DIR__ . '/../models/QRModel.php';
// require_once __DIR__ . '/../room_helper.php';
// $year = $_GET['year'] ?? date('Y');
// $month = $_GET['month'] ?? date('m');
// $rooms = getRoomList($pdo);
// $labels = [];
// $electricityData = [];
// $waterData = [];
// foreach ($rooms as $r) {
//     $labels[] = $r['room_code'];
//     $e = ElectricityModel::getByRoomAndMonth($r['id'], $year.'-'.$month);
//     $w = WaterModel::getByRoomAndMonth($r['id'], $year.'-'.$month);
//     $electricityData[] = $e ? (int)$e['DTT'] : 0;
//     $waterData[] = $w ? (int)$w['DTT'] : 0;
// }
// $newCustomers = CustomerModel::getNewIn7Days();
// $unpaidInvoices = QRModel::getUnpaid();
// $pdo = $pdo ?? null;
// $selectedMonth = $month;
// $selectedYear = $year;
// if (isset($_GET['stat_month'])) {
//     $statMonth = $_GET['stat_month'];
//     $statYear = $_GET['stat_year'] ?? $year;
// } else {
//     $statMonth = $month;
//     $statYear = $year;
// }
// if (isset($_GET['stat_year_only'])) {
//     $statYearOnly = $_GET['stat_year_only'];
// } else {
//     $statYearOnly = $year;
// }
// // Thống kê doanh thu tháng
// $monthKey = $statYear.'-'.$statMonth;
// $electricityList = ElectricityModel::getListByMonth($monthKey);
// $waterList = WaterModel::getListByMonth($monthKey);
// $invoices = $pdo->prepare("SELECT * FROM nhatro_history WHERE mmyy=?");
// $invoices->execute([$statMonth.$statYear]);
// $invoices = $invoices->fetchAll();
// $tongThu = 0; $thuDien = 0; $thuNuoc = 0; $tienPhong = 0;
// foreach($invoices as $inv) {
//     $tongThu += (int)$inv['amount'];
//     // Lấy số điện từ bảng electricity
//     $so_dien = 0;
//     if (!empty($inv['electricity_id'])) {
//         $stmt = $pdo->prepare("SELECT DTT FROM electricity WHERE id = ?");
//         $stmt->execute([$inv['electricity_id']]);
//         $row = $stmt->fetch();
//         if ($row && isset($row['DTT'])) $so_dien = (int)$row['DTT'];
//     }
//     $thuDien += $so_dien * 3000;
//     // Lấy số nước từ bảng water
//     $so_nuoc = 0;
//     if (!empty($inv['water_id'])) {
//         $stmt = $pdo->prepare("SELECT DTT FROM water WHERE id = ?");
//         $stmt->execute([$inv['water_id']]);
//         $row = $stmt->fetch();
//         if ($row && isset($row['DTT'])) $so_nuoc = (int)$row['DTT'];
//     }
//     $thuNuoc += $so_nuoc * 15000;
//     $tienPhong += (int)$inv['tien_phong'];
// }
// $nopDien = 0; $nopNuoc = 0;
// foreach($electricityList as $e) { $nopDien += (int)$e['DTT'] * 2326; }
// foreach($waterList as $w) { $nopNuoc += (int)$w['DTT'] * 12500; }
// $loiNhuan = $tongThu - $nopDien - $nopNuoc;
// // Thống kê doanh thu năm
// $invoicesYear = $pdo->prepare("SELECT * FROM nhatro_history WHERE mmyy LIKE ?");
// $invoicesYear->execute(['%'.$statYearOnly]);
// $invoicesYear = $invoicesYear->fetchAll();
// $tongThuNam = 0; $thuDienNam = 0; $thuNuocNam = 0; $tienPhongNam = 0;
// foreach($invoicesYear as $inv) {
//     $tongThuNam += (int)$inv['amount'];
//     // Lấy số điện từ bảng electricity
//     $so_dien = 0;
//     if (!empty($inv['electricity_id'])) {
//         $stmt = $pdo->prepare("SELECT DTT FROM electricity WHERE id = ?");
//         $stmt->execute([$inv['electricity_id']]);
//         $row = $stmt->fetch();
//         if ($row && isset($row['DTT'])) $so_dien = (int)$row['DTT'];
//     }
//     $thuDienNam += $so_dien * 3000;
//     // Lấy số nước từ bảng water
//     $so_nuoc = 0;
//     if (!empty($inv['water_id'])) {
//         $stmt = $pdo->prepare("SELECT DTT FROM water WHERE id = ?");
//         $stmt->execute([$inv['water_id']]);
//         $row = $stmt->fetch();
//         if ($row && isset($row['DTT'])) $so_nuoc = (int)$row['DTT'];
//     }
//     $thuNuocNam += $so_nuoc * 15000;
//     $tienPhongNam += (int)$inv['tien_phong'];
// }
// $electricityYear = $pdo->prepare("SELECT * FROM electricity WHERE month LIKE ?");
// $electricityYear->execute([$statYearOnly.'-%']);
// $nopDienNam = 0;
// foreach($electricityYear->fetchAll() as $e) { $nopDienNam += (int)$e['DTT'] * 2326; }
// $waterYear = $pdo->prepare("SELECT * FROM water WHERE month LIKE ?");
// $waterYear->execute([$statYearOnly.'-%']);
// $nopNuocNam = 0;
// foreach($waterYear->fetchAll() as $w) { $nopNuocNam += (int)$w['DTT'] * 12500; }
// $loiNhuanNam = $tongThuNam - $nopDienNam - $nopNuocNam;
// include __DIR__ . '/../views/dashboard.php';
