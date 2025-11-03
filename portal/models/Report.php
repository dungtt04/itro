<?php
// models/Report.php
require_once __DIR__ . '/../config/database.php';
class Report {
    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO report (room_id, type, detail) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['room_id'], $data['type'], $data['detail']
        ]);
    }
}
