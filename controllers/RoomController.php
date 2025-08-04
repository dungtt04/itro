<?php
// controllers/RoomController.php
// session_start();
require_once __DIR__ . '/../models/RoomModel.php';

// if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
//     header('Location: index.php?controller=login');
//     exit;
// }

$error = '';
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_code = trim($_POST['room_code'] ?? '');
            $description = trim($_POST['description'] ?? '');
            if ($room_code === '') {
                $error = 'Vui lòng nhập mã phòng!';
            } else {
                if (RoomModel::add($room_code, $description)) {
                    header('Location: index.php?controller=room&action=list');
                    exit;
                } else {
                    $error = 'Không thể thêm phòng (có thể mã phòng đã tồn tại)!';
                }
            }
        }
        include __DIR__ . '/../views/room_add.php';
        break;
    case 'electric_water':
    require_once __DIR__ . '/../models/ElectricityModel.php';
    require_once __DIR__ . '/../models/WaterModel.php';
    $rooms = RoomModel::getAll();
    $room_code = $_GET['room'] ?? '';
    if ($room_code) {
        $room = null;
        foreach ($rooms as $r) { if ($r['room_code'] == $room_code) { $room = $r; break; } }
        $room_id = $room ? $room['id'] : null;
        $electricity = $room_id ? array_filter(ElectricityModel::getAll(), function($e) use ($room_id) { return $e['room_id'] == $room_id; }) : [];
        $water = $room_id ? array_filter(WaterModel::getAll(), function($w) use ($room_id) { return $w['room_id'] == $room_id; }) : [];
    } else {
        $electricity = ElectricityModel::getAll();
        $water = WaterModel::getAll();
    }
    include __DIR__ . '/../views/room_electric_water.php';
    break;
        case 'add_electric_water':
        include __DIR__ . '/../views/electric_water_add.php';
        break;
    case 'add_electric_water':
        include __DIR__ . '/../views/electric_water_add.php';
        break;

    case 'list':
    default:
        $rooms = RoomModel::getAll();
        include __DIR__ . '/../views/room_list.php';
        break;
}
