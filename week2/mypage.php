<?php
require_once "db.php";

$username = $_SESSION['username'] ?? null;

if (!$username) {
    echo "로그인이 필요합니다.";
    exit;
}

$sql = "SELECT * FROM records WHERE username = :username ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':username' => $username
]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?php if (empty($records)): ?>
    <p>아직 기록이 없습니다.</p>
<?php else: ?>

<div class="ticket-list">
<?php foreach ($records as $row): ?>
    <div class="ticket">

        <!-- 왼쪽: 사진 영역 -->
        <div class="ticket-image">
            사진
        </div>

        <!-- 오른쪽: 글 영역 -->
        <div class="ticket-content">

            <!-- 수정 / 삭제 (작성자 본인만) -->
            <?php if ($row['username'] === $_SESSION['username']): ?>
                <div class="ticket-actions">
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn small">수정</a>
                    <a href="delete.php?id=<?= $row['id'] ?>"
                       class="btn small danger"
                       onclick="return confirm('삭제할까요?')">
                       삭제
                    </a>
                </div>
            <?php endif; ?>

            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            <small class="date"><?= $row['created_at'] ?></small>

        </div>
    </div>
<?php endforeach; ?>
</div>

<?php endif; ?>
