<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

$tab = $_GET['tab'] ?? 'my';
$keyword = $_GET['q'] ?? '';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>MyStage</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>

<header>
  <h1>MyStage</h1>
  <nav>
    <a href="main.php?page=community">커뮤니티</a>
    <a href="main.php?page=mypage">내 기록</a>
  </nav>
</header>

<main>
  <?php
    if ($page === 'mypage') {
        include 'mypage.php';
    } else {
        include 'community.php';
    }
  ?>
</main>

</body>
</html>
