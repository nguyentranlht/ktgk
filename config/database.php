<?php
$host = "localhost";
$username = "root";
$password = "root";
$database = "test1";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");

echo "Kết nối MySQL thành công!";
?>