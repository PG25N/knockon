<?php
include '../사용자/config.php'; // 데이터베이스 연결 파일

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT title, content, attachment FROM posts WHERE id = ?"; // SQL 쿼리 수정
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        echo "<h1>" . htmlspecialchars($post['title']) . "</h1>";
        echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";

        // 첨부 파일 출력
        if (!empty($post['attachment'])) {
            $attachment_path = htmlspecialchars($post['attachment']);
            if (file_exists($attachment_path)) {
                echo "<h3>첨부 파일:</h3>";
                echo "<a href='" . $attachment_path . "' target='_blank'>첨부 파일 보기</a>";
            } else {
                echo "<p>첨부 파일이 없습니다.</p>";
            }
        } else {
            echo "<p>첨부 파일이 없습니다.</p>";
        }

        // 수정 및 삭제 버튼 추가
        echo "<div style='margin-top: 20px;'>";
        echo "<a href='edit.php?id=" . $post_id . "' style='padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;'>수정</a>";
        echo "<a href='delete.php?id=" . $post_id . "' style='padding: 10px 20px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px;' onclick='return confirm(\"정말 삭제하시겠습니까?\");'>삭제</a>";
        echo "</div>";
        
    } else {
        echo "게시물이 존재하지 않습니다.";
    }

    $stmt->close();
} else {
    echo "게시물 ID가 제공되지 않았습니다.";
}

// 이전 화면으로 돌아가기 버튼
echo "<br><a href='index.php'>이전 화면으로 돌아가기</a>";

$conn->close();
?>
