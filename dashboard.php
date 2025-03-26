<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>
<h2>Xin chào, <?= $user['username'] ?>!</h2>
<p>Vai trò: <?= $user['role'] ?></p>

<?php if ($user['role'] == 'admin') : ?>
    <a href="admin.php">Trang Admin</a><br>
<?php else : ?>
    <a href="student.php">Trang Sinh viên</a><br>
<?php endif; ?>

<a href="logout.php">Đăng xuất</a>