<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // 세션 시작
include 'config.php'; // 데이터베이스 연결 파일 (db_connection.php 대신 config.php로 수정)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // 비밀번호 확인
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username; // 세션에 사용자 이름 저장
            echo "로그인 성공!";
            // 로그인 후 메인 페이지로 리다이렉트
            header("Location: index.php");
            exit(); // 스크립트 종료
        } else {
            echo "비밀번호가 틀렸습니다.";
        }
    } else {
        echo "사용자 이름이 존재하지 않습니다.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- 로그인 폼 -->
<form action="login.php" method="post">
    사용자 이름: <input type="text" name="username" required><br>
    비밀번호: <input type="password" name="password" required><br>
    <input type="submit" value="로그인">
</form>
