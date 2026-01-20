<?php
require_once __DIR__ . '/../models/Customer.php';

class PrivacyPolicyController {

    // Hiển thị view
    public static function index() {
        require __DIR__ . '/../views/privacy_policy.php';
    }

    // API: tìm customer theo CCCD
    public static function findByCccd() {
        $input = json_decode(file_get_contents('php://input'), true);
        $cccd = trim($input['cccd'] ?? '');

        if (!$cccd) {
            echo json_encode(['success' => false]);
            return;
        }

        $customer = Customer::findByCccd($cccd);

        if (!$customer) {
            echo json_encode(['success' => false]);
            return;
        }

        echo json_encode([
            'success' => true,
            'name' => $customer['name'],
            'dob' => $customer['dob'],
            'address' => $customer['address'],
            'room' => $customer['room'],
            'policy_status' => $customer['policy_status']
        ]);
    }

    // API: accept policy
    public static function acceptPolicy() {
        $input = json_decode(file_get_contents('php://input'), true);
        $cccd = trim($input['cccd'] ?? '');

        if (!$cccd) {
            echo json_encode(['success' => false]);
            return;
        }

        Customer::acceptPolicy($cccd);

        echo json_encode(['success' => true]);
    }
}
