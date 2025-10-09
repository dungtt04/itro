<?php
// models/CustomerModel.php
require_once __DIR__ . '/../db.php';
class CustomerModel {
    public static function getAll() {
        global $pdo;
        return $pdo->query("SELECT * FROM customer ORDER BY room, name")->fetchAll();
    }
    public static function add($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO customer (room, name, cccd, dob, cccd_date, cccd_place, address, phone, room_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['room'], $data['name'], $data['cccd'], $data['dob'], $data['cccd_date'], $data['cccd_place'], $data['address'], $data['phone'], $data['room_id']
        ]);
    }
    // Trả phòng: cập nhật trạng thái, không xóa khỏi DB
    public static function traPhong($id) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE customer SET status='Trả phòng' WHERE id=?");
        return $stmt->execute([$id]);
    }
    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM customer WHERE id=?");
        return $stmt->execute([$id]);
    }
    public static function getNewIn7Days() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM customer WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function declareCustomer($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO customer (name, phone, room, idcard, address) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'], $data['phone'], $data['room'], $data['idcard'], $data['address']
        ]);
    }
    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM customer WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) {
            // Định dạng lại ngày sinh và ngày cấp nếu có dữ liệu
            if (!empty($row['dob']) && $row['dob'] !== '0000-00-00') {
                $row['dob'] = date('d/m/Y', strtotime($row['dob']));
            }
            if (!empty($row['cccd_date']) && $row['cccd_date'] !== '0000-00-00') {
                $row['cccd_date'] = date('d/m/Y', strtotime($row['cccd_date']));
            }
        }
        return $row;
    }
    public static function update($id, $data) {
                global $pdo;
        // $stmt = $pdo->prepare("UPDATE customer SET name=?, dob=?, cccd=?, cccd_date=?, cccd_place=?, address=?, phone=? WHERE id=?");

        $stmt = $pdo->prepare("UPDATE customer SET name=?, dob=?, cccd=?, cccd_date=?, cccd_place=?, address=?, phone=?, type_of_tenant=? WHERE id=?");
        $stmt->execute([
            $data['name'],
            $data['dob'],
            $data['cccd'],
            $data['cccd_date'],
            $data['cccd_place'],
            $data['address'],
            $data['phone'],
            $data['type_of_tenant'],
            $id
        ]);
    }
    public static function getByRoom($room_code) {
        // Giả sử dùng PDO
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM customer WHERE room = :room_code");
        $stmt->execute(['room_code' => $room_code]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getDB() {
        // Ví dụ dùng biến toàn cục $db hoặc tự tạo kết nối mới
        // Sửa lại cho phù hợp với project của bạn nếu đã có hàm kết nối
        static $db = null;
        if ($db === null) {
            $db = new PDO('mysql:host=localhost;dbname=generateqr;charset=utf8', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }
}
