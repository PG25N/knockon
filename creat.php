<?php
// 게시물/create.php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    if ($conn->query($sql) === TRUE) {
        header("Location: list.php"); // 게시물 작성 후 목록으로 리다이렉트
        exit();
    } else {
        echo "오류: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>새 게시물 작성</title>
</head>
<body>
    <h1>새 게시물 작성</h1>
    <form method="POST" action="">
        <label for="title">제목:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="content">내용:</label><br>
        <textarea id="content" name="content" required></textarea><br>
        <input type="submit" value="게시물 작성">
    </form>
    <a href="list.php">목록으로 돌아가기</a>
</body>
</html>

<?php
$conn->close(); // 데이터베이스 연결 종료
?>
