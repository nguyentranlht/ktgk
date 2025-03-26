<?php
session_start();
require_once 'models/User.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sinh Viên - Hệ Thống Đăng Ký Học</title>
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
    <h2 class="mb-4 text-primary fw-bold">📊 Dashboard Sinh Viên</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5 class="card-title">📝 Đăng Ký Môn Học</h5>
                <p class="card-text">Đăng ký các môn học cho học kỳ mới.</p>
                <a href="register_course.php" class="btn btn-primary">Đăng Ký</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5 class="card-title">📅 Lịch Học</h5>
                <p class="card-text">Xem thời khóa biểu chi tiết.</p>
                <a href="schedule.php" class="btn btn-primary">Xem Lịch</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h5 class="card-title">📈 Kết Quả Học Tập</h5>
                <p class="card-text">Xem điểm số, GPA và kết quả từng môn.</p>
                <a href="grades.php" class="btn btn-primary">Xem Kết Quả</a>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="card-title">📚 Môn Học Đã Đăng Ký</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Môn Học</th>
                                <th>Giảng Viên</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lập Trình Web</td>
                                <td>Nguyễn Văn A</td>
                                <td><span class="badge bg-success">Đã Đăng Ký</span></td>
                            </tr>
                            <tr>
                                <td>Cơ Sở Dữ Liệu</td>
                                <td>Trần Thị B</td>
                                <td><span class="badge bg-success">Đã Đăng Ký</span></td>
                            </tr>
                            <!-- Thêm các dòng dữ liệu động ở đây -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="card-title">🔔 Thông Báo</h5>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">🕐 Thời gian đăng ký môn học</h6>
                            <small>3 ngày trước</small>
                        </div>
                        <p class="mb-1">Bắt đầu từ ngày 01/04/2024</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">📅 Lịch thi học kỳ</h6>
                            <small>1 tuần trước</small>
                        </div>
                        <p class="mb-1">Xem lịch thi chi tiết tại đây</p>
                    </a>
                    <!-- Thêm các thông báo khác -->
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