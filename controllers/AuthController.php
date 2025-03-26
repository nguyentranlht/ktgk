<?php
session_start();
require_once __DIR__ . '/../models/User.php';

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = User::login($username, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}

// Xử lý đăng ký tài khoản
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Lựa chọn "admin" hoặc "student"

    if (User::register($username, $password, $role)) {
        $success = "Đăng ký thành công! Bạn có thể đăng nhập.";
    } else {
        $error = "Lỗi khi đăng ký tài khoản!";
    }
}
?>