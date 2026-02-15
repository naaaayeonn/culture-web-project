<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_SESSION['username'];

    $sql = "UPDATE records 
            SET title = ?, content = ? 
            WHERE id = ? AND username = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $id, $username]);

    header("Location: main.php");
    exit;
}
