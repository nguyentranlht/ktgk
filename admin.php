<?php
session_start();
require_once 'models/User.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Hệ Thống Đăng Ký Học</title>
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
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.06);
        }
        .card-title {
            color: #0d6efd;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        .badge {
            font-size: 90%;
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
        <a class="navbar-brand" href="index.php">📚 Đăng Ký Học</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link">👋 Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Đăng Xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-primary fw-bold">⚙️ Dashboard Quản Trị Viên</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card p-3 h-100 text-center">
                <h5 class="card-title">🎓 Quản Lý Sinh Viên</h5>
                <p class="card-text">Thêm, sửa, xóa sinh viên</p>
                <a href="manage_students.php" class="btn btn-primary">Quản Lý</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 h-100 text-center">
                <h5 class="card-title">👨‍🏫 Quản Lý Giảng Viên</h5>
                <p class="card-text">Thêm, sửa, xóa giảng viên</p>
                <a href="manage_teachers.php" class="btn btn-primary">Quản Lý</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 h-100 text-center">
                <h5 class="card-title">📘 Quản Lý Môn Học</h5>
                <p class="card-text">Quản lý các môn học</p>
                <a href="manage_courses.php" class="btn btn-primary">Quản Lý</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 h-100 text-center">
                <h5 class="card-title">🏫 Quản Lý Lớp Học</h5>
                <p class="card-text">Thông tin các lớp</p>
                <a href="manage_classes.php" class="btn btn-primary">Quản Lý</a>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="card-title">📊 Thống Kê Đăng Ký</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Môn Học</th>
                                <th>Số SV</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lập Trình Web</td>
                                <td>45</td>
                                <td><span class="badge bg-success">Đang Mở</span></td>
                            </tr>
                            <tr>
                                <td>Cơ Sở Dữ Liệu</td>
                                <td>38</td>
                                <td><span class="badge bg-success">Đang Mở</span></td>
                            </tr>
                            <tr>
                                <td>Lập Trình Java</td>
                                <td>42</td>
                                <td><span class="badge bg-warning text-dark">Sắp Đóng</span></td>
                            </tr>
                            <!-- Có thể thêm dữ liệu động từ DB -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="card-title">🕒 Hoạt Động Gần Đây</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">🧑 Sinh viên mới đăng ký</h6>
                            <small>5 phút trước</small>
                        </div>
                        <p class="mb-1">Nguyễn Văn A đã đăng ký môn Lập Trình Web</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">🛠 Cập nhật lớp học</h6>
                            <small>1 giờ trước</small>
                        </div>
                        <p class="mb-1">Lớp CSDL đã được cập nhật</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">👩‍🏫 Thêm giảng viên</h6>
                            <small>2 giờ trước</small>
                        </div>
                        <p class="mb-1">Trần Thị B đã được thêm vào hệ thống</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mt-5 py-3">
    <div class="container text-center">
        <p>&copy; 2024 Hệ Thống Đăng Ký Học. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>