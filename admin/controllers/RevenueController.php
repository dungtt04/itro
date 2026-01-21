<?php
// controllers/RevenueController.php
require_once __DIR__ . '/../models/HistoryModel.php';
require_once __DIR__ . '/../room_helper.php';

$action = $_GET['action'] ?? 'monthly';

// Default year and month
$currentYear = date('Y');
$currentMonth = date('m');
$year = $_GET['year'] ?? $currentYear;
$month = $_GET['month'] ?? $currentMonth;

switch ($action) {
    case 'monthly':
        // Thống kê doanh thu theo tháng
        $monthlyStats = HistoryModel::getMonthlyStats($month, $year);
        $monthlyRevenueByRoom = HistoryModel::getMonthlyRevenueByRoom($month, $year);
        
        include __DIR__ . '/../views/revenue_monthly.php';
        break;
        
    case 'yearly':
        // Thống kê doanh thu theo năm
        $yearlyStats = HistoryModel::getYearlyStats($year);
        $monthlyRevenueInYear = HistoryModel::getMonthlyRevenueByYear($year);
        $yearlyAllStats = HistoryModel::getYearlyRevenueAll();
        
        include __DIR__ . '/../views/revenue_yearly.php';
        break;
        
    case 'comparison':
        // So sánh doanh thu qua các năm
        $yearlyAllStats = HistoryModel::getYearlyRevenueAll();
        
        include __DIR__ . '/../views/revenue_comparison.php';
        break;
        
    default:
        $monthlyStats = HistoryModel::getMonthlyStats($month, $year);
        $monthlyRevenueByRoom = HistoryModel::getMonthlyRevenueByRoom($month, $year);
        
        include __DIR__ . '/../views/revenue_monthly.php';
        break;
}
?>
