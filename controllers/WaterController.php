<?php
// controllers/WaterController.php
require_once __DIR__ . '/../models/WaterModel.php';
require_once __DIR__ . '/../room_helper.php';
$action = $_GET['action'] ?? 'list';
switch ($action) {
    case 'ajax_csc':
        $room_id = (int)($_GET['room_id'] ?? 0);
        $month = $_GET['month'] ?? '';
        $csc = '';
        if ($room_id && $month) {
            $prevMonth = date('Y-m', strtotime($month.'-01 -1 month'));
            $last = WaterModel::getByRoomAndMonth($room_id, $prevMonth);
            if ($last) $csc = $last['CSM'];
        }
        echo $csc;
        exit;
    case 'ajax_list':
        $month = trim($_GET['month'] ?? '');
        $year = trim($_GET['year'] ?? '');
        $room = trim($_GET['room'] ?? '');
        $result = [];
        if ($month && $year && $room) {
            $monthStr = $year.'-'.str_pad($month,2,'0',STR_PAD_LEFT);
            $room_id = getRoomIdByCode($pdo, $room);
            if ($room_id) {
                $result = WaterModel::getListByMonth($monthStr);
                $result = array_filter($result, function($w) use ($room_id) { return $w['room_id'] == $room_id; });
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array_values($result));
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
            $total = $DTT * 15000;
            if ($room_id && $month_db && $CSM) {
                WaterModel::add([
                    'month' => $month_db,
                    'room_id' => $room_id,
                    'object_name' => $object_name,
                    'CSC' => $CSC,
                    'CSM' => $CSM,
                    'DTT' => $DTT,
                    'total' => $total
                ]);
                $msg = 'Đã thêm chỉ số nước!';
            } else {
                $msg = 'Vui lòng nhập đủ thông tin!';
            }
        }
        include __DIR__ . '/../views/water_add.php';
        break;
    case 'edit':
        $id = (int)($_GET['id'] ?? 0);
        $w = WaterModel::getById($id);
        $rooms = getRoomList($pdo);
        $msg = '';
        if (!$w) { echo 'Không tìm thấy bản ghi!'; exit; }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = (int)$_POST['room_id'];
            $month = $_POST['month'];
            $object_name = $_POST['object_name'];
            $CSM = (int)$_POST['CSM'];
            $CSC = $_POST['CSC'] === '' ? null : (int)$_POST['CSC'];
            $DTT = $CSM - (int)$CSC;
            $total = $DTT * 15000;
            WaterModel::update($id, [
                'month' => $month,
                'room_id' => $room_id,
                'object_name' => $object_name,
                'CSC' => $CSC,
                'CSM' => $CSM,
                'DTT' => $DTT,
                'total' => $total
            ]);
            $msg = 'Đã cập nhật!';
            $w = WaterModel::getById($id);
        }
        include __DIR__ . '/../views/water_edit.php';
        break;
    case 'delete':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) WaterModel::delete($id);
        header('Location: index.php?controller=water');
        exit;
    case 'list':
    default:
        $list = WaterModel::getAll();
        include __DIR__ . '/../views/water_list.php';
        break;
}
