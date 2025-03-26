<?php
session_start();
require_once '../../models/Student.php';

// Kiểm tra quyền truy cập
if (!isset($_SESSION['student'])) {
    header('Location: ../../login.php');
    exit();
}

// Lấy ID sinh viên cần sửa
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$student = Student::getById($_GET['id']);
if (!$student) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $masv = $_POST['masv'];
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $ngaysinh = $_POST['ngaysinh'];
    $manganh = $_POST['manganh'];

    $errors = [];

    // Xử lý hình ảnh
    $hinhanh = $student['Hinh'];
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['hinhanh']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($filetype), $allowed)) {
            $newname = $masv . '_' . time() . '.' . $filetype;
            if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], '../../public/images/' . $newname)) {
                if ($student['Hinh'] != 'default.jpg') {
                    @unlink('../../public/images/' . $student['Hinh']);
                }
                $hinhanh = $newname;
            } else {
                $errors[] = "Không thể upload hình ảnh. Vui lòng thử lại.";
            }
        } else {
            $errors[] = "Chỉ chấp nhận file ảnh: JPG, JPEG, PNG, GIF.";
        }
    }

    if (empty($errors)) {
        if (Student::update($masv, $hoten, $gioitinh, $ngaysinh, $hinhanh, $manganh)) {
            $_SESSION['success'] = "✅ Cập nhật thành công!";
            header('Location: index.php');
            exit();
        } else {
            $errors[] = "❌ Cập nhật thất bại. Vui lòng thử lại.";
        }
    }
}

$nganh_hoc = Student::getNganhHoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Thông Tin Sinh Viên - Hệ Thống Đăng Ký Học</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + Font + Style -->
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
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
        }
        .form-label {
            font-weight: 500;
        }
        .img-thumbnail {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        .btn-secondary {
            font-weight: 500;
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

<div class="container mt-5 mb-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card p-4">
                <h2 class="card-title text-center text-primary fw-bold mb-4">✏️ Sửa Thông Tin Sinh Viên</h2>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="masv" class="form-label">Mã Sinh Viên</label>
                        <input type="text" class="form-control" id="masv" name="masv" value="<?= $student['MaSV']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="hoten" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="hoten" name="hoten" value="<?= $student['HoTen']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="gioitinh" class="form-label">Giới tính</label>
                        <select class="form-select" id="gioitinh" name="gioitinh" required>
                            <option value="">-- Chọn giới tính --</option>
                            <option value="Nam" <?= $student['GioiTinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                            <option value="Nữ" <?= $student['GioiTinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ngaysinh" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="<?= $student['NgaySinh']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="manganh" class="form-label">Ngành học</label>
                        <select class="form-select" id="manganh" name="manganh" required>
                            <option value="">-- Chọn ngành học --</option>
                            <?php foreach ($nganh_hoc as $nganh): ?>
                                <option value="<?= $nganh['MaNganh']; ?>" <?= $student['MaNganh'] == $nganh['MaNganh'] ? 'selected' : '' ?>>
                                    <?= $nganh['TenNganh']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hinhanh" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*">
                        <div class="form-text">Nếu không chọn, ảnh hiện tại sẽ được giữ nguyên.</div>
                        <?php if ($student['Hinh']): ?>
                            <div class="mt-2">
                                <img src="../../public/images/<?= $student['Hinh']; ?>" class="img-thumbnail" alt="Ảnh hiện tại" style="max-width: 150px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">💾 Cập Nhật</button>
                        <a href="index.php" class="btn btn-secondary">⬅️ Quay Lại</a>
                    </div>
                </form>
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