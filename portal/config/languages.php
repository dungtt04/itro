<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'vi';
}

$currentLang = $_SESSION['lang'];

$translations = [
    'vi' => [
        //Header
        'login' => 'Đăng nhập quản trị',
        //Home
        'welcome_title' => 'Phần mềm tra cứu hóa đơn dịch vụ phòng trọ',
        'start_button' => 'Bắt đầu',
        'user_guide' => 'Hướng dẫn sử dụng',
        'select_language' => 'Chọn ngôn ngữ',
        'privacy_policy' => 'Chính sách bảo vệ dữ liệu cá nhân',
        // History Form
        'bill_lookup' => 'Tra cứu hóa đơn',
        'enter_info' => 'Nhập thông tin để xem chi tiết hóa đơn phòng trọ',
        'room' => 'Phòng',
        'select_room' => '-- Chọn phòng --',
        'month' => 'Tháng',
        'select_month' => '-- Chọn tháng --',
        'month_number' => 'Tháng',
        // Month names (1-based index)
        'months' => [
            1 => 'Tháng 1',
            2 => 'Tháng 2',
            3 => 'Tháng 3',
            4 => 'Tháng 4',
            5 => 'Tháng 5',
            6 => 'Tháng 6',
            7 => 'Tháng 7',
            8 => 'Tháng 8',
            9 => 'Tháng 9',
            10 => 'Tháng 10',
            11 => 'Tháng 11',
            12 => 'Tháng 12',
        ],
        'year' => 'Năm',
        'year_placeholder' => 'VD: 2025',
        'search' => ' Tra cứu',
        'transaction_code' => 'Mã giao dịch',
        'feature_development' => '⚠️ Chức năng đang trong quá trình phát triển',
        'use_room_search' => 'Vui lòng sử dụng "Tra cứu theo phòng, tháng, năm"',
        // Motel Info
        'motel_name' => 'NHÀ TRỌ CHÚ QUẢNG',
        'motel_address' => 'Địa chỉ: Đội 6, thôn Minh Thành, Lai Khê, TP Hải Phòng',
        'motel_phone' => 'SĐT: 0352.153.772',
        // History Result
        'service_bill' => 'HÓA ĐƠN DỊCH VỤ PHÒNG TRỌ',
        'general_info' => 'Thông tin chung',
        'room_fee' => 'Tiền phòng',
        'service_fee' => 'Phí dịch vụ',
        'electricity_details' => 'Chi tiết điện',
        'water_details' => 'Chi tiết nước',
        'previous_reading' => 'CSC',
        'current_reading' => 'CSM',
        'consumption' => 'Tiêu thụ',
        'unit_price' => 'Đơn giá',
        'total_amount' => 'Tổng tiền',
        'summary' => 'Tổng kết',
        'discount' => 'Giảm giá',
        'amount_to_pay' => 'Cần thanh toán',
        'bill_paid' => '✅ Hóa đơn đã được thanh toán',
        'scan_to_pay' => 'Quét mã để thanh toán',
        'no_bill_found' => 'Không tìm thấy hóa đơn phù hợp.',
        'lookup_another' => 'Tra cứu hóa đơn khác',
        'status_paid' => 'Đã thanh toán'
    ],
    'en' => [
        //Header
        'login' => 'Admin Login',
        //Home
        'welcome_title' => 'Room Service Bill Lookup System',
        'start_button' => 'Start',
        'user_guide' => 'User Guide',
        'select_language' => 'Select Language',
        'privacy_policy' => 'Privacy Policy',
        // History Form
        'bill_lookup' => 'Bill Lookup',
        'enter_info' => 'Enter information to view room service bill details',
        'room' => 'Room',
        'select_room' => '-- Select Room --',
        'month' => 'Month',
        'select_month' => '-- Select Month --',
        'month_number' => 'Month',
        // Month names (1-based index)
        'months' => [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ],
        'year' => 'Year',
        'year_placeholder' => 'Ex: 2025',
        'search' => 'Search',
        'transaction_code' => 'Transaction Code',
        'feature_development' => '⚠️ Feature under development',
        'use_room_search' => 'Please use "Search by room, month, year"',
        // Motel Info
        'motel_name' => 'TANG TIEN QUANG MOTEL',
        'motel_address' => 'Address: Minh Thanh Village, Lai Khe, Hai Phong City',
        'motel_phone' => 'Phone: 0352.153.772',
        // History Result
        'service_bill' => 'ROOM SERVICE BILL',
        'general_info' => 'General Information',
        'room_fee' => 'Room Fee',
        'service_fee' => 'Service Fee',
        'electricity_details' => 'Electricity Details',
        'water_details' => 'Water Details',
        'previous_reading' => 'Previous',
        'current_reading' => 'Current',
        'consumption' => 'Usage',
        'unit_price' => 'Unit Price',
        'total_amount' => 'Total Amount',
        'summary' => 'Summary',
        'discount' => 'Discount',
        'amount_to_pay' => 'Amount to Pay',
        'bill_paid' => '✅ Bill has been paid',
        'scan_to_pay' => 'Scan to pay',
        'no_bill_found' => 'No matching bill found.',
        'lookup_another' => 'Look up another bill',
        'status_paid' => 'Paid'
    ]
];

// Get current language from session or default to Vietnamese
$currentLang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';

// Function to get translation
function t($key) {
    global $translations, $currentLang;
    
    if (!isset($translations[$currentLang][$key])) {
        // Log missing translation
        error_log("Missing translation for key: " . $key . " in language: " . $currentLang);
        // Fallback to Vietnamese if exists
        if (isset($translations['vi'][$key])) {
            return $translations['vi'][$key];
        }
        return $key; // Return key if no translation found
    }
    
    return $translations[$currentLang][$key];
}