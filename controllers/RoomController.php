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
    case 'list':
    default:
        $rooms = RoomModel::getAll();
        include __DIR__ . '/../views/room_list.php';
        break;
}
