<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // 데이터베이스 연결 파일

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 비밀번호 해싱

    // 사용자 이름 중복 체크
    $check_sql = "SELECT * FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "이미 사용 중인 사용자 이름입니다.";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $username, $password);

            if ($stmt->execute()) {
                echo "회원가입이 완료되었습니다.";
            } else {
                echo "오류: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "SQL 오류: " . $conn->error;
        }
    }

    $check_stmt->close();
    $conn->close();
}
?>

<!-- 회원가입 폼 -->
<form action="register.php" method="post">
    사용자 이름: <input type="text" name="username" required><br>
    비밀번호: <input type="password" name="password" required><br>
    <input type="submit" value="회원가입">
</form>
<!-- 메인으로 돌아가기 버튼 -->
<a href="index.php" style="display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">메인으로 돌아가기</a>
