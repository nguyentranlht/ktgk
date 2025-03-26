<?php
session_start();
require_once '../../models/Student.php';

// Kiểm tra quyền truy cập
if (!isset($_SESSION['student'])) {
    header('Location: ../../login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$masv = $_GET['id'];

// Lấy thông tin sinh viên để xóa ảnh
$student = Student::getById($masv);
if ($student) {
    // Xóa ảnh nếu không phải ảnh mặc định
    if ($student['Hinh'] != 'default.jpg') {
        @unlink('../../public/images/' . $student['Hinh']);
    }
    
    // Xóa sinh viên
    if (Student::delete($masv)) {
        $_SESSION['success'] = "Xóa sinh viên thành công!";
    } else {
        $_SESSION['error'] = "Xóa sinh viên thất bại. Vui lòng thử lại.";
    }
} else {
    $_SESSION['error'] = "Không tìm thấy sinh viên!";
}

header('Location: index.php');
exit(); 