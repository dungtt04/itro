<?php
// controllers/ElectricityController.php
require_once __DIR__ . '/../models/ElectricityModel.php';
require_once __DIR__ . '/../room_helper.php';
$action = $_GET['action'] ?? 'list';
switch ($action) {
    case 'ajax_csc':
        $room_id = (int)($_GET['room_id'] ?? 0);
        $month = $_GET['month'] ?? '';
        $csc = '';
        if ($room_id && $month) {
            // Lấy tháng trước
            $prevMonth = date('Y-m', strtotime($month.'-01 -1 month'));
            $last = ElectricityModel::getByRoomAndMonth($room_id, $prevMonth);
            if ($last) $csc = $last['CSM'];
        }
        echo $csc;
        exit;
    case 'add':
        $rooms = getRoomList($pdo);
        $msg = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $month = str_pad((int)($_POST['month'] ?? ''), 2, '0', STR_PAD_LEFT);
            $year = trim($_POST['year'] ?? '');
            $month_db = $year && $month ? $year.'-'.$month : '';
            $room_id = (int)$_POST['room_id'];
            $object_name = $_POST['object_name'];
            $CSM = (int)$_POST['CSM'];
            $CSC = $_POST['CSC'] === '' ? null : (int)$_POST['CSC'];
            $DTT = $CSM - (int)$CSC;
            $unit_price = (int)$_POST['unit_price'] ?: 3000; // Mặc định 3000 nếu không có

            $total = $DTT * $unit_price;
            if ($room_id && $month_db && $CSM) {
                ElectricityModel::add([
                    'month' => $month_db,
                    'room_id' => $room_id,
                    'object_name' => $object_name,
                    'CSC' => $CSC,
                    'CSM' => $CSM,
                    'DTT' => $DTT,
                    'unit_price' => $unit_price,
                    'total' => $total
                ]);
                $msg = 'Đã thêm chỉ số điện!';
            } else {
                $msg = 'Vui lòng nhập đủ thông tin!';
            }
        }
        include __DIR__ . '/../views/electricity/electricity_add.php';
        break;
    case 'edit':
        $id = (int)($_GET['id'] ?? 0);
        $e = ElectricityModel::getById($id);
        $rooms = getRoomList($pdo);
        $msg = '';
        if (!$e) { echo 'Không tìm thấy bản ghi!'; exit; }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = (int)$_POST['room_id'];
            $month = $_POST['month'];
            $object_name = $_POST['object_name'];
            $CSM = (int)$_POST['CSM'];
            $CSC = $_POST['CSC'] === '' ? null : (int)$_POST['CSC'];
            $DTT = $CSM - (int)$CSC;
            $total = $DTT * 3000;
            ElectricityModel::update($id, [
                'month' => $month,
                'room_id' => $room_id,
                'object_name' => $object_name,
                'CSC' => $CSC,
                'CSM' => $CSM,
                'DTT' => $DTT,
                'total' => $total
            ]);
            $msg = 'Đã cập nhật!';
            $e = ElectricityModel::getById($id);
        }
        include __DIR__ . '/../views/electricity/electricity_edit.php';
        break;
    case 'delete':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) ElectricityModel::delete($id);
        header('Location: index.php?controller=electricity');
        exit;
    case 'list':
    default:
        $list = ElectricityModel::getAll();
        include __DIR__ . '/../views/electricity/electricity_list.php';
        break;
}
