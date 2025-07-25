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
}
