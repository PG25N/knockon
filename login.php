<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 실제 데이터베이스에서 사용자 인증을 해야 합니다.
    // 여기서는 단순한 예제입니다.
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php'); // 로그인 성공 시 리다이렉트
        exit;
    } else {
        echo "잘못된 사용자 이름 또는 비밀번호.";
    }
}
?>

<form action="" method="post">
    사용자 이름: <input type="text" name="username" required>
    비밀번호: <input type="password" name="password" required>
    <input type="submit" value="로그인">
</form>
