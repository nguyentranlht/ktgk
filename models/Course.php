<?php
require_once __DIR__ . '/../config/database.php';

class Course {
    public static function getAll() {
        global $conn;
        $sql = "SELECT MaHP, TenHP, SoTinChi as SoTC FROM HocPhan";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getById($id) {
        global $conn;
        $sql = "SELECT MaHP, TenHP, SoTinChi as SoTC FROM HocPhan WHERE MaHP = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function decreaseSlot($maHP) {
        global $conn;
        $sql = "UPDATE HocPhan SET SoLuong = SoLuong - 1 WHERE MaHP = ? AND SoLuong > 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $maHP);
        return $stmt->execute();
    }
}
?>