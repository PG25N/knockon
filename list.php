<?php
// 게시물/list.php
include '../db.php'; // 데이터베이스 연결

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물 목록</title>
</head>
<body>
    <h1>게시물 목록</h1>
    <a href="create.php">새 게시물 작성</a>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li><a href='edit.php?id=" . $row["id"] . "'>" . $row["title"] . "</a> <a href='delete.php?id=" . $row["id"] . "'>삭제</a></li>";
            }
        } else {
            echo "게시물이 없습니다.";
        }
        ?>
    </ul>
</body>
</html>

<?php
$conn->close(); // 데이터베이스 연결 종료
?>
