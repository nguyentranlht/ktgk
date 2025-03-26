<?php
session_start();
require_once '../../models/Course.php';
require_once '../../models/Registration.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['student'])) {
    header('Location: ../../login.php');
    exit();
}

// Xử lý đăng ký học phần
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $selectedCourses = isset($_POST['selected_courses']) ? $_POST['selected_courses'] : [];
    if (!empty($selectedCourses)) {
        if (Registration::registerCourses($_SESSION['student']['MaSV'], $selectedCourses)) {
            $_SESSION['success'] = "Đăng ký học phần thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi đăng ký học phần!";
        }
    } else {
        $_SESSION['error'] = "Vui lòng chọn ít nhất một học phần!";
    }
    header('Location: list.php');
    exit();
}

// Lấy danh sách học phần
$courses = Course::getAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Học Phần - Hệ Thống Đăng Ký Học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">Hệ Thống Đăng Ký Học</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Xin chào, <?php echo $_SESSION['student']['HoTen']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../logout.php">Đăng Xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Danh Sách Học Phần</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Chọn</th>
                                            <th>Mã HP</th>
                                            <th>Tên Học Phần</th>
                                            <th>Số TC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="selected_courses[]" 
                                                           value="<?php echo $course['MaHP']; ?>">
                                                </td>
                                                <td><?php echo $course['MaHP']; ?></td>
                                                <td><?php echo $course['TenHP']; ?></td>
                                                <td><?php echo $course['SoTC']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <a href="../../index.php" class="btn btn-secondary">Quay Lại</a>
                                <button type="submit" name="register" class="btn btn-primary">Đăng Ký</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light mt-5 py-3">
        <div class="container text-center">
            <p>&copy; 2024 Hệ Thống Đăng Ký Học. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>