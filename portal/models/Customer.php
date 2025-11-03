<?php
// models/Customer.php
require_once __DIR__ . '/../config/database.php';
class Customer {
    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO customer (room, name, cccd, dob, cccd_date, cccd_place, address, phone, room_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['room'], $data['name'], $data['cccd'], $data['dob'], $data['cccd_date'], $data['cccd_place'], $data['address'], $data['phone'], $data['room_id']
        ]);
    }
}
