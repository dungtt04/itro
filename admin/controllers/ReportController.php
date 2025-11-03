<?php
// controllers/ReportController.php
require_once __DIR__ . '/../models/ReportModel.php';
require_once __DIR__ . '/../db.php';

class ReportController {
    private $model;
    public function __construct($pdo) {
        $this->model = new ReportModel($pdo);
    }

    public function index() {
        $reports = $this->model->getAllReports();
        include __DIR__ . '/../views/report_list.php';
    }

    public function process() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->model->updateStatus($id, 'Đã xử lý');
        }
        header('Location: report_list.php');
        exit;
    }
}

// Router
$action = $_GET['action'] ?? 'index';
$controller = new ReportController($pdo);
if ($action === 'process') {
    $controller->process();
} else {
    $controller->index();
}
