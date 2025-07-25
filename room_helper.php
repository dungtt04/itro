<?php
require_once 'db.php';
function getRoomList($pdo) {
    $rooms = $pdo->query("SELECT * FROM room ORDER BY room_code")->fetchAll();
    return $rooms;
}
function getRoomIdByCode($pdo, $room_code) {
    $stmt = $pdo->prepare("SELECT id FROM room WHERE room_code = ?");
    $stmt->execute([$room_code]);
    $row = $stmt->fetch();
    return $row ? $row['id'] : null;
}
