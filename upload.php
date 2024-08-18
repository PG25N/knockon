<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "uploads/"; // 파일이 저장될 디렉토리
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // 파일이 실제 이미지인지 확인
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "파일은 이미지입니다. (" . $check["mime"] . ").";
        $uploadOk = 1;
    } else {
        echo "파일은 이미지가 아닙니다.";
        $uploadOk = 0;
    }

    // 파일이 이미 존재하는지 확인
    if (file_exists($targetFile)) {
        echo "죄송합니다. 파일이 이미 존재합니다.";
        $uploadOk = 0;
    }

    // 파일 크기 제한
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "죄송합니다. 파일 크기가 너무 큽니다.";
        $uploadOk = 0;
    }

    // 특정 파일 형식만 허용
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "죄송합니다. JPG, JPEG, PNG, GIF 파일만 허용됩니다.";
        $uploadOk = 0;
    }

    // 파일 업로드
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "파일 ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " 가 업로드되었습니다.";
        } else {
            echo "죄송합니다. 파일 업로드 중 오류가 발생했습니다.";
        }
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    파일 선택: <input type="file" name="fileToUpload" required>
    <input type="submit" value="업로드">
</form>
