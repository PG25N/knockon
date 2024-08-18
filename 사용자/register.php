<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php'; // 데이터베이스 연결 파일 포함

$error = ''; // 오류 메시지 초기화

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "사용자 이름과 비밀번호를 입력하세요.";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // 사용자 이름 중복 체크
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error = "이미 존재하는 사용자 이름입니다.";
        } else {
            // 비밀번호 해시화
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 사용자 등록 로직
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $hashed_password);

            if (!$stmt->execute()) {
                $error = "회원가입 실패: " . $stmt->error;
            } else {
                header("Location: login.php"); // 로그인 페이지로 리다이렉트
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
</head>
<body>
    <h1>회원가입</h1>
    <?php if (!empty($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
    <form action="" method="post">
        <label for="username">사용자 이름:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="회원가입">
    </form>
    <p><a href="../index.php">메인 화면으로 돌아가기</a></p>
</body>
</html>

