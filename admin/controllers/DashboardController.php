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

// Chart data for current month
$labels = [];
$electricityData = [];
$waterData = [];
$totalElectricityConsumption = 0;
$totalWaterConsumption = 0;

foreach ($rooms as $r) {
    $labels[] = $r['room_code'];
    $e = ElectricityModel::getByRoomAndMonth($r['id'], $year.'-'.$month);
    $w = WaterModel::getByRoomAndMonth($r['id'], $year.'-'.$month);
    $eDTT = $e ? (int)$e['DTT'] : 0;
    $wDTT = $w ? (int)$w['DTT'] : 0;
    $electricityData[] = $eDTT;
    $waterData[] = $wDTT;
    $totalElectricityConsumption += $eDTT;
    $totalWaterConsumption += $wDTT;
}

$newCustomers = CustomerModel::getNewIn7Days();
$unpaidInvoices = QRModel::getUnpaid();

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

// ========== MONTHLY STATISTICS ==========
$monthKey = $statYear.'-'.str_pad($statMonth, 2, '0', STR_PAD_LEFT);
$electricityList = ElectricityModel::getListByMonth($monthKey);
$waterList = WaterModel::getListByMonth($monthKey);

// Get invoices for selected month - now using new schema
$invoices = $pdo->prepare("SELECT * FROM nhatro_history WHERE mmyy=?");
$invoices->execute([$statMonth.$statYear]);
$invoices = $invoices->fetchAll();

// Calculate monthly revenues using new fields
$tongThu = 0;      // total revenue (amount to pay)
$thuDien = 0;      // electricity revenue
$thuNuoc = 0;      // water revenue
$thuDichVu = 0;    // service revenue
$tienPhong = 0;    // room fee revenue

foreach($invoices as $inv) {
    $tongThu += (int)($inv['total_discount'] ?? $inv['amount'] ?? 0);
    $thuDien += (int)($inv['e_total'] ?? 0);
    $thuNuoc += (int)($inv['w_total'] ?? 0);
    $thuDichVu += (int)($inv['service_fee'] ?? 0);
    $tienPhong += (int)($inv['tien_phong'] ?? 0);
}

// Calculate cost (nộp điện/nước)
$nopDien = 0;
$nopNuoc = 0;
foreach($electricityList as $e) { 
    $nopDien += (int)($e['DTT'] ?? 0) * 2326; 
}
foreach($waterList as $w) { 
    $nopNuoc += (int)($w['DTT'] ?? 0) * 12500; 
}
$loiNhuan = $tongThu - $nopDien - $nopNuoc;

// ========== YEARLY STATISTICS ==========
// Monthly revenue data for selected year
$monthlyRevenueData = array_fill(0, 12, 0);
$monthlyRoomRevenueData = array_fill(0, 12, 0);
$monthlyUtilityRevenueData = array_fill(0, 12, 0);

$stmt = $pdo->prepare("SELECT mmyy, total_discount, tien_phong FROM nhatro_history WHERE mmyy LIKE ?");
$stmt->execute(['_'.$statYearOnly]);
$monthlyData = $stmt->fetchAll();

foreach ($monthlyData as $record) {
    $m = intval(substr($record['mmyy'], 0, 2)) - 1; 
    $totalAmount = intval($record['total_discount'] ?? 0);
    $roomFee = intval($record['tien_phong'] ?? 0);
    
    $monthlyRevenueData[$m] += $totalAmount;
    $monthlyRoomRevenueData[$m] += $roomFee;
    $monthlyUtilityRevenueData[$m] += ($totalAmount - $roomFee);
}

// Yearly revenue data
$yearLabels = [];
$yearlyRevenueData = [];
$yearlyRoomRevenueData = [];
$yearlyUtilityRevenueData = [];

$startYear = 2023;
$endYear = intval(date('Y'));

for ($y = $startYear; $y <= $endYear; $y++) {
    $yearLabels[] = $y;
    
    $stmt = $pdo->prepare("SELECT SUM(total_discount) as total_amount, SUM(tien_phong) as total_room 
                          FROM nhatro_history 
                          WHERE mmyy LIKE ?");
    $stmt->execute(['_'.$y]);
    $yearData = $stmt->fetch();
    
    $totalAmount = intval($yearData['total_amount'] ?? 0);
    $totalRoom = intval($yearData['total_room'] ?? 0);
    
    $yearlyRevenueData[] = $totalAmount;
    $yearlyRoomRevenueData[] = $totalRoom;
    $yearlyUtilityRevenueData[] = $totalAmount - $totalRoom;
}

// ========== YEARLY DETAILED STATISTICS ==========
$invoicesYear = $pdo->prepare("SELECT * FROM nhatro_history WHERE mmyy LIKE ?");
$invoicesYear->execute(['_'.$statYearOnly]);
$invoicesYear = $invoicesYear->fetchAll();

$tongThuNam = 0;
$thuDienNam = 0;
$thuNuocNam = 0;
$thuDichVuNam = 0;
$tienPhongNam = 0;

foreach($invoicesYear as $inv) {
    $tongThuNam += (int)($inv['total_discount'] ?? $inv['amount'] ?? 0);
    $thuDienNam += (int)($inv['e_total'] ?? 0);
    $thuNuocNam += (int)($inv['w_total'] ?? 0);
    $thuDichVuNam += (int)($inv['service_fee'] ?? 0);
    $tienPhongNam += (int)($inv['tien_phong'] ?? 0);
}

// Calculate yearly costs and consumption
$electricityYear = $pdo->prepare("SELECT * FROM electricity WHERE month LIKE ?");
$electricityYear->execute([$statYearOnly.'-%']);
$nopDienNam = 0;
$tongDienTieuThuNam = 0;
foreach($electricityYear->fetchAll() as $e) { 
    $dtt = (int)($e['DTT'] ?? 0);
    $nopDienNam += $dtt * 2326;
    $tongDienTieuThuNam += $dtt;
}

$waterYear = $pdo->prepare("SELECT * FROM water WHERE month LIKE ?");
$waterYear->execute([$statYearOnly.'-%']);
$nopNuocNam = 0;
$tongNuocTieuThuNam = 0;
foreach($waterYear->fetchAll() as $w) { 
    $dtt = (int)($w['DTT'] ?? 0);
    $nopNuocNam += $dtt * 12500;
    $tongNuocTieuThuNam += $dtt;
}

$loiNhuanNam = $tongThuNam - $nopDienNam - $nopNuocNam;

// ========== YEARLY ELECTRICITY AND WATER BY ROOM ==========
$yearlyElectricityByRoom = [];
$yearlyWaterByRoom = [];

foreach ($rooms as $room) {
    $roomElectricity = 0;
    $roomWater = 0;
    
    // Get all electricity records for this room in the selected year
    $stmt = $pdo->prepare("SELECT * FROM electricity WHERE room_id = ? AND month LIKE ?");
    $stmt->execute([$room['id'], $statYearOnly.'-%']);
    foreach ($stmt->fetchAll() as $e) {
        $roomElectricity += (int)($e['DTT'] ?? 0);
    }
    
    // Get all water records for this room in the selected year
    $stmt = $pdo->prepare("SELECT * FROM water WHERE room_id = ? AND month LIKE ?");
    $stmt->execute([$room['id'], $statYearOnly.'-%']);
    foreach ($stmt->fetchAll() as $w) {
        $roomWater += (int)($w['DTT'] ?? 0);
    }
    
    $yearlyElectricityByRoom[$room['room_code']] = $roomElectricity;
    $yearlyWaterByRoom[$room['room_code']] = $roomWater;
}

// ========== STATISTICS ==========
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM room WHERE status IN (0,'0','empty','available','vacant')");
    $stmt->execute();
    $vacantRoomsCount = (int) $stmt->fetchColumn();
} catch (Exception $ex) {
    $vacantRoomsCount = 0;
}

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM customer");
    $stmt->execute();
    $totalCustomersCount = (int) $stmt->fetchColumn();
} catch (Exception $ex) {
    $totalCustomersCount = 0;
}

include __DIR__ . '/../views/dashboard.php';