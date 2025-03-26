<?php
require_once __DIR__ . '/../config/database.php';

class Student
{
    public static function login($masv) {
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

    public static function getById($masv) {
        global $conn;
        $sql = "SELECT * FROM SinhVien WHERE MaSV = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $masv);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getAll() {
        global $conn;
        $sql = "SELECT sv.*, nh.TenNganh 
                FROM SinhVien sv 
                LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                ORDER BY sv.MaSV";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function update($masv, $hoten, $gioitinh, $ngaysinh, $hinhanh, $manganh) {
        global $conn;
        $sql = "UPDATE SinhVien SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, Hinh = ?, MaNganh = ? WHERE MaSV = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $hoten, $gioitinh, $ngaysinh, $hinhanh, $manganh, $masv);
        return $stmt->execute();
    }

    public static function delete($masv) {
        global $conn;
        $sql = "DELETE FROM SinhVien WHERE MaSV = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $masv);
        return $stmt->execute();
    }
}
?>