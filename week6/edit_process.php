<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $performance_date = $_POST['performance_date'];
    $content = $_POST['content'];
    $id = $_POST['id'];
    $username = $_SESSION['username'];

    $sql = "SELECT image FROM records WHERE id = ? AND username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $imageName = $row['image']; // 기본은 기존 이미지 유지


    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {

        $uploadDir = "uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newImageName = time() . "_" . basename($_FILES['photo']['name']);

        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            $uploadDir . $newImageName
        );
        if ($row['image'] && file_exists("uploads/" . $row['image'])) {
            unlink("uploads/" . $row['image']);
        }

        $imageName = $newImageName; 
    }


    $sql = "UPDATE records
            SET title = ?, 
                artist = ?, 
                performance_date = ?, 
                content = ?,
                image = ?
            WHERE id = ? AND username = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $title,
        $artist,
        $performance_date,
        $content,
        $imageName,
        $id,
        $username
    ]);

    header("Location: main.php");
    exit;
}
