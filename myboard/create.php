<?php
include '../사용자/config.php'; // 데이터베이스 연결 파일

// 오류 표시 활성화
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 게시글 작성 폼
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    ?>
    <form action="create.php" method="post" enctype="multipart/form-data">
        제목: <input type="text" name="title" required><br>
        내용: <textarea name="content" required></textarea><br>
        파일: <input type="file" name="fileToUpload" accept="image/*"><br> <!-- 필수 속성 제거 -->
        <input type="submit" name="submit" value="게시글 작성">
    </form>
    <?php
} else {
    // 폼에서 제출된 경우
    $title = $_POST['title'];
    $content = $_POST['content'];

    // 파일 업로드 처리
    $target_dir = "uploads/";
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = uniqid() . '.' . $file_extension; // 유니크한 파일 이름 생성
    $target_file = $target_dir . $new_file_name;
    $uploadOk = 1;

    // 파일이 선택되었는지 확인
    if ($_FILES["fileToUpload"]["size"] > 0) {
        // 파일 업로드 오류 체크
        if ($_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
            echo "파일 업로드 중 오류가 발생했습니다: " . $_FILES["fileToUpload"]["error"];
            $uploadOk = 0;
        }

        // 이미지 파일인지 확인
        if ($uploadOk == 1) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check === false) {
                echo "파일이 이미지가 아닙니다.";
                $uploadOk = 0;
            }
        }

        // 파일이 이미 존재하는지 체크
        if ($uploadOk == 1 && file_exists($target_file)) {
            echo "죄송합니다. 파일이 이미 존재합니다.";
            $uploadOk = 0;
        }

        // 파일 크기 체크 (예: 5MB 이하)
        if ($uploadOk == 1 && $_FILES["fileToUpload"]["size"] > 5000000) {
            echo "죄송합니다. 파일이 너무 큽니다.";
            $uploadOk = 0;
        }

        // 특정 파일 형식만 허용
        if ($uploadOk == 1 && !in_array($file_extension, ["jpg", "jpeg", "png", "gif"])) {
            echo "죄송합니다. JPG, JPEG, PNG, GIF 파일만 허용됩니다.";
            $uploadOk = 0;
        }

        // 파일 업로드 시도
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {  
                // 데이터베이스에 삽입
                $sql = "INSERT INTO posts (title, content, attachment) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $title, $content, $target_file);

                if ($stmt->execute()) {
                    echo "게시글이 성공적으로 등록되었습니다.";
                    header("Location: view.php?id=" . $conn->insert_id); // 작성한 게시글 보기 페이지로 리다이렉트
                    exit();
                } else {
                    echo "오류: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "파일 업로드 중 오류가 발생했습니다.";
            }
        }
    }

    // 파일이 선택되지 않은 경우에도 게시글 등록
    if ($uploadOk == 1 || $_FILES["fileToUpload"]["size"] == 0) {
        $sql = "INSERT INTO posts (title, content, attachment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $attachment = $_FILES["fileToUpload"]["size"] > 0 ? $target_file : null; // 파일이 없으면 NULL
        $stmt->bind_param("sss", $title, $content, $attachment);

        if ($stmt->execute()) {
            echo "게시글이 성공적으로 등록되었습니다.";
            header("Location: view.php?id=" . $conn->insert_id); // 작성한 게시글 보기 페이지로 리다이렉트
            exit();
        } else {
            echo "오류: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "파일 업로드가 취소되었습니다.";
    }
}

$conn->close();
?>

<!-- 메인으로 돌아가기 버튼 -->
<a href="index.php" style="display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">메인으로 돌아가기</a>
