<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/Course.php';

class Registration {
    public static function registerCourses($userId, $selectedCourses) {
        global $conn;
        $conn->begin_transaction();
        try {
            // Kiểm tra xem sinh viên đã đăng ký học phần nào chưa
            $sql = "SELECT MaHP FROM ChiTietDangKy ct 
                    JOIN DangKy dk ON ct.MaDK = dk.MaDK 
                    WHERE dk.MaSV = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $registeredCourses = [];
            while ($row = $result->fetch_assoc()) {
                $registeredCourses[] = $row['MaHP'];
            }

            // Lọc ra các học phần chưa đăng ký
            $newCourses = array_diff($selectedCourses, $registeredCourses);
            
            if (empty($newCourses)) {
                $_SESSION['error'] = "Bạn đã đăng ký tất cả các học phần này rồi!";
                return false;
            }

            // Thêm vào bảng Đăng Ký
            $sql = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $maDK = $conn->insert_id;

            // Thêm vào bảng Chi Tiết Đăng Ký
            foreach ($newCourses as $maHP) {
                $sql = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $maDK, $maHP);
                $stmt->execute();
            }

            $conn->commit();
            $_SESSION['success'] = "Đăng ký học phần thành công!";
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['error'] = "Có lỗi xảy ra khi đăng ký: " . $e->getMessage();
            return false;
        }
    }
}
?>