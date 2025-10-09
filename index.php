<?php
require_once __DIR__ . '/auth.php';

// index.php - Router trung tâm MVC
// Chỉ gọi session_start() nếu chưa có session
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$controller = $_GET['controller'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

// Route cho giao diện khách hàng
if ($controller === 'customer' && in_array($action, ['portal', 'lookup', 'declare'])) {
    require_once __DIR__ . '/controllers/CustomerController.php';
    return;
}


// if (!(isset($_GET['controller']) && $_GET['controller'] === 'history' && isset($_GET['action']) && $_GET['action'] === 'invoice')) {
//     renderMenu();
// }
switch ($controller) {
    // case 'customerportal':
    //     // Route riêng cho module khách hàng (portal, lookup, declare)
    //     require_once __DIR__ . '/controllers/CustomerPortalController.php';
    //     break;
    case '':
        // Route cho quản trị khách thuê
        require_once __DIR__ . '/controllers/DashboardController.php';
        break;
    case 'customer':
        // Route cho quản trị khách thuê
        require_once __DIR__ . '/controllers/CustomerController.php';
        break;
    case 'login':
        require_once __DIR__ . '/controllers/LoginController.php';
        break;
    case 'register':
        require_once __DIR__ . '/controllers/RegisterController.php';
        break;
    case 'dashboard':
        require_once __DIR__ . '/controllers/DashboardController.php';
        break;  
    case 'room':
        require_once __DIR__ . '/controllers/RoomController.php';
        break;
    case 'qr':
        require_once __DIR__ . '/controllers/QRController.php';
        break;
    case 'invoice':
        require_once __DIR__ . '/controllers/HistoryController.php';
        break;
    case 'electricity':
        require_once __DIR__ . '/controllers/ElectricityController.php';
        break;
    case 'water':
        require_once __DIR__ . '/controllers/WaterController.php';
        break;
    case 'report':
        require_once __DIR__ . '/controllers/ReportController.php';
        break;
    case 'admin':
        require_once __DIR__ . '/controllers/AdminController.php';
        break; 
    case 'account':
        require_once __DIR__ . '/controllers/AccountController.php';
        // $accountController = new AccountController();
        // if ($action == 'index') {
        //     $accountController->index();
        // }
        break;
        //Giải thích case 'account':  
        // require_once __DIR__ . '/controllers/AccountController.php';
        // $accountController = new AccountController(); // Tạo một instance của AccountController
        // if ($action == 'index') { // Kiểm tra nếu action là 'index'
        //     $accountController->index(); // Gọi phương thức index() của AccountController
        // }  

    
    default:
        // Mặc định route về dashboard
        require_once __DIR__ . '/controllers/DashboardController.php';
        break;
}

// Hiển thị thanh menu cho mọi trang
// <?php
// // index.php - Router trung tâm MVC
// // Chỉ gọi session_start() nếu chưa có session

// $controller = $_GET['controller'] ?? 'dashboard';
// $action = $_GET['action'] ?? 'index';

// // Route cho giao diện khách hàng
// if ($controller === 'customer' && in_array($action, ['portal', 'lookup', 'declare'])) {
//     require_once __DIR__ . '/controllers/CustomerController.php';
//     return;
// }


// // if (!(isset($_GET['controller']) && $_GET['controller'] === 'history' && isset($_GET['action']) && $_GET['action'] === 'invoice')) {
// //     renderMenu();
// // }
// switch ($controller) {
//     case 'customerportal':
//         // Route riêng cho module khách hàng (portal, lookup, declare)
//         require_once __DIR__ . '/controllers/CustomerPortalController.php';
//         break;
//     case 'customer':
//         // Route cho quản trị khách thuê
//         require_once __DIR__ . '/controllers/CustomerController.php';
//         break;
//     case 'login':
//         require_once __DIR__ . '/controllers/LoginController.php';
//         break;
//     case 'register':
//         require_once __DIR__ . '/controllers/RegisterController.php';
//         break;
//     case 'dashboard':
//         require_once __DIR__ . '/controllers/DashboardController.php';
//         break;  
//     case 'room':
//         require_once __DIR__ . '/controllers/RoomController.php';
//         break;
//     case 'qr':
//         require_once __DIR__ . '/controllers/QRController.php';
//         break;
//     case 'history':
//         require_once __DIR__ . '/controllers/HistoryController.php';
//         break;
//     case 'electricity':
//         require_once __DIR__ . '/controllers/ElectricityController.php';
//         break;
//     case 'water':
//         require_once __DIR__ . '/controllers/WaterController.php';
//         break;
    
//     default:
//         // Mặc định route về dashboard
//         require_once __DIR__ . '/controllers/DashboardController.php';
//         break;
// }

// // Hiển thị thanh menu cho mọi trang
