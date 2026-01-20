<?php
// controllers/DepositController.php
require_once __DIR__ . '/../models/DepositModel.php';
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../models/RoomModel.php';
require_once __DIR__ . '/../room_helper.php';

$error = '';
$success = '';
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $deposits = DepositModel::getAll('room_id', 'ASC');
        include __DIR__ . '/../views/deposit_list.php';
        break;

    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = (int)($_POST['room_id'] ?? 0);
            $customer_id = (int)($_POST['customer_id'] ?? 0);
            $customer_name = trim($_POST['customer_name'] ?? '');
            $deposit_amount = (float)($_POST['deposit_amount'] ?? 0);

            if (!$room_id) {
                $error = 'Vui lòng chọn phòng!';
            } elseif ($deposit_amount <= 0) {
                $error = 'Số tiền cọc phải lớn hơn 0!';
            } else {
                // Nếu thêm khách hàng mới
                if ($customer_id == 0 && !empty($customer_name)) {
                    $cccd = trim($_POST['customer_cccd'] ?? '');
                    $dob = trim($_POST['customer_dob'] ?? '');
                    $cccd_date = trim($_POST['customer_cccd_date'] ?? '');
                    $cccd_place = trim($_POST['customer_cccd_place'] ?? '');
                    $phone = trim($_POST['customer_phone'] ?? '');
                    $address = trim($_POST['customer_address'] ?? '');
                    $type_of_tenant = trim($_POST['customer_type_of_tenant'] ?? 'chính');
                    
                    $newCustomerId = CustomerModel::add([
                        'room' => getRoomCodeById($pdo, $room_id),
                        'name' => $customer_name,
                        'cccd' => $cccd ?? '',
                        'dob' => !empty($dob) ? $dob : '0000-00-00',
                        'cccd_date' => !empty($cccd_date) ? $cccd_date : '0000-00-00',
                        'cccd_place' => $cccd_place ?? '',
                        'address' => $address ?? '',
                        'phone' => $phone ?? '',
                        'type_of_tenant' => $type_of_tenant,
                        'room_id' => $room_id
                    ]);
                    
                    if ($newCustomerId) {
                        $customer_id = $newCustomerId;
                        
                        // Cập nhật trạng thái phòng
                        $roomCode = getRoomCodeById($pdo, $room_id);
                        RoomModel::updateStatus($roomCode, 'Đang thuê');
                    } else {
                        $error = 'Không thể thêm khách hàng mới!';
                    }
                }

                if (empty($error)) {
                    // Lấy tên khách thuê: nếu có chọn khách từ danh sách thì lấy từ DB, nếu là tạo mới thì lấy từ form
                    $final_customer_name = $customer_name;
                    if ($customer_id > 0) {
                        $customer = CustomerModel::getById($customer_id);
                        if ($customer) {
                            $final_customer_name = $customer['name'];
                        }
                    }
                    
                    $depositData = [
                        'room_id' => $room_id,
                        'customer_id' => $customer_id > 0 ? $customer_id : null,
                        'name' => !empty($final_customer_name) ? $final_customer_name : 'Chưa xác định',
                        'deposit_amount' => $deposit_amount
                    ];

                    if (DepositModel::add($depositData)) {
                        // Cập nhật trạng thái phòng và khách hàng nếu có khách hàng được chọn
                        if ($customer_id > 0) {
                            $roomCode = getRoomCodeById($pdo, $room_id);
                            RoomModel::updateStatus($roomCode, 'Đang thuê');
                            // Cập nhật trạng thái khách hàng thành Đang thuê
                            CustomerModel::updateStatusDangThue($customer_id);
                        }
                        
                        $success = 'Thêm đặt cọc mới thành công!';
                        header('Location: index.php?controller=deposit&action=list');
                        exit;
                    } else {
                        $error = 'Không thể thêm đặt cọc!';
                    }
                }
            }
        }

        // Lấy danh sách phòng
        $allRooms = RoomModel::getAll();

        // Lấy danh sách khách hàng
        $customers = CustomerModel::getAll();

        include __DIR__ . '/../views/deposit_add.php';
        break;

    case 'payment':
        // Thanh toán cọc
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $deposit = DepositModel::getById($id);
            if ($deposit) {
                DepositModel::updateDepositPayment($id);
                $success = 'Cập nhật trạng thái thanh toán cọc thành công!';
            }
        }
        header('Location: index.php?controller=deposit&action=list');
        exit;

    case 'refund':
        // Cập nhật trạng thái trả phòng/trả cọc
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['deposit_id'] ?? 0);
            $refund_type = $_POST['refund_type'] ?? '';
            $refund_amount = (float)($_POST['refund_amount'] ?? 0);
            $use_full_amount = (int)($_POST['use_full_amount'] ?? 0);
            $refund_reason = trim($_POST['refund_reason'] ?? '');

            if (!$id) {
                $error = 'ID đặt cọc không hợp lệ!';
            } else {
                $deposit = DepositModel::getById($id);
                if (!$deposit) {
                    $error = 'Không tìm thấy đặt cọc!';
                } else {
                    if ($refund_type === 'return') {
                        // Trả cọc
                        if ($use_full_amount) {
                            $refund_amount = $deposit['deposit_amount'];
                        }
                        if ($refund_amount <= 0) {
                            $error = 'Số tiền hoàn phải lớn hơn 0!';
                        } else {
                            DepositModel::updateRefundStatus($id, $refund_amount);
                            $success = 'Cập nhật trạng thái trả cọc thành công!';
                            
                            // Cập nhật trạng thái phòng
                            $roomCode = $deposit['room_code'];
                            RoomModel::updateStatus($roomCode, 'Còn trống');
                            
                            // Cập nhật trạng thái khách
                            if ($deposit['customer_id']) {
                                CustomerModel::traPhong($deposit['customer_id']);
                            }
                        }
                    } elseif ($refund_type === 'no_return') {
                        // Không trả cọc
                        if (empty($refund_reason)) {
                            $error = 'Vui lòng nhập lý do không trả cọc!';
                        } else {
                            DepositModel::updateNoRefund($id, $refund_reason);
                            $success = 'Cập nhật trạng thái không trả cọc thành công!';
                            
                            // Cập nhật trạng thái phòng
                            $roomCode = $deposit['room_code'];
                            RoomModel::updateStatus($roomCode, 'Còn trống');
                            
                            // Cập nhật trạng thái khách
                            if ($deposit['customer_id']) {
                                CustomerModel::traPhong($deposit['customer_id']);
                            }
                        }
                    }

                    if (!empty($success)) {
                        header('Location: index.php?controller=deposit&action=list');
                        exit;
                    }
                }
            }
        }

        $id = (int)($_GET['id'] ?? 0);
        $deposit = DepositModel::getById($id);
        if (!$deposit) {
            header('Location: index.php?controller=deposit&action=list');
            exit;
        }
        include __DIR__ . '/../views/deposit_refund.php';
        break;

    case 'delete':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            DepositModel::delete($id);
        }
        header('Location: index.php?controller=deposit&action=list');
        exit;

    default:
        header('Location: index.php?controller=deposit&action=list');
        exit;
}
?>
