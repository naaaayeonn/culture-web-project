<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM records WHERE username = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="stymain.css">
  <title>MyStage</title>
</head>
<body>

<header class="top-header">
  <div class="top-inner">
    <div class="logo">MyStage</div>

    <nav class="top-nav">
      <a href="main.php" class="active">내 기록</a>
      <a href="community.php">커뮤니티</a>
      <a href="search.php">검색</a>
      <a href="logout.php" class="logout-btn">로그아웃</a>
    </nav>
  </div>
</header>

<div class="record-section">
  <div class="record-header">
    <h2><?= htmlspecialchars($username) ?>의 공연 기록</h2>
    <a href="write.php" class="write-btn">+ 기록 작성</a>
  </div>

  <?php if (empty($records)): ?>
    <p class="empty-text">아직 기록이 없습니다.</p>
  <?php else: ?>
    <?php foreach ($records as $row): ?>
      <div class="ticket">

        <div class="ticket-actions">
          <!-- 삭제가 위 -->
          <a href="delete.php?id=<?= $row['id'] ?>"
             class="delete"
             onclick="return confirm('삭제할까요?')">삭제</a>
          <!-- 수정이 아래 -->
          <a href="edit.php?id=<?= $row['id'] ?>">수정</a>
        </div>

        <div class="ticket-title">
          <a href="view.php?id=<?= $row['id'] ?>" class="title-link">
            <?= htmlspecialchars($row['title']) ?>
          </a>
        </div>

        <div class="ticket-content">
          <?= nl2br(htmlspecialchars($row['content'])) ?>
        </div>

        <div class="ticket-date">
          <?= $row['created_at'] ?>
        </div>

      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

</body>
</html>
