<?php
session_start();
require_once '../../models/Student.php';

if (!isset($_SESSION['student'])) {
    header('Location: ../../login.php');
    exit();
}

$students = Student::getAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sinh Viên - Hệ Thống Đăng Ký Học</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.06);
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-sm i {
            margin-right: 4px;
        }
        footer {
            background-color: #e9ecef;
            font-size: 14px;
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
                    <span class="nav-link">👋 Xin chào, <?php echo $_SESSION['student']['HoTen']; ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../logout.php">Đăng Xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">📋 Quản Lý Sinh Viên</h2>
        <a href="create.php" class="btn btn-primary">
            ➕ Thêm Sinh Viên
        </a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã SV</th>
                        <th>Họ Tên</th>
                        <th>Giới Tính</th>
                        <th>Ngày Sinh</th>
                        <th>Ngành Học</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= $student['MaSV']; ?></td>
                            <td><?= $student['HoTen']; ?></td>
                            <td><?= $student['GioiTinh']; ?></td>
                            <td><?= date('d/m/Y', strtotime($student['NgaySinh'])); ?></td>
                            <td><?= $student['TenNganh']; ?></td>
                            <td>
                                <a href="detail.php?id=<?= $student['MaSV']; ?>" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Chi Tiết
                                </a>
                                <a href="edit.php?id=<?= $student['MaSV']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <a href="delete.php?id=<?= $student['MaSV']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?')">
                                    <i class="bi bi-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="6">Không có sinh viên nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="mt-5 py-3">
    <div class="container text-center">
        <p>&copy; 2024 Hệ Thống Đăng Ký Học. All rights reserved.</p>
    </div>
</footer>

<!-- Bootstrap JS & Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>