<?php
require_once __DIR__ . '/../db.php';
class UserModel {
    public static function login($username, $password) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    public static function register($username, $password) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            return 'exists';
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hash]);
    }
    public static function getAll() {
        $db = new PDO('mysql:host=localhost;dbname=generateqr;charset=utf8', 'root', '');
        $stmt = $db->query("SELECT * FROM admin");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //bổ sung hàm lấy user theo id
    public static function getById($id) {
        $db = new PDO('mysql:host=localhost;dbname=generateqr;charset=utf8', 'root', '');
        $stmt = $db->prepare("SELECT * FROM admin WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function updateStatus($id, $status) {
        $db = new PDO('mysql:host=localhost;dbname=generateqr;charset=utf8', 'root', '');
        $stmt = $db->prepare("UPDATE admin SET status = :status WHERE id = :id");
        $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public static function updateRole($id, $role) {
        $db = new PDO('mysql:host=localhost;dbname=generateqr;charset=utf8', 'root', '');
        $stmt = $db->prepare("UPDATE admin SET role = :role WHERE id = :id");
        $stmt->execute(['role' => $role, 'id' => $id]);
    }
    public static function updatePassword($id, $hashPassword) {
        $db = new PDO('mysql:host=localhost;dbname=generateqr;charset=utf8', 'root', '');
        $stmt = $db->prepare("UPDATE admin SET password = :password WHERE id = :id");
        $stmt->execute(['password' => $hashPassword, 'id' => $id]);
    }
}
