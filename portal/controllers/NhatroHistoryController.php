<?php
// controllers/NhatroHistoryController.php
require_once __DIR__ . '/../models/NhatroHistory.php';
require_once __DIR__ . '/../config/database.php';
class NhatroHistoryController {
    public function search() {
        global $pdo;
        // Lấy danh sách phòng
        $rooms = $pdo->query('SELECT id, room_code FROM room ORDER BY room_code')->fetchAll();
        $results = [];
        $searchType = $_POST['search_type'] ?? 'month';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($searchType === 'code') {
                $addinfo = $_POST['addinfo'] ?? '';
                if ($addinfo !== '') {
                    $stmt = $pdo->prepare('SELECT * FROM nhatro_history WHERE addinfo = ?');
                    $stmt->execute([$addinfo]);
                    $results = $stmt->fetchAll();
                }
            } else {
                $room = $_POST['room'];
                $month = $_POST['month'];
                $year = $_POST['year'];
                $results = NhatroHistory::search($room, $month, $year);
            }
            include __DIR__ . '/../views/history_result.php';
        } else {
            include __DIR__ . '/../views/history_form.php';
        }
    }
    public function detail() {
        global $pdo;
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $stmt = $pdo->prepare('SELECT * FROM nhatro_history WHERE id = ?');
        $stmt->execute([$id]);
        $bill = $stmt->fetch();
        $electric = null;
        $water = null;
        if ($bill) {
            if ($bill['electricity_id']) {
                $stmt2 = $pdo->prepare('SELECT * FROM electricity WHERE id = ?');
                $stmt2->execute([$bill['electricity_id']]);
                $electric = $stmt2->fetch();
            }
            if ($bill['water_id']) {
                $stmt3 = $pdo->prepare('SELECT * FROM water WHERE id = ?');
                $stmt3->execute([$bill['water_id']]);
                $water = $stmt3->fetch();
            }
        }
        include __DIR__ . '/../views/history_detail.php';
    }
}
