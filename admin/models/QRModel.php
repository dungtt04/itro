<?php
// models/QRModel.php
require_once __DIR__ . '/../db.php';
class QRModel {
    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO nhatro_history (
            room, mmyy, addinfo, status, created_at, 
            electricity_id, water_id, 
            tien_phong, service_fee, tong_tien, discount, total_discount, room_id,
            e_old, e_new, e_used, e_unit_price, e_total,
            w_old, w_new, w_used, w_unit_price, w_total
        ) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['room'], $data['mmyy'], $data['addinfo'], $data['status'],
            $data['electricity_id'], $data['water_id'],
            $data['tien_phong'], $data['service_fee'], $data['tong_tien'], $data['discount'], $data['total_discount'], $data['room_id'],
            $data['e_old'], $data['e_new'], $data['e_used'], $data['e_unit_price'], $data['e_total'],
            $data['w_old'], $data['w_new'], $data['w_used'], $data['w_unit_price'], $data['w_total']
        ]);
    }
    public static function getUnpaid() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM nhatro_history WHERE status='Chưa thanh toán' ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
// <?php
// // models/QRModel.php
// require_once __DIR__ . '/../db.php';
// class QRModel {
//     public static function create($data) {
//         global $pdo;
//         $stmt = $pdo->prepare("INSERT INTO nhatro_history (room, mmyy, amount, addinfo, qr_url, status, created_at, electricity_id, water_id, so_nguoi, tien_phong, tong_tien, room_id) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?)");
//         return $stmt->execute([
//             $data['room'], $data['mmyy'], $data['amount'], $data['addinfo'], $data['qr_url'], $data['status'], $data['electricity_id'], $data['water_id'], $data['so_nguoi'], $data['tien_phong'], $data['tong_tien'], $data['room_id']
//         ]);
//     }
//     public static function getUnpaid() {
//         global $pdo;
//         $stmt = $pdo->prepare("SELECT * FROM nhatro_history WHERE status='Chưa thanh toán' ORDER BY created_at DESC");
//         $stmt->execute();
//         return $stmt->fetchAll();
//     }
// }
