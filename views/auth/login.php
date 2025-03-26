<form method="POST" action="../../controllers/AuthController.php">
    <h2>Đăng nhập</h2>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <input type="text" name="username" placeholder="Tên đăng nhập" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <button type="submit">Đăng nhập</button>
</form>