<?php
// models/ReportModel.php
require_once __DIR__ . '/../db.php';

class ReportModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllReports() {
        $stmt = $this->pdo->query('SELECT report.*, room.room_code as room_code FROM report JOIN room ON report.room_id = room.id ORDER BY report.id DESC');
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare('UPDATE report SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }
}
