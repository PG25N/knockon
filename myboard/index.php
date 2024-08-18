<?php
session_start(); // 세션 시작
include 'config.php'; // 데이터베이스 연결 파일

// 게시글 검색 처리
$search_result = [];
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    $sql = "SELECT * FROM posts WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search_term . "%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $search_result[] = $row;
    }

    $stmt->close();
}

// 게시글 목록 가져오기
$sql = "SELECT * FROM posts ORDER BY post_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>메인 페이지</title>
</head>
<body>
    <h1>메인 페이지</h1>

    <!-- 로그인 상태에 따라 버튼 표시 -->
    <?php if (isset($_SESSION['username'])): ?>
        <p>환영합니다, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <form action="logout.php" method="post">
            <input type="submit" value="로그아웃">
        </form>
    <?php else: ?>
        <form action="login.php" method="get">
            <input type="submit" value="로그인">
        </form>
        <form action="register.php" method="get">
            <input type="submit" value="회원가입">
        </form>
    <?php endif; ?>

    <h2>게시글 검색</h2>
    <form action="index.php" method="post">
        <input type="text" name="search_term" placeholder="검색어를 입력하세요" required>
        <input type="submit" name="search" value="검색">
    </form>

    <?php if (!empty($search_result)): ?>
        <h3>검색 결과</h3>
        <ul>
            <?php foreach ($search_result as $post): ?>
                <li><a href="view.php?id=<?php echo htmlspecialchars($post['id']); ?>"><?php echo htmlspecialchars($post['title']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>게시글 목록</h2>
    <ul>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($post = $result->fetch_assoc()): ?>
                <li><a href="view.php?id=<?php echo htmlspecialchars($post['id']); ?>"><?php echo htmlspecialchars($post['title']); ?></a></li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>게시글이 없습니다.</li>
        <?php endif; ?>
    </ul>

    <!-- 게시글 작성 링크 추가 -->
    <a href="create.php">게시글 작성하기</a>

    <?php $conn->close(); ?> <!-- 데이터베이스 연결 종료 -->
</body>
</html>
