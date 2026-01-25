<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Main</title>
</head>
<body>

<h2>로그인 성공</h2>
<p><?php echo $_SESSION['username']; ?> 님 환영합니다.</p>

</body>
</html>
