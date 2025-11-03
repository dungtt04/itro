<?php
// models/CustomerPortalModel.php
require_once __DIR__ . '/../db.php';
class CustomerPortalModel {
    public static function declareCustomer($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO customer (name, phone, room, idcard, address) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'], $data['phone'], $data['room'], $data['idcard'], $data['address']
        ]);
    }
    public static function findInvoices($room, $month = null, $year = null) {
        global $pdo;
        $sql = "SELECT * FROM nhatro_history WHERE room = ?";
        $params = [$room];
        if ($month) {
            $sql .= " AND mmyy LIKE ?";
            $params[] = str_pad($month,2,'0',STR_PAD_LEFT) . ($year ? $year : '%');
        } elseif ($year) {
            $sql .= " AND mmyy LIKE ?";
            $params[] = '%' . $year;
        }
        $sql .= " ORDER BY mmyy DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
