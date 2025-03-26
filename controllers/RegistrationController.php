<?php
session_start();
require_once __DIR__ . '/../models/Registration.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    if (!isset($_SESSION['user'])) {
        header("Location: ../login.php");
        exit();
    }

    $userId = $_SESSION['user']['id'];
    $selectedCourses = $_POST['selected_courses'];

    if (Registration::registerCourses($userId, $selectedCourses)) {
        $_SESSION['success'] = "Đăng ký học phần thành công!";
    } else {
        $_SESSION['error'] = "Có lỗi xảy ra khi đăng ký!";
    }

    header("Location: ../views/courses/cart.php");
    exit();
}
?>