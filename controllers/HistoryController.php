<?php
// controllers/HistoryController.php
// session_start();
require_once __DIR__ . '/../models/HistoryModel.php';
// if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
//     header('Location: index.php?controller=login');
//     exit;
// }
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

        // header('Location: index.php?controller=invoice&action=list');
        // exit;
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
            $stmt = $pdo->prepare('SELECT h.*, 
                e.total AS tien_dien, e.CSC AS CSC, e.CSM AS CSM, e.DTT AS DTT, 
                w.total AS tien_nuoc, w.CSC AS CSC_NUOC, w.CSM AS CSM_NUOC, w.DTT AS DTT_NUOC
                FROM nhatro_history h
                LEFT JOIN electricity e ON h.electricity_id = e.id
                LEFT JOIN water w ON h.water_id = w.id
                WHERE h.id=?');
            // giải thích câu lệnh SQL trên: Lấy tất cả các trường từ bảng 
            // nhatro_history (đặt bí danh là h), cùng với các trường CSC, CSM, 
            // DTT từ bảng electricity (đặt bí danh là e) và các trường CSC_NUOC,
            // CSM_NUOC, DTT_NUOC từ bảng water (đặt bí danh là w). Việc sử dụng 
            // LEFT JOIN đảm bảo rằng ngay cả khi không có bản ghi tương ứng trong 
            // bảng electricity hoặc water, các bản ghi từ bảng nhatro_history vẫn 
            // sẽ được bao gồm trong kết quả. Điều này rất hữu ích để hiển thị đầy đủ 
            // thông tin hóa đơn ngay cả khi không có dữ liệu điện hoặc nước cho một tháng cụ thể.
            $stmt->execute([$id]);
            $h = $stmt->fetch();
            // Đảm bảo các trường luôn tồn tại
            foreach (['CSC', 'CSM', 'DTT', 'CSC_NUOC', 'CSM_NUOC', 'DTT_NUOC', 'tien_dien', 'tien_nuoc'] as $k) {
                if (!isset($h[$k]) || $h[$k] === null) $h[$k] = '';
            }
        }
        if ($h) {
            include __DIR__ . '/../views/history_invoice.php';
        } else {
            echo 'Không tìm thấy hóa đơn!';
        }
        break;
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

    include __DIR__ . '/../views/history_list.php';
    break;
    // default:
    //     $history = HistoryModel::getAll();
    //     include __DIR__ . '/../views/history_list.php';
    //     break;
}
