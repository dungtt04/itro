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
}
