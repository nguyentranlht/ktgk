<?php
session_start();
require_once '../../models/Student.php';

if (!isset($_SESSION['student'])) {
    header('Location: ../../login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$student = Student::getById($_GET['id']);
if (!$student) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Sinh Viên - Hệ Thống Đăng Ký Học</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap + Roboto font -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f4f9;
        }
        .navbar {
            background-color: #0d6efd;
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 500;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.06);
        }
        .student-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
            border: 4px solid #0d6efd;
        }
        table th {
            width: 150px;
            color: #333;
        }
        footer {
            background-color: #e9ecef;
            font-size: 14px;
        }
        .btn {
            font-weight: 500;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="../../index.php">📚 Đăng Ký Học</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Quản Lý Sinh Viên</a>
                </li>
                <li class="nav-item">
                    <span class="nav-link">👋 Xin chào, <?= $_SESSION['student']['HoTen']; ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../logout.php">Đăng Xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5 mb-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card p-4">
                <h2 class="text-center text-primary fw-bold mb-4">📄 Chi Tiết Sinh Viên</h2>

                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <img src="../../public/images/<?= $student['Hinh']; ?>" 
                             alt="Ảnh sinh viên" 
                             class="student-image img-thumbnail">
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th>Mã Sinh Viên:</th>
                                <td><?= $student['MaSV']; ?></td>
                            </tr>
                            <tr>
                                <th>Họ và tên:</th>
                                <td><?= $student['HoTen']; ?></td>
                            </tr>
                            <tr>
                                <th>Giới tính:</th>
                                <td><?= $student['GioiTinh']; ?></td>
                            </tr>
                            <tr>
                                <th>Ngày sinh:</th>
                                <td><?= date('d/m/Y', strtotime($student['NgaySinh'])); ?></td>
                            </tr>
                            <tr>
                                <th>Ngành học:</th>
                                <td><?= $student['MaNganh']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="edit.php?id=<?= $student['MaSV']; ?>" class="btn btn-warning">✏️ Sửa Thông Tin</a>
                    <a href="index.php" class="btn btn-secondary">⬅️ Quay Lại Danh Sách</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="py-3">
    <div class="container text-center">
        <p>&copy; 2024 Hệ Thống Đăng Ký Học. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>