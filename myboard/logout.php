<?php
session_start(); // 세션 시작

// 세션 변수 모두 해제
$_SESSION = array();

// 세션 쿠키를 삭제
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

// 세션 종료
session_destroy();

// 로그아웃 후 리다이렉트할 페이지 설정
header("Location: index.php"); // 메인 페이지로 리다이렉트
exit();
?>
