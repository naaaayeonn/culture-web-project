<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: main.php");
    exit;
}

$id = $_GET['id'];
$username = $_SESSION['username'];

$sql = "SELECT username FROM records WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$record) {
    echo "존재하지 않는 글입니다.";
    exit;
}

if ($record['username'] !== $username) {
    echo "권한이 없습니다.";
    exit;
}

$sql = "DELETE FROM records WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: main.php");
exit;
