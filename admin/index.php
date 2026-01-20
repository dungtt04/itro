<?php
require_once __DIR__ . '/auth.php';

// Cấu hình hiển thị lỗi (chỉ nên bật trong môi trường dev)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy controller & action từ URL (mặc định là dashboard/index)
$controller = $_GET['controller'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
// // Parse URL để lấy controller & action
// $url = $_SERVER['REQUEST_URI'];
// $url = str_replace('/itro/admin/', '', $url); // Adjust base path if necessary
// $url = trim($url, '/');
// $parts = explode('/', $url);

// // Mặc định controller và action
// $controller = $parts[0] ?? 'dashboard';
// $action = $parts[1] ?? 'index';
// Router cho giao diện khách hàng (không qua auth)
if ($controller === 'customer' && in_array($action, ['portal', 'lookup', 'declare'])) {
    require_once __DIR__ . '/controllers/CustomerController.php';
    return;
}

// Danh sách controller hợp lệ
$controllers = [
    'dashboard'   => 'DashboardController',
    'customer'    => 'CustomerController',
    'login'       => 'LoginController',
    'register'    => 'RegisterController',
    'room'        => 'RoomController',
    'qr'          => 'QRController',
    'invoice'     => 'HistoryController',  // bạn dùng 'invoice' thay cho 'history'
    'electricity' => 'ElectricityController',
    'water'       => 'WaterController',
    'deposit'     => 'DepositController',
    'report'      => 'ReportController',
    // 'admin'       => 'AdminController',
    'account'     => 'AccountController',
];

// Nếu controller không hợp lệ → về dashboard
$controllerFile = $controllers[$controller] ?? $controllers['dashboard'];

// Require file controller tương ứng
require_once __DIR__ . '/controllers/' . $controllerFile . '.php';
