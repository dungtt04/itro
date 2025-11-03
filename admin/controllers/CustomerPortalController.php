<?php
// controllers/CustomerPortalController.php
require_once __DIR__ . '/../models/CustomerPortalModel.php';
$action = $_GET['action'] ?? 'portal';

switch ($action) {
    case 'portal':
        ob_start();
        include __DIR__ . '/../views/customer_portal.php';
        $content = ob_get_clean();
        $title = 'Cổng khách hàng';
        include __DIR__ . '/../views/layout.php';
        break;
    case 'lookup':
        $invoices = [];
        if (!empty($_GET['room']) && !empty($_GET['year'])) {
            $room = trim($_GET['room']);
            $month = !empty($_GET['month']) ? intval($_GET['month']) : null;
            $year = intval($_GET['year']);
            $invoices = CustomerPortalModel::findInvoices($room, $month, $year);
        }
        ob_start();
        include __DIR__ . '/../views/customer_invoice_lookup.php';
        $content = ob_get_clean();
        $title = 'Tra cứu hóa đơn';
        include __DIR__ . '/../views/layout.php';
        break;
    case 'declare':
        $success = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'room' => trim($_POST['room'] ?? ''),
                'idcard' => trim($_POST['idcard'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
            ];
            if (CustomerPortalModel::declareCustomer($data)) {
                $success = true;
            }
        }
        ob_start();
        include __DIR__ . '/../views/customer_declare.php';
        $content = ob_get_clean();
        $title = 'Khai báo thông tin khách hàng';
        include __DIR__ . '/../views/layout.php';
        break;
    default:
        ob_start();
        include __DIR__ . '/../views/customer_portal.php';
        $content = ob_get_clean();
        $title = 'Cổng khách hàng';
        include __DIR__ . '/../views/layout.php';
        break;
}
