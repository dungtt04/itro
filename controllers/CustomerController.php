<?php
// controllers/CustomerController.php
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/RoomModel.php';
require_once __DIR__ . '/../room_helper.php';
// Đã bỏ hoàn toàn kiểm tra đăng nhập/session, ai cũng có thể thêm khách thuê
$error = '';
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room = trim($_POST['room'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $cccd = trim($_POST['cccd'] ?? '');
            $dob = trim($_POST['dob'] ?? '');
            $cccd_date = trim($_POST['cccd_date'] ?? '');
            $cccd_place = trim($_POST['cccd_place'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $room_id = getRoomIdByCode($pdo, $room);
            if ($room === '' || $name === '' || $cccd === '' || $dob === '' || $cccd_date === '' || $cccd_place === '' || $address === '' || $phone === '' || !$room_id) {
                $error = 'Vui lòng nhập đầy đủ các trường và chọn phòng hợp lệ!';
            } else {
                // Kiểm tra phòng đã có khách thuê chưa
                $hasCustomer = false;
                foreach (CustomerModel::getAll() as $cus) {
                    if ($cus['room_id'] == $room_id && (!isset($cus['status']) || $cus['status'] !== 'Trả phòng')) {
                        $hasCustomer = true;
                        break;
                    }
                }
                // Lấy trạng thái phòng
                $roomInfo = null;
                foreach (RoomModel::getAll() as $r) {
                    if ($r['id'] == $room_id) { $roomInfo = $r; break; }
                }
                if (!$hasCustomer && $roomInfo && (empty($roomInfo['status']) || $roomInfo['status'] == 'Còn trống')) {
                    RoomModel::updateStatus($room, 'Đang thuê');
                }
                $ok = CustomerModel::add([
                    'room' => $room,
                    'name' => $name,
                    'cccd' => $cccd,
                    'dob' => $dob,
                    'cccd_date' => $cccd_date,
                    'cccd_place' => $cccd_place,
                    'address' => $address,
                    'phone' => $phone,
                    'room_id' => $room_id
                ]);
                if ($ok) {
                    header('Location: index.php?controller=customer&action=list');
                    exit;
                } else {
                    $error = 'Không thể thêm khách thuê!';
                }
            }
        }
        $roomList = getRoomList($pdo);
        include __DIR__ . '/../views/customer_add.php';
        break;
    case 'tra_phong':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) CustomerModel::traPhong($id);
        header('Location: index.php?controller=customer&action=list');
        exit;
        case 'list_tra_phong':
        $customers = array_filter(CustomerModel::getAll(), function($c) {
            return isset($c['status']) && $c['status'] === 'Trả phòng';
        });
        include __DIR__ . '/../views/customer_list_tra_phong.php';
        break;
    case 'contract':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $customer = CustomerModel::getById($id);
            if ($customer) {
                include __DIR__ . '/../views/customer_contract.php';
                exit;
            }
        }
        // Nếu không tìm thấy, quay lại danh sách
        header('Location: index.php?controller=customer&action=list');
        exit;
    case 'delete':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) CustomerModel::delete($id);
        header('Location: index.php?controller=customer&action=list');
        exit;
    case 'edit':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=customer&action=list');
            exit;
        }
        require_once __DIR__ . '/../models/CustomerModel.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'dob' => $_POST['dob'] ?? '',
                'cccd' => $_POST['cccd'] ?? '',
                'cccd_date' => $_POST['cccd_date'] ?? '',
                'cccd_place' => $_POST['cccd_place'] ?? '',
                'address' => $_POST['address'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'type_of_tenant' => $_POST['type_of_tenant'] ?? '',
            ];
            $customer = CustomerModel::getById($id);
            CustomerModel::update($id, $data);
            // Đặt thông báo vào session
            $_SESSION['success_message'] = 'Cập nhật thông tin khách ' . htmlspecialchars($data['name']) . ' thành công';
            header('Location: index.php?controller=customer&action=list');
            exit;
        }
        // Nếu GET thì không làm gì (form sửa hiển thị ở customer_list)
    case 'list':
    default:
        $customers = CustomerModel::getAll();
        include __DIR__ . '/../views/customer_list.php';
        break;
}
