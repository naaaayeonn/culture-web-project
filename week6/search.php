<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$currentUser = $_SESSION['username'];

$q = isset($_GET['q']) ? trim($_GET['q']) : "";
$scope = isset($_GET['scope']) ? $_GET['scope'] : "all"; // all | mine

$records = [];

if ($q !== "") {
    $like = "%" . $q . "%";

    if ($scope === "mine") {
        $sql = "
            SELECT * FROM records
            WHERE username = ?
              AND (title LIKE ? OR artist LIKE ? OR content LIKE ? OR username LIKE ?)
            ORDER BY created_at DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$currentUser, $like, $like, $like, $like]);
    } else {
        $sql = "
            SELECT * FROM records
            WHERE (title LIKE ? OR artist LIKE ? OR content LIKE ? OR username LIKE ?)
            ORDER BY created_at DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$like, $like, $like, $like]);
    }

    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="stymain.css">
  <title>검색 | MyStage</title>

  <style>
    .search-box{
      max-width: 1100px;
      margin: 30px auto 10px;
      padding: 0 20px;
    }
    .search-form{
      display:flex;
      gap: 10px;
      align-items: center;
      flex-wrap: wrap;
    }
    .search-input{
      flex: 1;
      min-width: 220px;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid #ddd;
      font-size: 15px;
      outline: none;
    }
    .search-select{
      padding: 12px 12px;
      border-radius: 12px;
      border: 1px solid #ddd;
      font-size: 14px;
      background: #fff;
    }
    .search-btn{
      padding: 12px 16px;
      border-radius: 12px;
      border: none;
      background: #6f63d2;
      color: #fff;
      font-weight: 700;
      cursor: pointer;
    }
    .search-btn:hover{ opacity: .9; }

    .result-info{
      max-width: 1100px;
      margin: 10px auto 0;
      padding: 0 20px;
      color: #555;
      font-size: 14px;
    }

    .ticket-meta{
      font-size: 14px;
      color: #333;
      margin-bottom: 8px;
    }
    .ticket-meta span{
      margin-right: 12px;
      opacity: .85;
    }
  </style>
</head>
<body>

<header class="top-header">
  <div class="top-inner">
    <div class="logo">MyStage</div>
    <nav class="top-nav">
      <a href="main.php">내 기록</a>
      <a href="community.php">커뮤니티</a>
      <a href="search.php" class="active">검색</a>
      <a href="logout.php" class="logout-btn">로그아웃</a>
    </nav>
  </div>
</header>

<div class="search-box">
  <form class="search-form" method="get" action="search.php">
    <input class="search-input" type="text" name="q"
           placeholder="공연이름/아티스트/내용/작성자 검색"
           value="<?= htmlspecialchars($q) ?>">

    <select class="search-select" name="scope">
      <option value="all" <?= ($scope==="all") ? "selected" : "" ?>>전체</option>
      <option value="mine" <?= ($scope==="mine") ? "selected" : "" ?>>내 글만</option>
    </select>

    <button class="search-btn" type="submit">검색</button>
  </form>
</div>

<?php if ($q !== ""): ?>
  <div class="result-info">
    “<?= htmlspecialchars($q) ?>” 검색 결과: <?= count($records) ?>건
  </div>
<?php endif; ?>

<div class="record-section">
  <?php if ($q === ""): ?>
    <p class="empty-text">검색어를 입력해 주세요.</p>

  <?php elseif (empty($records)): ?>
    <p class="empty-text">검색 결과가 없습니다.</p>

  <?php else: ?>
    <?php foreach ($records as $row): ?>
      <div class="ticket">

        <!-- 본인 글이면 수정/삭제 노출 (원하시면 view.php 링크로 바꿔도 됨) -->
        <?php if ($row['username'] === $currentUser): ?>
          <div class="ticket-actions">
            <a href="delete.php?id=<?= $row['id'] ?>"
               class="delete"
               onclick="return confirm('삭제할까요?')">삭제</a>
            <a href="edit.php?id=<?= $row['id'] ?>">수정</a>
          </div>
        <?php endif; ?>

        <div class="ticket-title">
          <?= htmlspecialchars($row['title']) ?>
        </div>

        <div class="ticket-meta">
          <?php if (!empty($row['artist'])): ?>
            <span>아티스트: <?= htmlspecialchars($row['artist']) ?></span>
          <?php endif; ?>
          <?php if (!empty($row['performance_date'])): ?>
            <span>공연일자: <?= htmlspecialchars($row['performance_date']) ?></span>
          <?php endif; ?>
          <span>작성자: <?= htmlspecialchars($row['username']) ?></span>
        </div>

        <div class="ticket-content">
          <?= nl2br(htmlspecialchars($row['content'])) ?>
        </div>

        <div class="ticket-date">
          <?= htmlspecialchars($row['created_at']) ?>
        </div>

      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

</body>
</html>
