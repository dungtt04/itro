<?php
// models/Customer.php
require_once __DIR__ . '/../config/database.php';

class Customer {

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO customer 
            (room, name, cccd, dob, cccd_date, cccd_place, address, phone, room_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['room'],
            $data['name'],
            $data['cccd'],
            $data['dob'],
            $data['cccd_date'],
            $data['cccd_place'],
            $data['address'],
            $data['phone'],
            $data['room_id']
        ]);
    }

    // 🔹 Tìm customer theo CCCD
    public static function findByCccd($cccd) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT id, room, name, dob, address, policy_status
            FROM customer
            WHERE cccd = ?
            LIMIT 1
        ");
        $stmt->execute([$cccd]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 Cập nhật policy_status = accept
    public static function acceptPolicy($cccd) {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE customer
            SET policy_status = 'accept'
            WHERE cccd = ?
        ");
        return $stmt->execute([$cccd]);
    }
}
