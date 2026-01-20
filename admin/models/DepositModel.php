<?php
// models/DepositModel.php
require_once __DIR__ . '/../db.php';

class DepositModel {
    
    // Lấy tất cả đặt cọc
    public static function getAll($sort = 'id', $order = 'DESC') {
        global $pdo;
        $allowedSort = ['id', 'room_id', 'name', 'deposit_amount', 'deposit_status', 'deposit_at'];
        $allowedOrder = ['ASC', 'DESC'];

        if (!in_array($sort, $allowedSort)) $sort = 'id';
        if (!in_array(strtoupper($order), $allowedOrder)) $order = 'DESC';

        $sql = "SELECT d.*, r.room_code, c.name as customer_name 
                FROM deposit d 
                LEFT JOIN room r ON d.room_id = r.id 
                LEFT JOIN customer c ON d.customer_id = c.id 
                ORDER BY d.$sort $order";
        return $pdo->query($sql)->fetchAll();
    }

    // Lấy đặt cọc theo ID
    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT d.*, r.room_code, c.name as customer_name 
                              FROM deposit d 
                              LEFT JOIN room r ON d.room_id = r.id 
                              LEFT JOIN customer c ON d.customer_id = c.id 
                              WHERE d.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Thêm đặt cọc mới
    public static function add($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO deposit (room_id, customer_id, name, deposit_amount, deposit_status, refund_status) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['room_id'],
            $data['customer_id'] ?? null,
            $data['name'],
            $data['deposit_amount'],
            'Chưa cọc',
            'Chưa trả phòng'
        ]);
    }

    // Cập nhật trạng thái thanh toán cọc
    public static function updateDepositPayment($id, $deposit_at = null) {
        global $pdo;
        $deposit_at = $deposit_at ?? date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("UPDATE deposit SET deposit_status = 'Đã cọc', deposit_at = ? WHERE id = ?");
        return $stmt->execute([$deposit_at, $id]);
    }

    // Cập nhật trạng thái trả cọc (hoàn tiền)
    public static function updateRefundStatus($id, $refund_amount, $refund_at = null) {
        global $pdo;
        $refund_at = $refund_at ?? date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("UPDATE deposit SET refund_status = 'Đã hoàn', refund_amount = ?, refund_at = ? WHERE id = ?");
        return $stmt->execute([$refund_amount, $refund_at, $id]);
    }

    // Cập nhật trạng thái không trả cọc
    public static function updateNoRefund($id, $refund_reason, $refund_at = null) {
        global $pdo;
        $refund_at = $refund_at ?? date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("UPDATE deposit SET refund_status = 'Không hoàn', refund_reason = ?, refund_amount = 0, refund_at = ? WHERE id = ?");
        return $stmt->execute([$refund_reason, $refund_at, $id]);
    }

    // Lấy đặt cọc theo phòng
    public static function getByRoomId($room_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM deposit WHERE room_id = ? ORDER BY created_at DESC");
        $stmt->execute([$room_id]);
        return $stmt->fetchAll();
    }

    // Kiểm tra phòng đã có đặt cọc chưa hoàn không
    public static function hasActiveDeposit($room_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM deposit WHERE room_id = ? AND refund_status != 'Đã hoàn' LIMIT 1");
        $stmt->execute([$room_id]);
        return $stmt->fetch() ? true : false;
    }

    // Xóa đặt cọc
    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM deposit WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Cập nhật thông tin đặt cọc
    public static function update($id, $data) {
        global $pdo;
        $fields = [];
        $values = [];
        
        if (isset($data['customer_id'])) {
            $fields[] = 'customer_id = ?';
            $values[] = $data['customer_id'];
        }
        if (isset($data['name'])) {
            $fields[] = 'name = ?';
            $values[] = $data['name'];
        }
        if (isset($data['deposit_amount'])) {
            $fields[] = 'deposit_amount = ?';
            $values[] = $data['deposit_amount'];
        }
        
        if (empty($fields)) return false;
        
        $values[] = $id;
        $sql = "UPDATE deposit SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($values);
    }

    // Lấy danh sách đặt cọc theo trạng thái
    public static function getByStatus($status) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT d.*, r.room_code, c.name as customer_name 
                              FROM deposit d 
                              LEFT JOIN room r ON d.room_id = r.id 
                              LEFT JOIN customer c ON d.customer_id = c.id 
                              WHERE d.deposit_status = ? 
                              ORDER BY d.id DESC");
        $stmt->execute([$status]);
        return $stmt->fetchAll();
    }

    // Lấy danh sách đặt cọc chưa hoàn
    public static function getPending() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT d.*, r.room_code, c.name as customer_name 
                              FROM deposit d 
                              LEFT JOIN room r ON d.room_id = r.id 
                              LEFT JOIN customer c ON d.customer_id = c.id 
                              WHERE d.refund_status = 'Không hoàn' 
                              ORDER BY d.id DESC");
        $stmt->execute([]);
        return $stmt->fetchAll();
    }
}
?>
