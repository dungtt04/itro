<?php
require_once __DIR__ . '/../db.php';
class RoomModel {
    public static function getAll() {
        global $pdo;
        return $pdo->query("SELECT * FROM room ORDER BY room_code")->fetchAll();
    }
    public static function add($room_code, $description) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO room (room_code, description) VALUES (?, ?)");
        return $stmt->execute([$room_code, $description]);
    }
    // Cập nhật trạng thái phòng
    public static function updateStatus($room_code, $status) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE room SET status=? WHERE room_code=?");
        return $stmt->execute([$status, $room_code]);
    }

    // Lấy mã phòng cao nhất hiện tại
    public static function getHighestRoomCode() {
        global $pdo;
        $result = $pdo->query("SELECT MAX(CAST(REGEXP_REPLACE(room_code, '[^0-9]', '') AS UNSIGNED)) as max_number FROM room")->fetch();
        return $result['max_number'] ?? 0;
    }

    // Tạo nhiều phòng cùng lúc
    public static function bulkCreate($quantity) {
        global $pdo;
        $highestNumber = self::getHighestRoomCode();
        $success = true;
        
        try {
            $pdo->beginTransaction();
            
            for ($i = 1; $i <= $quantity; $i++) {
                $newNumber = $highestNumber + $i;
                $newRoomCode = 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
                
                $stmt = $pdo->prepare("INSERT INTO room (room_code, description) VALUES (?, ?)");
                if (!$stmt->execute([$newRoomCode, 'Phòng ' . $newRoomCode])) {
                    throw new Exception('Lỗi khi tạo phòng ' . $newRoomCode);
                }
            }
            
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}
