<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
$servername = "localhost"; // 데이터베이스 서버
$username = "my_user"; // 데이터베이스 사용자 이름
$password = "SecurePassword123!"; // 데이터베이스 비밀번호
$dbname = "my_website"; // 사용할 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}
?>
