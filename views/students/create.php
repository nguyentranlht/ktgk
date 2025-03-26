<?php
session_start();
require_once '../../models/Student.php';

// Kiểm tra quyền truy cập
if (!isset($_SESSION['student'])) {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $masv = $_POST['masv'];
    $hoten = $_POST['hoten'];
    $gioitinh = $_POST['gioitinh'];
    $ngaysinh = $_POST['ngaysinh'];
    $manganh = $_POST['manganh'];
    
    $errors = [];
    
    if (Student::checkMaSVExists($masv)) {
        $errors[] = "Mã sinh viên đã tồn tại!";
    }

    // Xử lý upload hình ảnh
    $hinhanh = 'default.jpg'; // Ảnh mặc định
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['hinhanh']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            // Tạo tên file mới
            $newname = $masv . '_' . time() . '.' . $filetype;
            
            if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], '../../public/images/' . $newname)) {
                $hinhanh = $newname;
            } else {
                $errors[] = "Không thể upload hình ảnh. Vui lòng thử lại.";
            }
        } else {
            $errors[] = "Chỉ chấp nhận file ảnh có định dạng: JPG, JPEG, PNG, GIF";
        }
    }
    
    if (empty($errors)) {
        if (Student::register($masv, $hoten, $gioitinh, $ngaysinh, $hinhanh, $manganh)) {
            $_SESSION['success'] = "Thêm sinh viên thành công!";
            header('Location: index.php');
            exit();
        } else {
            $errors[] = "Thêm sinh viên thất bại. Vui lòng thử lại.";
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
    <title>Thêm Sinh Viên - Hệ Thống Đăng Ký Học</title>
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
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Thêm Sinh Viên Mới</h2>
                        
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
                                    <option value="">Chọn giới tính</option>
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
                                    <option value="">Chọn ngành học</option>
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
                                <div class="form-text">Chấp nhận các định dạng: JPG, JPEG, PNG, GIF. Nếu không chọn, hệ thống sẽ sử dụng ảnh mặc định.</div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Thêm Sinh Viên</button>
                                <a href="index.php" class="btn btn-secondary">Quay Lại</a>
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