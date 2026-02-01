<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "로그인이 필요합니다.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>기록 작성</title>
    <link rel="stylesheet" href="write.css">
</head>
<body>

<header class="header">
    <div class="logo">MyStage</div>
    <nav>
        <a href="main.php?page=mypage">내 기록</a>
        <a href="main.php?page=community">커뮤니티</a>
        <a href="search.php">검색</a>
    </nav>
</header>

<main class="write-container">
    <form action="write_process.php" method="post" enctype="multipart/form-data" class="write-form">

        <!-- 사진 영역 -->
        <div class="photo-box">
            <label for="photo">사진</label>
            <input type="file" name="photo" id="photo" accept="image/*">
        </div>

        <!-- 글 영역 -->
        <div class="ticket-box">
            <input
                type="text"
                name="title"
                placeholder="공연 제목"
                required
            >

            <textarea
                name="content"
                placeholder="공연 기록을 작성하세요"
                required
            ></textarea>

            <button type="submit">기록 저장</button>
        </div>

    </form>
</main>

</body>
</html>
