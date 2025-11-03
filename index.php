<?php
require_once __DIR__ . '/portal/config/languages.php';
// index.php - Router đơn giản
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session at the very beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default language if not set
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'vi';
}

// Debug information
error_log('Session ID: ' . session_id());
error_log('Current Language: ' . ($_SESSION['lang'] ?? 'not set'));

// Handle language switching
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'vi'])) {
    $_SESSION['lang'] = $_GET['lang'];
    // Redirect back to the same page without the lang parameter
    $redirectUrl = strtok($_SERVER['REQUEST_URI'], '?');
    if (isset($_GET['action'])) {
        $redirectUrl .= '?action=' . $_GET['action'];
    }
    header('Location: ' . $redirectUrl);
    exit;
}

$action = $_GET['action'] ?? '';
switch ($action) {
    case 'customer_create':
        require_once __DIR__ . '/portal/controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->create();
        break;
    case 'history_search':
        require_once __DIR__ . '/portal/controllers/NhatroHistoryController.php';
        $controller = new NhatroHistoryController();
        $controller->search();
        break;
    case 'history_detail':
        require_once __DIR__ . '/portal//controllers/NhatroHistoryController.php';
        $controller = new NhatroHistoryController();
        $controller->detail();
        break;
    default:
        include __DIR__ . '/portal/views/home.php';
        break;
}
