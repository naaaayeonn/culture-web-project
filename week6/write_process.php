<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
  exit("로그인이 필요합니다.");
}

$title = $_POST['title'];
$artist = $_POST['artist'];
$performance_date = $_POST['performance_date'];
$content = $_POST['content'];
$username = $_SESSION['username'];

$imageName = null;

if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {

    $uploadDir = "uploads/";

    // uploads 폴더 없으면 생성
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // 파일 이름 겹침 방지
    $imageName = time() . "_" . basename($_FILES['photo']['name']);

    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        $uploadDir . $imageName
    );
}

$sql = "INSERT INTO records 
        (title, artist, performance_date, content, username, image, created_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $title,
    $artist,
    $performance_date,
    $content,
    $username,
    $imageName
]);
header("Location: main.php");
exit;
