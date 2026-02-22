<?php
session_start();
require_once "db.php";

if (!isset($_GET['id'])) {
    header("Location: community.php");
    exit;
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM records WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "존재하지 않는 글입니다.";
    exit;
}

$currentUser = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="community.css">
  <title>글 보기</title>
</head>
<body>

<header class="header">
  <div class="top-inner">
    <div class="logo">MyStage</div>
    <nav class="top-nav">
      <a href="main.php">내 기록</a>
      <a href="community.php" class="active">커뮤니티</a>
      <a href="search.php">검색</a>
    </nav>
  </div>
</header>

<main class="community-container">
  <h2><?= htmlspecialchars($row['title']) ?></h2>

  <p><b>아티스트:</b> <?= htmlspecialchars($row['artist'] ?? '') ?></p>
  <p><b>공연 일자:</b> <?= htmlspecialchars($row['performance_date'] ?? '') ?></p>
  <p><b>작성자:</b> <?= htmlspecialchars($row['username']) ?></p>
  <hr>
  <div>
    <?= nl2br(htmlspecialchars($row['content'])) ?>
  </div>

  <div style="margin-top:20px;">
    <a href="community.php" class="btn small">목록</a>

    <?php if ($currentUser && $row['username'] === $currentUser): ?>
      <a href="edit.php?id=<?= $row['id'] ?>" class="btn small">수정</a>
      <a href="delete.php?id=<?= $row['id'] ?>"
         class="btn small danger"
         onclick="return confirm('삭제할까요?')">삭제</a>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
