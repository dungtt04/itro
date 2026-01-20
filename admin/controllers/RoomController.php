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
            $action_type = $_POST['action_type'] ?? 'single';
            
            if ($action_type === 'single') {
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
            } else if ($action_type === 'bulk') {
                $quantity = intval($_POST['quantity'] ?? 0);
                if ($quantity < 1 || $quantity > 50) {
                    $error = 'Số lượng phòng phải từ 1 đến 50!';
                } else {
                    if (RoomModel::bulkCreate($quantity)) {
                        header('Location: index.php?controller=room&action=list');
                        exit;
                    } else {
                        $error = 'Không thể tạo phòng hàng loạt. Vui lòng thử lại!';
                    }
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
    case 'vacate':
        // Trả phòng theo mã phòng: cập nhật tất cả khách thuê của phòng đó sang 'Trả phòng' và đặt trạng thái phòng là Còn trống
        $room_code = $_GET['room'] ?? null;
        if ($room_code) {
            global $pdo;
            // Lấy tất cả khách thuê hiện tại của phòng (không phải đã trả phòng)
            $stmt = $pdo->prepare("SELECT id FROM customer WHERE room = ? AND (status IS NULL OR status != 'Trả phòng')");
            $stmt->execute([$room_code]);
            $rows = $stmt->fetchAll();
            foreach ($rows as $r) {
                require_once __DIR__ . '/../models/CustomerModel.php';
                CustomerModel::traPhong($r['id']);
            }
            // Cập nhật trạng thái phòng
            RoomModel::updateStatus($room_code, 'Còn trống');
        }
        header('Location: index.php?controller=room&action=list');
        exit;
    case 'rent':
        // Chuyển hướng tới form thêm khách với phòng được chọn trước
        $room_code = $_GET['room'] ?? null;
        if ($room_code) {
            header('Location: index.php?controller=customer&action=add&room=' . urlencode($room_code));
            exit;
        }
        header('Location: index.php?controller=room&action=list');
        exit;
    case 'print_tam_tru':
        $room_code = $_GET['room'] ?? null;
        if ($room_code) {
            require_once __DIR__ . '/../models/CustomerModel.php';
            $active_customers = CustomerModel::getActiveByRoom($room_code);
        } else {
            $active_customers = [];
        }
        include __DIR__ . '/../views/print_tam_tru.php';
        break;
}
