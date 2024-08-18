<?php
include '../사용자/config.php'; // 데이터베이스 연결 파일

// 게시글 ID 가져오기
if (!isset($_GET['id'])) {
    echo "게시글 ID가 없습니다.";
    exit();
}

$post_id = $_GET['id'];

// 게시글 삭제
$sql = "DELETE FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);

if ($stmt->execute()) {
    echo "게시글이 성공적으로 삭제되었습니다.";
    header("Location: index.php"); // 메인 페이지로 리다이렉트
    exit();
} else {
    echo "삭제 오류: " . $stmt->error;
}
?>
