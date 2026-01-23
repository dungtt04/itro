<?php
// controllers/HistoryController.php
// session_start();
require_once __DIR__ . '/../models/HistoryModel.php';
$action = $_GET['action'] ?? 'list';
switch ($action) {
    case 'mark_paid':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) HistoryModel::markPaid($id);
        $_SESSION['success_message'] = 'Thanh toán hóa đơn thành công!!';
        //Thêm check nếu thanh toán ở trang dashboard thì quay về dashboard
        if (isset($_GET['from']) && $_GET['from'] === 'dashboard') {
            header('Location: index.php?controller=dashboard');
            exit;
        } else {
            header('Location: index.php?controller=invoice&action=list');
            exit;
        }

    case 'delete':
        $id = (int)($_GET['id'] ?? 0);
        if ($id) HistoryModel::delete($id);
        header('Location: index.php?controller=invoice&action=list');
        exit;
    case 'invoice':
        $id = (int)($_GET['id'] ?? 0);
        $h = null;
        if ($id) {
            global $pdo;
            $stmt = $pdo->prepare('SELECT h.* 
                FROM nhatro_history h
                WHERE h.id=?');
            $stmt->execute([$id]);
$h = $stmt->fetch(PDO::FETCH_ASSOC);

if ($h === false) {
    // Không tồn tại hóa đơn
    $h = null;
} else {
    // Chỉ xử lý field khi CÓ hóa đơn
    $required_fields = [
        'e_old','e_new','e_used','e_unit_price','e_total',
        'w_old','w_new','w_used','w_unit_price','w_total',
        'service_fee','CSC','CSM','DTT',
        'CSC_NUOC','CSM_NUOC','DTT_NUOC',
        'tien_dien','tien_nuoc'
    ];

    foreach ($required_fields as $k) {
        if (!array_key_exists($k, $h) || $h[$k] === null) {
            $h[$k] = '';
        }
    }
}

        }
        include __DIR__ . '/../views/history/history_invoice.php';
        break;
    case 'mark_paid_bulk':
    if (!empty($_POST['selected_ids'])) {
        $ids = array_map('intval', $_POST['selected_ids']);
        HistoryModel::markPaidMultiple($ids);
        $_SESSION['success_message'] = 'Đã thanh toán ' . count($ids) . ' hóa đơn thành công!';
    } else {
        $_SESSION['error_message'] = 'Vui lòng chọn ít nhất một hóa đơn!';
    }
    header('Location: index.php?controller=invoice&action=list');
    exit;

case 'list':
default:
    require_once __DIR__ . '/../models/RoomModel.php';
    $roomList = RoomModel::getAll();

    // Lấy giá trị lọc từ GET
    $room = $_GET['room'] ?? '';
    $month = $_GET['month'] ?? '';
    $status = $_GET['status'] ?? '';

    // Lấy danh sách hóa đơn có lọc
    $history = HistoryModel::filter($room, $month, $status);

    include __DIR__ . '/../views/history/history_list.php';
    break;
    // default:
    //     $history = HistoryModel::getAll();
    //     include __DIR__ . '/../views/history_list.php';
    //     break;
}
