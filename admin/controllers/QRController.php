<?php
// controllers/QRController.php
require_once __DIR__ . '/../models/QRModel.php';
require_once __DIR__ . '/../room_helper.php';
require_once __DIR__ . '/../models/ElectricityModel.php';
require_once __DIR__ . '/../models/WaterModel.php';

$error = '';
$qr_url = '';
$roomList = getRoomList($pdo);
$electricityList = [];
$waterList = [];

$month = '';
$year = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room = trim($_POST['room'] ?? '');
    $month = trim($_POST['month'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $service_fee = (int)($_POST['service_fee'] ?? 0);
    $tien_phong = (int)($_POST['tien_phong'] ?? 1200000);
    $room_id = getRoomIdByCode($pdo, $room);
    $mmyy = $month . $year;
    $month_db = $year && $month ? $year.'-'.str_pad($month,2,'0',STR_PAD_LEFT) : '';
    
    // Electricity variables
    $electricity_id = null;
    $e_old = 0;
    $e_new = 0;
    $e_used = 0;
    $e_unit_price = (int)($_POST['e_unit_price'] ?? 3000);
    $e_total = 0;
    
    // Water variables
    $water_id = null;
    $w_old = 0;
    $w_new = 0;
    $w_used = 0;
    $w_unit_price = (int)($_POST['w_unit_price'] ?? 15000);
    $w_total = 0;
    
    // Get electricity data from selection
    if (isset($_POST['so_dien_select']) && $_POST['so_dien_select']) {
        $parts = explode('|', $_POST['so_dien_select']);
        $object_name = $parts[0] ?? '';
        $e = $object_name && $room_id && $month_db ? ElectricityModel::getByRoomMonthObject($room_id, $month_db, $object_name) : null;
        if ($e) {
            $electricity_id = $e['id'];
            $e_old = (int)($e['CSC'] ?? 0);
            $e_new = (int)($e['CSM'] ?? 0);
            $e_used = (int)($e['DTT'] ?? 0);
            $e_total = $e_used * $e_unit_price;
        }
    }
    
    // Get water data from selection
    if (isset($_POST['so_nuoc_select']) && $_POST['so_nuoc_select']) {
        $parts = explode('|', $_POST['so_nuoc_select']);
        $object_name = $parts[0] ?? '';
        $w = $object_name && $room_id && $month_db ? WaterModel::getByRoomMonthObject($room_id, $month_db, $object_name) : null;
        if ($w) {
            $water_id = $w['id'];
            $w_old = (int)($w['CSC'] ?? 0);
            $w_new = (int)($w['CSM'] ?? 0);
            $w_used = (int)($w['DTT'] ?? 0);
            $w_total = $w_used * $w_unit_price;
        }
    }
    
    // Calculate totals
    $tong_tien = $tien_phong + $service_fee + $e_total + $w_total;
    $discount = isset($_POST['discount']) && is_numeric($_POST['discount']) ? (int)$_POST['discount'] : 0;
    $total_discount = $tong_tien - $discount;
    if ($total_discount < 0) $total_discount = 0;
    
    // Create transaction code
    $today = date('d');
    $token = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $addinfo = '';
    if ($room && $month && $year) {
        $addinfo = 'P' . $room . 'T' . $month . $today . $token;
    }
    
    if ($room === '' || !$room_id || $month === '' || $year === '') {
        $error = 'Vui lòng nhập đầy đủ và hợp lệ các trường!';
    } else {
        // Create invoice with new fields
        QRModel::create([
            'room' => $room,
            'mmyy' => $mmyy,
            'addinfo' => $addinfo,
            'status' => 'Chưa thanh toán',
            'electricity_id' => $electricity_id,
            'water_id' => $water_id,
            'tien_phong' => $tien_phong,
            'service_fee' => $service_fee,
            'tong_tien' => $tong_tien,
            'discount' => $discount,
            'total_discount' => $total_discount,
            'room_id' => $room_id,
            'e_old' => $e_old,
            'e_new' => $e_new,
            'e_used' => $e_used,
            'e_unit_price' => $e_unit_price,
            'e_total' => $e_total,
            'w_old' => $w_old,
            'w_new' => $w_new,
            'w_used' => $w_used,
            'w_unit_price' => $w_unit_price,
            'w_total' => $w_total
        ]);
        header('Location: index.php?controller=invoice');
        exit;
    }
    // Always reload electricity/water list for the entered month/year
    $electricityList = ElectricityModel::getListByMonth($year.'-'.str_pad($month,2,'0',STR_PAD_LEFT));
    $waterList = WaterModel::getListByMonth($year.'-'.str_pad($month,2,'0',STR_PAD_LEFT));
} else {
    // On first form load, don't load any lists yet
    $electricityList = [];
    $waterList = [];
}

if (isset($_GET['action']) && $_GET['action'] === 'ajax_list') {
    // If month/year provided, filter lists by that month (format YYYY-MM)
    $qmonth = trim($_GET['month'] ?? '');
    $qyear = trim($_GET['year'] ?? '');
    if ($qmonth !== '' && $qyear !== '') {
        // normalize month to two digits
        $mm = str_pad($qmonth, 2, '0', STR_PAD_LEFT);
        $month_db = $qyear . '-' . $mm;
        $elec = ElectricityModel::getListByMonth($month_db);
        $wat = WaterModel::getListByMonth($month_db);
    } else {
        // fallback: return all
        $elec = ElectricityModel::getAll();
        $wat = WaterModel::getAll();
    }

    $result = [
        'electricity' => $elec,
        'water' => $wat
    ];
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

include __DIR__ . '/../views/qr/qr_create.php';
