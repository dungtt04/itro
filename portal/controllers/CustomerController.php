<?php
// controllers/CustomerController.php
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../config/database.php';
class CustomerController {
    public function create() {
        global $pdo;
        $rooms = $pdo->query('SELECT id, room_code FROM room ORDER BY room_code')->fetchAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = isset($_POST['room_id']) && $_POST['room_id'] !== '' ? $_POST['room_id'] : null;
            $data = [
                'room' => $_POST['room'],
                'name' => $_POST['name'],
                'cccd' => $_POST['cccd'],
                'dob' => $_POST['dob'],
                'cccd_date' => $_POST['cccd_date'],
                'cccd_place' => $_POST['cccd_place'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'room_id' => $room_id
            ];
            $success = Customer::create($data);
            include __DIR__ . '/../views/customer_result.php';
        } else {
            include __DIR__ . '/../views/customer_form.php';
        }
    }
}
