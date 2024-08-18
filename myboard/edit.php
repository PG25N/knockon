<?php
include '../사용자/config.php'; // 데이터베이스 연결 파일

// 게시글 ID 가져오기
if (!isset($_GET['id'])) {
    echo "게시글 ID가 없습니다.";
    exit();
}

$post_id = $_GET['id'];

// 게시글 데이터 가져오기
$sql = "SELECT title, content, attachment FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "게시글을 찾을 수 없습니다.";
    exit();
}

$post = $result->fetch_assoc();

// 폼 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // 게시글 업데이트
    $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $post_id);

    if ($stmt->execute()) {
        echo "게시글이 성공적으로 수정되었습니다.";
        header("Location: view.php?id=" . $post_id); // 수정된 게시글 보기 페이지로 리다이렉트
        exit();
    } else {
        echo "수정 오류: " . $stmt->error;
    }
}
?>

<!-- 게시글 수정 폼 -->
<form action="edit.php?id=<?php echo $post_id; ?>" method="post">
    제목: <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>
    내용: <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
    <input type="submit" value="게시글 수정">
</form>

<a href="index.php">메인으로 돌아가기</a>
