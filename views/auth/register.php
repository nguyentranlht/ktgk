<form method="POST" action="../../controllers/AuthController.php">
    <h2>Đăng ký tài khoản</h2>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>

    <input type="text" name="username" placeholder="Tên đăng nhập" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    
    <label for="role">Chọn vai trò:</label>
    <select name="role">
        <option value="student">Sinh viên</option>
        <option value="admin">Admin</option>
    </select><br>

    <button type="submit" name="register">Đăng ký</button>
</form>