<?php
$title = 'In mã QR';
$headContent = '';
ob_start();
?>
<!-- Nội dung in mã QR, bảng, thông tin, mã QR... -->
<?php // ...giữ nguyên phần nội dung in mã QR như cũ, chỉ bỏ html/head/body ?>
<?php /*
  Copy phần nội dung từ <body> ... </body> cũ vào đây nếu có
*/ ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
<?php
$title = 'In mã QR';
$headContent = '';
ob_start();
?>
<!-- Nội dung in mã QR, bảng, thông tin, mã QR... -->
<?php // ...giữ nguyên phần nội dung in mã QR như cũ, chỉ bỏ html/head/body ?>
<?php /*
  Copy phần nội dung từ <body> ... </body> cũ vào đây nếu có
*/ ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
