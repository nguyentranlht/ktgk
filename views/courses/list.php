<?php
session_start();
require_once '../../models/Course.php';
require_once '../../models/Registration.php';

if (!isset($_SESSION['student'])) {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $selectedCourses = isset($_POST['selected_courses']) ? $_POST['selected_courses'] : [];
    if (!empty($selectedCourses)) {
        if (Registration::registerCourses($_SESSION['student']['MaSV'], $selectedCourses)) {
            $_SESSION['success'] = "✅ Đăng ký học phần thành công!";
        } else {
            $_SESSION['error'] = "❌ Có lỗi xảy ra khi đăng ký học phần!";
        }
    } else {
        $_SESSION['error'] = "⚠️ Vui lòng chọn ít nhất một học phần!";
    }
    header('Location: list.php');
    exit();
}

$courses = Course::getAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Học Phần</title>
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
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.06);
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
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
    <div class="card p-4">
        <h4 class="mb-4 text-primary fw-bold">📘 Danh Sách Học Phần</h4>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Chọn</th>
                            <th>Mã HP</th>
                            <th>Tên Học Phần</th>
                            <th>Số Tín Chỉ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_courses[]" value="<?= $course['MaHP'] ?>"></td>
                                <td><?= htmlspecialchars($course['MaHP']) ?></td>
                                <td><?= htmlspecialchars($course['TenHP']) ?></td>
                                <td><?= htmlspecialchars($course['SoTC']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($courses)): ?>
                            <tr><td colspan="4">Không có học phần nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-3">
                <a href="../../index.php" class="btn btn-secondary">⬅️ Quay Lại</a>
                <button type="submit" name="register" class="btn btn-primary">✅ Đăng Ký</button>
            </div>
        </form>
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