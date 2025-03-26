<?php
session_start();
require_once '../../config/database.php';

$userId = $_SESSION['user']['id'];
$sql = "SELECT HP.MaHP, HP.TenHP, HP.SoTinChi FROM ChiTietDangKy CT
        JOIN DangKy DK ON CT.MaDK = DK.MaDK
        JOIN HocPhan HP ON CT.MaHP = HP.MaHP
        WHERE DK.MaSV = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);
?>

<h2>Học phần đã đăng ký</h2>
<table border="1">
    <tr>
        <th>Mã HP</th>
        <th>Tên Học Phần</th>
        <th>Số Tín Chỉ</th>
    </tr>
    <?php foreach ($courses as $course) : ?>
    <tr>
        <td><?= $course['MaHP'] ?></td>
        <td><?= $course['TenHP'] ?></td>
        <td><?= $course['SoTinChi'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="list.php">Quay lại danh sách học phần</a>