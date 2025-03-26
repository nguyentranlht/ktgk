<?php
session_start();
require_once 'models/Student.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $masv = $_POST['masv'];
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $ngaysinh = $_POST['ngaysinh'];
    $manganh = $_POST['manganh'];

    $errors = [];

    if (Student::checkMaSVExists($masv)) {
        $errors[] = "❌ Mã sinh viên đã tồn tại!";
    }

    // Xử lý upload hình ảnh
    $hinhanh = 'default.jpg';
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['hinhanh']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($filetype), $allowed)) {
            $newname = $masv . '_' . time() . '.' . $filetype;
            if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], 'public/images/' . $newname)) {
                $hinhanh = $newname;
            } else {
                $errors[] = "❌ Không thể upload hình ảnh. Vui lòng thử lại.";
            }
        } else {
            $errors[] = "❌ Chỉ chấp nhận các file ảnh: JPG, JPEG, PNG, GIF.";
        }
    }

    if (empty($errors)) {
        if (Student::register($masv, $hoten, $gioitinh, $ngaysinh, $hinhanh, $manganh)) {
            $_SESSION['success'] = "✅ Đăng ký thành công! Vui lòng đăng nhập.";
            header('Location: login.php');
            exit();
        } else {
            $errors[] = "❌ Đăng ký thất bại. Vui lòng thử lại.";
        }
    }
}

$nganh_hoc = Student::getNganhHoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Hệ Thống Đăng Ký Học</title>
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
        .container {
            margin-top: 60px;
        }
        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            max-width: 650px;
            margin: auto;
        }
        .form-label {
            font-weight: 500;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        .form-text {
            font-size: 13px;
            color: #6c757d;
        }
        footer {
            background-color: #e9ecef;
            font-size: 14px;
            margin-top: 60px;
            padding: 20px 0;
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
                    <a class="nav-link" href="login.php">Đăng Nhập</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="register.php">Đăng Ký</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">✍️ Đăng Ký Sinh Viên</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="masv" class="form-label">Mã Sinh Viên</label>
                <input type="text" class="form-control" id="masv" name="masv" required>
            </div>
            <div class="mb-3">
                <label for="hoten" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="hoten" name="hoten" required>
            </div>
            <div class="mb-3">
                <label for="gioitinh" class="form-label">Giới tính</label>
                <select class="form-select" id="gioitinh" name="gioitinh" required>
                    <option value="">-- Chọn giới tính --</option>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="ngaysinh" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" required>
            </div>
            <div class="mb-3">
                <label for="manganh" class="form-label">Ngành học</label>
                <select class="form-select" id="manganh" name="manganh" required>
                    <option value="">-- Chọn ngành học --</option>
                    <?php foreach ($nganh_hoc as $nganh): ?>
                        <option value="<?php echo $nganh['MaNganh']; ?>">
                            <?php echo $nganh['TenNganh']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="hinhanh" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*">
                <div class="form-text">📷 JPG, PNG, GIF - Tự động dùng ảnh mặc định nếu không chọn.</div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Đăng Ký</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
        </div>
    </div>
</div>

<footer>
    <div class="container text-center">
        <p>&copy; 2024 Hệ Thống Đăng Ký Học. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>