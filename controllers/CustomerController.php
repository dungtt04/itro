<?php
// controllers/CustomerController.php
require_once __DIR__ . '/../models/CustomerModel.php';
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
    case 'delete':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) CustomerModel::delete($id);
        header('Location: index.php?controller=customer&action=list');
        exit;
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
    case 'list':
    default:
        $customers = CustomerModel::getAll();
        include __DIR__ . '/../views/customer_list.php';
        break;
}
