<?php
// models/WaterModel.php
require_once __DIR__ . '/../db.php';
class WaterModel {
    public static function getAll() {
        global $pdo;
        $sql = "SELECT w.*, r.room_code FROM water w JOIN room r ON w.room_id = r.id ORDER BY w.month DESC, r.room_code ASC";
        return $pdo->query($sql)->fetchAll();
    }
    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM water WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public static function getLastByRoom($room_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM water WHERE room_id=? ORDER BY month DESC LIMIT 1");
        $stmt->execute([$room_id]);
        return $stmt->fetch();
    }
    public static function getByRoomAndMonth($room_id, $month) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM water WHERE room_id=? AND month=? LIMIT 1");
        $stmt->execute([$room_id, $month]);
        return $stmt->fetch();
    }
    public static function add($data) {
        global $pdo;        // month phải là dạng YYYY-MM
        $stmt = $pdo->prepare("INSERT INTO water (month, room_id, object_name, CSC, CSM, DTT, unit_price, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['month'], $data['room_id'], $data['object_name'], $data['CSC'], $data['CSM'], $data['DTT'], $data['unit_price'], $data['total']
        ]);
    }
    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE water SET month=?, room_id=?, object_name=?, CSC=?, CSM=?, DTT=?, total=? WHERE id=?");
        return $stmt->execute([
            $data['month'], $data['room_id'], $data['object_name'], $data['CSC'], $data['CSM'], $data['DTT'], $data['total'], $id
        ]);
    }
    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM water WHERE id=?");
        return $stmt->execute([$id]);
    }
    public static function getListByMonth($month) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT w.*, r.room_code FROM water w JOIN room r ON w.room_id = r.id WHERE w.month=?");
        $stmt->execute([$month]);
        return $stmt->fetchAll();
    }
    public static function getByRoomMonthObject($room_id, $month, $object_name) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM water WHERE room_id=? AND month=? AND object_name=? LIMIT 1");
        $stmt->execute([$room_id, $month, $object_name]);
        return $stmt->fetch();
    }
}
// <?php
// // models/WaterModel.php
// require_once __DIR__ . '/../db.php';
// class WaterModel {
//     public static function getAll() {
//         global $pdo;
//         $sql = "SELECT w.*, r.room_code FROM water w JOIN room r ON w.room_id = r.id ORDER BY w.month DESC, r.room_code ASC";
//         return $pdo->query($sql)->fetchAll();
//     }
//     public static function getById($id) {
//         global $pdo;
//         $stmt = $pdo->prepare("SELECT * FROM water WHERE id=?");
//         $stmt->execute([$id]);
//         return $stmt->fetch();
//     }
//     public static function getLastByRoom($room_id) {
//         global $pdo;
//         $stmt = $pdo->prepare("SELECT * FROM water WHERE room_id=? ORDER BY month DESC LIMIT 1");
//         $stmt->execute([$room_id]);
//         return $stmt->fetch();
//     }
//     public static function getByRoomAndMonth($room_id, $month) {
//         global $pdo;
//         $stmt = $pdo->prepare("SELECT * FROM water WHERE room_id=? AND month=? LIMIT 1");
//         $stmt->execute([$room_id, $month]);
//         return $stmt->fetch();
//     }
//     public static function add($data) {
//         global $pdo;
//         // month phải là dạng YYYY-MM
//         $stmt = $pdo->prepare("INSERT INTO water (month, room_id, object_name, CSC, CSM, DTT, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
//         return $stmt->execute([
//             $data['month'], $data['room_id'], $data['object_name'], $data['CSC'], $data['CSM'], $data['DTT'], $data['total']
//         ]);
//     }
//     public static function update($id, $data) {
//         global $pdo;
//         $stmt = $pdo->prepare("UPDATE water SET month=?, room_id=?, object_name=?, CSC=?, CSM=?, DTT=?, total=? WHERE id=?");
//         return $stmt->execute([
//             $data['month'], $data['room_id'], $data['object_name'], $data['CSC'], $data['CSM'], $data['DTT'], $data['total'], $id
//         ]);
//     }
//     public static function delete($id) {
//         global $pdo;
//         $stmt = $pdo->prepare("DELETE FROM water WHERE id=?");
//         return $stmt->execute([$id]);
//     }
//     public static function getListByMonth($month) {
//         global $pdo;
//         $stmt = $pdo->prepare("SELECT w.*, r.room_code FROM water w JOIN room r ON w.room_id = r.id WHERE w.month=?");
//         $stmt->execute([$month]);
//         return $stmt->fetchAll();
//     }
//     public static function getByRoomMonthObject($room_id, $month, $object_name) {
//         global $pdo;
//         $stmt = $pdo->prepare("SELECT * FROM water WHERE room_id=? AND month=? AND object_name=? LIMIT 1");
//         $stmt->execute([$room_id, $month, $object_name]);
//         return $stmt->fetch();
//     }
// }
