<?php
// error_reporting 설정 (디버깅 용도)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 데이터베이스 설정
$servername = "localhost"; // 데이터베이스 서버 주소
$username = "my_user"; // 데이터베이스 사용자 이름
$password = "SecurePassword123!"; // 데이터베이스 비밀번호
$dbname = "my_website"; // 데이터베이스 이름

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// 게시물 조회 쿼리
// 게시물 조회 쿼리
$sql = "SELECT id, title, content, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

// 게시물 목록 출력
if ($result->num_rows > 0) {
    echo "<h1>게시물 목록</h1>";
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<strong>" . htmlspecialchars($row["title"]) . "</strong> - " . htmlspecialchars($row["post_date"]);
        echo "<p>" . nl2br(htmlspecialchars($row["content"])) . "</p>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "게시물이 없습니다.";
}

// 데이터베이스 연결 종료
$conn->close();
?>

