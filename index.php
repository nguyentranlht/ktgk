<?php
session_start();
require_once 'models/Student.php';

$student = null;
if (isset($_SESSION['student'])) {
    $student = Student::getById($_SESSION['student']['MaSV']);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Đăng Ký Học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        * {
            transition: all 0.3s ease;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f4f9;
            color: #333;
        }
        .navbar {
            background-color: #0d6efd;
            padding: 12px 0;
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 500;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #cfe2ff !important;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
            padding: 20px;
            background-color: #fff;
        }
        .card-title {
            color: #0d6efd;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .student-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #0d6efd;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        .btn-success {
            background-color: #198754;
            border: none;
        }
        .btn-success:hover {
            background-color: #157347;
        }
        footer {
            background-color: #e9ecef;
            padding: 20px 0;
            margin-top: 60px;
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
                    <?php if (isset($_SESSION['student'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/dangky/views/students/index.php">Quản Lý Sinh Viên</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dangky/views/courses/list.php">Đăng Ký Học Phần</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dangky/views/courses/cart.php">Học Phần Đã Đăng Ký</a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">👋 Xin chào, <?php echo $_SESSION['student']['HoTen']; ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dangky/logout.php">Đăng Xuất</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/dangky/login.php">Đăng Nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dangky/register.php">Đăng Ký</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if (isset($_SESSION['student'])): ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 text-center">
                        <img src="public/images/<?php echo $student['Hinh']; ?>" alt="Ảnh sinh viên" class="student-image mb-3 mx-auto">
                        <h5 class="card-title">Thông tin sinh viên</h5>
                        <p><strong>Mã SV:</strong> <?php echo $student['MaSV']; ?></p>
                        <p><strong>Họ tên:</strong> <?php echo $student['HoTen']; ?></p>
                        <p><strong>Giới tính:</strong> <?php echo $student['GioiTinh']; ?></p>
                        <p><strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($student['NgaySinh'])); ?></p>
                        <p><strong>Ngành học:</strong> <?php echo $student['MaNganh']; ?></p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-4">
                        <h5 class="card-title">📌 Chức năng</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 text-center">
                                    <h6 class="card-title">📝 Đăng ký học phần</h6>
                                    <p class="card-text">Đăng ký các học phần cho học kỳ mới.</p>
                                    <a href="/dangky/views/courses/list.php" class="btn btn-primary">Đăng ký ngay</a>
                                </div>
                            </div>
                            <!-- Thêm các chức năng khác nếu có -->
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card text-center">
                        <h2 class="card-title">🎓 Chào mừng đến với Hệ Thống Đăng Ký Học</h2>
                        <p class="mb-4">Vui lòng đăng nhập hoặc đăng ký để bắt đầu sử dụng hệ thống.</p>
                        <a href="/dangky/login.php" class="btn btn-primary me-2">Đăng Nhập</a>
                        <a href="/dangky/register.php" class="btn btn-success">Đăng Ký</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container text-center">
            <p>&copy; 2024 Hệ Thống Đăng Ký Học. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>