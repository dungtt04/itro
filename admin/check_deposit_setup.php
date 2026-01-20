<?php
/**
 * Tệp kiểm tra setup chức năng Quản lý Đặt Cọc
 * Truy cập: http://localhost/itro/admin/check_deposit_setup.php
 */

echo "<h1>✅ Kiểm Tra Setup Chức Năng Quản Lý Đặt Cọc</h1>";
echo "<hr>";

$errors = [];
$warnings = [];
$success = [];

// 1. Kiểm tra file tồn tại
echo "<h2>1. Kiểm Tra File Tồn Tại</h2>";

$files = [
    'models/DepositModel.php' => 'Model',
    'controllers/DepositController.php' => 'Controller',
    'views/deposit_list.php' => 'View - Danh sách',
    'views/deposit_add.php' => 'View - Thêm',
    'views/deposit_refund.php' => 'View - Trả phòng',
    'setup_deposit.php' => 'Setup script',
    'migrations/create_deposit_table.sql' => 'SQL migration'
];

$baseDir = __DIR__;
foreach ($files as $file => $desc) {
    $fullPath = $baseDir . '/' . $file;
    if (file_exists($fullPath)) {
        echo "✅ $desc: $file<br>";
        $success[] = $file;
    } else {
        echo "❌ $desc: $file<br>";
        $errors[] = "File không tồn tại: $file";
    }
}

// 2. Kiểm tra routing
echo "<h2>2. Kiểm Tra Routing</h2>";
$indexFile = file_get_contents($baseDir . '/index.php');
if (strpos($indexFile, "'deposit'") !== false && strpos($indexFile, "DepositController") !== false) {
    echo "✅ Route 'deposit' => 'DepositController' đã được thêm<br>";
    $success[] = "Route deposit";
} else {
    echo "❌ Route 'deposit' chưa được thêm<br>";
    $errors[] = "Route deposit chưa được thêm vào index.php";
}

// 3. Kiểm tra menu
echo "<h2>3. Kiểm Tra Menu</h2>";
$layoutFile = file_get_contents($baseDir . '/views/layout.php');
if (strpos($layoutFile, "controller=deposit") !== false) {
    echo "✅ Link menu 'Đặt cọc' đã được thêm<br>";
    $success[] = "Menu link";
} else {
    echo "❌ Link menu 'Đặt cọc' chưa được thêm<br>";
    $errors[] = "Menu link chưa được thêm vào layout.php";
}

// 4. Kiểm tra database
echo "<h2>4. Kiểm Tra Database</h2>";
require_once 'db.php';

try {
    $result = $pdo->query("SELECT COUNT(*) as count FROM information_schema.TABLES WHERE TABLE_NAME = 'deposit'")->fetch();
    
    if ($result['count'] > 0) {
        echo "✅ Bảng 'deposit' đã tồn tại<br>";
        $success[] = "Bảng deposit";
        
        // Kiểm tra cấu trúc bảng
        $columns = $pdo->query("SHOW COLUMNS FROM deposit")->fetchAll();
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Trường</th><th>Kiểu</th><th>Null</th><th>Khóa</th></tr>";
        foreach ($columns as $col) {
            echo "<tr>";
            echo "<td>{$col['Field']}</td>";
            echo "<td>{$col['Type']}</td>";
            echo "<td>{$col['Null']}</td>";
            echo "<td>{$col['Key']}</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    } else {
        echo "⚠️ Bảng 'deposit' chưa tồn tại<br>";
        echo "👉 Chạy: <a href='setup_deposit.php' target='_blank'>setup_deposit.php</a><br>";
        $warnings[] = "Bảng deposit chưa được tạo";
    }
} catch (Exception $e) {
    echo "❌ Lỗi kết nối database: " . htmlspecialchars($e->getMessage()) . "<br>";
    $errors[] = $e->getMessage();
}

// 5. Kiểm tra helper function
echo "<h2>5. Kiểm Tra Helper Function</h2>";
$helperFile = file_get_contents($baseDir . '/room_helper.php');
if (strpos($helperFile, "getRoomCodeById") !== false) {
    echo "✅ Function 'getRoomCodeById()' đã được thêm<br>";
    $success[] = "Helper function";
} else {
    echo "❌ Function 'getRoomCodeById()' chưa được thêm<br>";
    $errors[] = "Helper function getRoomCodeById chưa được thêm";
}

// 6. Kiểm tra CustomerModel update
echo "<h2>6. Kiểm Tra CustomerModel</h2>";
$customerModel = file_get_contents($baseDir . '/models/CustomerModel.php');
if (strpos($customerModel, "lastInsertId") !== false) {
    echo "✅ CustomerModel::add() đã được cập nhật để return ID<br>";
    $success[] = "CustomerModel update";
} else {
    echo "⚠️ CustomerModel::add() có thể chưa trả về ID<br>";
    $warnings[] = "CustomerModel::add() có thể chưa được cập nhật";
}

// Tóm tắt
echo "<hr>";
echo "<h2>📊 Tóm Tắt</h2>";
echo "<p>✅ Thành công: " . count($success) . " mục</p>";
echo "<p>⚠️ Cảnh báo: " . count($warnings) . " mục</p>";
echo "<p>❌ Lỗi: " . count($errors) . " mục</p>";

if (empty($errors)) {
    if (empty($warnings)) {
        echo "<p style='color:green; font-weight:bold;'>🎉 Setup hoàn chỉnh! Bạn có thể bắt đầu sử dụng.</p>";
        echo "<p><a href='index.php?controller=deposit&action=list' style='background:#093d62; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Truy cập Quản lý Đặt Cọc →</a></p>";
    } else {
        echo "<p style='color:orange; font-weight:bold;'>⚠️ Có " . count($warnings) . " cảnh báo. Bạn vẫn có thể sử dụng, nhưng nên kiểm tra lại.</p>";
        foreach ($warnings as $w) {
            echo "<p>⚠️ $w</p>";
        }
    }
} else {
    echo "<p style='color:red; font-weight:bold;'>❌ Có " . count($errors) . " lỗi. Vui lòng khắc phục:</p>";
    foreach ($errors as $e) {
        echo "<p>❌ $e</p>";
    }
}
?>

<style>
    body { font-family: Arial, sans-serif; background: #f6f8fa; padding: 20px; }
    h1, h2 { color: #093d62; }
    table { border-collapse: collapse; margin: 10px 0; }
    td, th { padding: 8px; border: 1px solid #bfc7d1; }
    th { background: #e3eafc; }
    a { color: #093d62; }
    hr { border: none; border-top: 2px solid #e3eafc; }
</style>
