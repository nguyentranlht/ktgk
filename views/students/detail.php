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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sinh Viên - Hệ Thống Đăng Ký Học</title>
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
                        <a class="nav-link" href="index.php">Quản Lý Sinh Viên</a>
                    </li>
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
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Chi Tiết Sinh Viên</h2>
                        
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <img src="../../public/images/<?php echo $student['Hinh']; ?>" 
                                     alt="Ảnh sinh viên" 
                                     class="img-thumbnail student-image">
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th>Mã Sinh Viên:</th>
                                        <td><?php echo $student['MaSV']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Họ và tên:</th>
                                        <td><?php echo $student['HoTen']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Giới tính:</th>
                                        <td><?php echo $student['GioiTinh']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ngày sinh:</th>
                                        <td><?php echo date('d/m/Y', strtotime($student['NgaySinh'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ngành học:</th>
                                        <td><?php echo $student['MaNganh']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="edit.php?id=<?php echo $student['MaSV']; ?>" class="btn btn-warning">Sửa Thông Tin</a>
                            <a href="index.php" class="btn btn-secondary">Quay Lại</a>
                        </div>
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