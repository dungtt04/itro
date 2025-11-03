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
    $so_nguoi = (int)($_POST['so_nguoi'] ?? 1);
    $tien_phong = (int)($_POST['tien_phong'] ?? 1200000);
    $room_id = getRoomIdByCode($pdo, $room);
    $mmyy = $month . $year;
    $month_db = $year && $month ? $year.'-'.str_pad($month,2,'0',STR_PAD_LEFT) : '';
    $electricity_id = null;
    $water_id = null;
    $tien_dien = 0;
    $tien_nuoc = 0;
    $so_dien = isset($_POST['so_dien']) ? (int)$_POST['so_dien'] : 0;
    $so_nuoc = isset($_POST['so_nuoc']) ? (int)$_POST['so_nuoc'] : 0;
    if (isset($_POST['so_dien_select']) && $_POST['so_dien_select']) {
        $parts = explode('|', $_POST['so_dien_select']);
        $object_name = $parts[0] ?? '';
        $e = $object_name && $room_id && $month_db ? ElectricityModel::getByRoomMonthObject($room_id, $month_db, $object_name) : null;
        if ($e) {
            $electricity_id = $e['id'];
            $tien_dien = $e['total'];
        }
    }
    if (isset($_POST['so_nuoc_select']) && $_POST['so_nuoc_select']) {
        $parts = explode('|', $_POST['so_nuoc_select']);
        $object_name = $parts[0] ?? '';
        $w = $object_name && $room_id && $month_db ? WaterModel::getByRoomMonthObject($room_id, $month_db, $object_name) : null;
        if ($w) {
            $water_id = $w['id'];
            $tien_nuoc = $w['total'];
        }
    }
    $phi_dv = ($so_nguoi == 2) ? 50000 : ($so_nguoi * 30000);
    $tong_tien = $tien_phong + $tien_dien + $tien_nuoc + $phi_dv;
    $discount = isset($_POST['discount']) && is_numeric($_POST['discount']) ? (int)$_POST['discount'] : 0;
    $total_discount = $tong_tien - $discount;
    if ($total_discount < 0) $total_discount = 0;
    $amount = $total_discount;
    // Nếu chưa chọn số điện/nước, tự động lấy đúng bản ghi theo phòng, tháng, năm
    if ($so_dien == 0 && $room_id && $month && $year) {
        $e = ElectricityModel::getByRoomAndMonth($room_id, $year.'-'.str_pad($month,2,'0',STR_PAD_LEFT));
        if ($e && isset($e['DTT'])) $so_dien = (int)$e['DTT'];
    }
    if ($so_nuoc == 0 && $room_id && $month && $year) {
        $w = WaterModel::getByRoomAndMonth($room_id, $year.'-'.str_pad($month,2,'0',STR_PAD_LEFT));
        if ($w && isset($w['DTT'])) $so_nuoc = (int)$w['DTT'];
    }
    // Tạo nội dung chuyển khoản động
    $today = date('d');
    $token = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $addinfo = '';
    if ($room && $month && $year) {
        $addinfo = 'P' . $room . 'T' . $month . $today . $token;
    }
    if ($room === '' || !$room_id || $month === '' || $year === '' || $amount === '' || $so_dien < 0 || $so_nuoc < 0) {
        $error = 'Vui lòng nhập đầy đủ và hợp lệ các trường!';
    } else {
        // Tạo QR URL đúng mẫu vietqr.io
        $qr_url = 'https://img.vietqr.io/image/VCB-0341001529970-qr_only.png?amount=' . urlencode($total_discount)
            . '&addInfo=' . urlencode($addinfo)
            . '&accountName=BUI%20THI%20THANG';
        QRModel::create([
            'room' => $room,
            'mmyy' => $mmyy,
            'amount' => $amount,
            'addinfo' => $addinfo,
            'qr_url' => $qr_url,
            'status' => 'Chưa thanh toán',
            'electricity_id' => $electricity_id,
            'water_id' => $water_id,
            'so_nguoi' => $so_nguoi,
            'tien_phong' => $tien_phong,
            'tong_tien' => $tong_tien,
            'discount' => $discount,
            'total_discount' => $total_discount,
            'room_id' => $room_id
        ]);
        header('Location: index.php?controller=invoice');
        exit;
    }
    // Luôn lấy lại list điện/nước đúng tháng/năm vừa nhập
    $electricityList = ElectricityModel::getListByMonth($year.'-'.str_pad($month,2,'0',STR_PAD_LEFT));
    $waterList = WaterModel::getListByMonth($year.'-'.str_pad($month,2,'0',STR_PAD_LEFT));
} else {
    // Khi vào form lần đầu, không lấy mặc định tháng trước
    $electricityList = [];
    $waterList = [];
}

if (isset($_GET['action']) && $_GET['action'] === 'ajax_list') {
    // Lấy toàn bộ danh sách điện/nước, không lọc gì
    $result = [
        'electricity' => ElectricityModel::getAll(),
        'water' => WaterModel::getAll()
    ];
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

include __DIR__ . '/../views/qr_create.php';
