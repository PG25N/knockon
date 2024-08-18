<?php
// 게시물/edit.php
include '../db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: list.php"); // 수정 후 목록으로 리다이렉트
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
    <title>게시물 수정</title>
</head>
<body>
    <h1>게시물 수정</h1>
    <form method="POST" action="">
        <label for="title">제목:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>" required><br>
        <label for="content">내용:</label><br>
        <textarea id="content" name="content" required><?php echo $row['content']; ?></textarea><br>
        <input type="submit" value="게시물 수정">
    </form>
    <a href="list.php">목록으로 돌아가기</a>
</body>
</html>

<?php
$conn->close(); // 데이터베이스 연결 종료
?>
