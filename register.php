<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 실제 데이터베이스에 사용자 정보를 저장하는 코드가 필요합니다.
    // 여기서는 단순한 예제입니다.
    echo "사용자 '$username' 가 등록되었습니다.";
}
?>

<form action="" method="post">
    사용자 이름: <input type="text" name="username" required>
    비밀번호: <input type="password" name="password" required>
    <input type="submit" value="등록">
</form>
