<?php
session_start(); // 세션 시작
include 'config.php'; // 같은 디렉토리에 있으므로 경로를 이렇게 설정

// 에러 보고 활성화
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 사용자 인증 로직
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // 비밀번호 확인 (해싱된 비밀번호와 비교)
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username; // 세션에 사용자 이름 저장
            header("Location: ../index.php"); // 메인 화면으로 리다이렉트
            exit();
        } else {
            $error = "로그인 실패: 사용자 이름 또는 비밀번호가 잘못되었습니다.";
        }
    } else {
        $error = "로그인 실패: 사용자 이름 또는 비밀번호가 잘못되었습니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
    <h1>로그인</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="" method="post">
        <label for="username">사용자 이름:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="로그인">
    </form>
    <p><a href="../index.php">메인 화면으로 돌아가기</a></p>
</body>
</html>
