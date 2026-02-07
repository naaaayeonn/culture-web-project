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

$sql = "DELETE FROM records WHERE id = ? AND username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id, $username]);

header("Location: main.php");
exit;
