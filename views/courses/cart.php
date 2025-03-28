<?php
session_start();
require_once '../../models/Course.php';

$studentId = $_SESSION['student']['MaSV'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['courseId'])) {
    Course::removeRegisteredCourse($studentId, $_POST['courseId']);
}

$courses = Course::getRegisteredCourses($studentId);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Học Phần Đã Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f4f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.06);
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-4">
        <h2 class="text-primary text-center mb-4">📘 Học phần đã đăng ký</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã HP</th>
                        <th>Tên Học Phần</th>
                        <th>Số Tín Chỉ</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courses)) : ?>
                        <?php foreach ($courses as $course) : ?>
                            <tr>
                                <td><?= htmlspecialchars($course['MaHP']) ?></td>
                                <td><?= htmlspecialchars($course['TenHP']) ?></td>
                                <td><?= htmlspecialchars($course['SoTinChi']) ?></td>
                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="courseId" value="<?= htmlspecialchars($course['MaHP']) ?>">
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Chưa có học phần nào được đăng ký.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center btn-back">
            <a href="list.php" class="btn btn-secondary">⬅️ Quay lại danh sách học phần</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>