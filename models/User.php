<?php
require_once __DIR__ . '/../config/database.php';

class User {
    public static function login($masv, $password) {
        global $conn;
        $sql = "SELECT * FROM SinhVien WHERE MaSV = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $masv);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function register($masv, $hoten, $gioitinh, $ngaysinh, $hinhanh, $manganh) {
        global $conn;
        $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $masv, $hoten, $gioitinh, $ngaysinh, $hinhanh, $manganh);
        return $stmt->execute();
    }

    public static function checkMaSVExists($masv) {
        global $conn;
        $sql = "SELECT COUNT(*) as count FROM SinhVien WHERE MaSV = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $masv);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }

    public static function getNganhHoc() {
        global $conn;
        $sql = "SELECT * FROM NganhHoc";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>