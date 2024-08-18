<?php
$servername = "localhost"; // 데이터베이스 서버
$username = "my_user"; // 사용자 이름
$password = "SecurePassword123!"; // 비밀번호
$dbname = "my_website"; // 실제 데이터베이스 이름으로 변경
// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}
?>

