<?php
// 게시물/delete.php
include '../db.php';

$id = $_GET['id'];
$sql = "DELETE FROM posts WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: list.php"); // 삭제 후 목록으로 리다이렉트
    exit();
} else {
    echo "오류: " . $conn->error;
}

$conn->close(); // 데이터베이스 연결 종료
?>
