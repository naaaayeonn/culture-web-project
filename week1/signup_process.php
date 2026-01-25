<?php
require 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$password_check = $_POST['password_check'];

if ($password !== $password_check) {
  header("Location: signup.php?error=password");
  exit;
}

$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);

if ($stmt->fetch()) {
  header("Location: signup.php?error=duplicate");
  exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username, $hashed]);

header("Location: login.php?signup=success");
exit;
