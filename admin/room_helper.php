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
function getRoomCodeById($pdo, $room_id) {
    $stmt = $pdo->prepare("SELECT room_code FROM room WHERE id = ?");
    $stmt->execute([$room_id]);
    $row = $stmt->fetch();
    return $row ? $row['room_code'] : null;
}

?>