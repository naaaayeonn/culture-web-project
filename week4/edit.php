<?php
session_start();
require_once "db.php";

$id = $_GET['id'] ?? null;

$sql = "SELECT * FROM records WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$record) {
    echo "존재하지 않는 글입니다.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="write.css">
<title>수정하기</title>
</head>
<body>

<header class="header">
    <div class="logo">MyStage</div>
</header>

<main class="write-container">

<form action="edit_process.php" method="post" enctype="multipart/form-data" class="write-form">

<input type="hidden" name="id" value="<?= $record['id'] ?>">

<div class="photo-box">
    <label>사진</label>
    <input type="file" name="photo">
</div>

<div class="ticket-box">

    <input
        type="text"
        name="title"
        value="<?= htmlspecialchars($record['title']) ?>"
        required
    >

    <textarea
        name="content"
        required
    ><?= htmlspecialchars($record['content']) ?></textarea>

    <button type="submit">수정 저장</button>

</div>

</form>

</main>

</body>
</html>
