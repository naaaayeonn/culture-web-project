<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$currentUser = $_SESSION['username'];

/* 모든 기록 가져오기 */
$sql = "SELECT * FROM records ORDER BY performance_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="community.css">
<title>커뮤니티</title>
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

<h2>공연 기록 커뮤니티</h2>

<table class="record-table">
    <thead>
        <tr>
            <th>공연 이름</th>
            <th>아티스트</th>
            <th>공연 일자</th>
            <th>작성자</th>
            <th>관리</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($records as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['artist']) ?></td>
            <td><?= htmlspecialchars($row['performance_date']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>

            <td>
            <?php if ($row['username'] === $currentUser): ?>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn small">수정</a>
                <a href="delete.php?id=<?= $row['id'] ?>"
                   class="btn small danger"
                   onclick="return confirm('삭제할까요?')">삭제</a>
            <?php else: ?>
                -
            <?php endif; ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</main>

</body>
</html>
