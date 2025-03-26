<?php
require_once __DIR__ . '/../models/Student.php';

// Lấy danh sách sinh viên
if (isset($_GET['action']) && $_GET['action'] == 'list') {
    $students = Student::getAll();
    include __DIR__ . '/../views/students/index.php';
}

// Thêm sinh viên
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    Student::create($_POST['id'], $_POST['name'], $_POST['gender'], $_POST['dob'], $_POST['image'], $_POST['major']);
    header("Location: StudentController.php?action=list");
}

// Sửa sinh viên
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    Student::update($_POST['id'], $_POST['name'], $_POST['gender'], $_POST['dob'], $_POST['image'], $_POST['major']);
    header("Location: StudentController.php?action=list");
}

// Xóa sinh viên
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    Student::delete($_GET['id']);
    header("Location: StudentController.php?action=list");
}
?>