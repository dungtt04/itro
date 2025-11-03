<?php
// models/NhatroHistory.php
require_once __DIR__ . '/../config/database.php';
class NhatroHistory {
    public static function search($room, $month, $year) {
        global $pdo;
        $mmyy = sprintf('%02d%04d', $month, $year);
        $stmt = $pdo->prepare("SELECT * FROM nhatro_history WHERE room = ? AND mmyy = ?");
        $stmt->execute([$room, $mmyy]);
        return $stmt->fetchAll();
    }
}