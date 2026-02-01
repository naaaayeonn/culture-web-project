<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
  exit("로그인이 필요합니다.");
}

$username = $_SESSION['username'];
$title = $_POST['title'];
$content = $_POST['content'];

$sql = "INSERT INTO records (username, title, content, created_at)
        VALUES (?, ?, ?, NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([$username, $title, $content]);

header("Location: main.php");
exit;
