<?php
// controllers/ReportController.php
require_once __DIR__ . '/../models/Report.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';
class ReportController {
    public function create() {
        global $pdo;
        $rooms = $pdo->query('SELECT id, room_code FROM room ORDER BY room_code')->fetchAll();
        $success = false;
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = $_POST['room_id'] ?? '';
            $type = $_POST['type'] ?? '';
            $detail = $_POST['detail'] ?? '';
            if ($room_id && $type && $detail) {
                $data = [
                    'room_id' => $room_id,
                    'type' => $type,
                    'detail' => $detail
                ];
                $success = Report::create($data);
                // Gửi mail bằng PHPMailer
                $mailConfig = require __DIR__ . '/../config/mail.php';
                $room_code = '';
                foreach ($rooms as $r) if ($r['id'] == $room_id) $room_code = $r['room_code'];
                $body = "Phòng: $room_code<br>Thiết bị gặp sự cố: $type<br>Chi tiết: $detail";
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = $mailConfig['host'];
                    $mail->SMTPAuth = true;
                    $mail->Username = $mailConfig['username'];
                    $mail->Password = $mailConfig['password'];
                    $mail->SMTPSecure = $mailConfig['encryption'];
                    $mail->Port = $mailConfig['port'];
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom($mailConfig['from'], $mailConfig['from_name']);
                    $mail->addAddress('dungtt197@gmail.com');
                    $mail->isHTML(true);
                    $mail->Subject = 'Báo cáo sự cố từ khách hàng';
                    $mail->Body = $body;
                    $mail->send();
                } catch (Exception $e) {
                    $error = 'Gửi mail thất bại: ' . $mail->ErrorInfo;
                }
            } else {
                $error = 'Vui lòng nhập đầy đủ thông tin.';
            }
        }
        include __DIR__ . '/../views/report_form.php';
    }
}
<?php
// controllers/ReportController.php
require_once __DIR__ . '/../models/Report.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';
class ReportController {
    public function create() {
        global $pdo;
        $rooms = $pdo->query('SELECT id, room_code FROM room ORDER BY room_code')->fetchAll();
        $success = false;
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = $_POST['room_id'] ?? '';
            $type = $_POST['type'] ?? '';
            $detail = $_POST['detail'] ?? '';
            if ($room_id && $type && $detail) {
                $data = [
                    'room_id' => $room_id,
                    'type' => $type,
                    'detail' => $detail
                ];
                $success = Report::create($data);
                // Gửi mail bằng PHPMailer
                $mailConfig = require __DIR__ . '/../config/mail.php';
                $room_code = '';
                foreach ($rooms as $r) if ($r['id'] == $room_id) $room_code = $r['room_code'];
                $body = "Phòng: $room_code<br>Thiết bị gặp sự cố: $type<br>Chi tiết: $detail";
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = $mailConfig['host'];
                    $mail->SMTPAuth = true;
                    $mail->Username = $mailConfig['username'];
                    $mail->Password = $mailConfig['password'];
                    $mail->SMTPSecure = $mailConfig['encryption'];
                    $mail->Port = $mailConfig['port'];
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom($mailConfig['from'], $mailConfig['from_name']);
                    $mail->addAddress('dungtt197@gmail.com');
                    $mail->isHTML(true);
                    $mail->Subject = 'Báo cáo sự cố từ khách hàng';
                    $mail->Body = $body;
                    $mail->send();
                } catch (Exception $e) {
                    $error = 'Gửi mail thất bại: ' . $mail->ErrorInfo;
                }
            } else {
                $error = 'Vui lòng nhập đầy đủ thông tin.';
            }
        }
        include __DIR__ . '/../views/report_form.php';
    }
}
