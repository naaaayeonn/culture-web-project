<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Sign Up | MyStage</title>
  <link rel="stylesheet" href="stylogin.css">
</head>
<body>

<header class="header">
  <h1 class="logo">MyStage</h1>
</header>

<div class="container">
  <div class="login-card">
    <?php if (isset($_GET['error'])): ?>
  <div class="alert">
    <?php
      if ($_GET['error'] === 'password') {
        echo "비밀번호가 서로 일치하지 않습니다.";
      } elseif ($_GET['error'] === 'duplicate') {
        echo "이미 사용 중인 아이디입니다.";
      }
    ?>
  </div>
<?php endif; ?>


    <h2>회원가입</h2>

    <form action="signup_process.php" method="post">
      <input type="text" name="username" placeholder="아이디" required>
      <input type="password" name="password" placeholder="비밀번호" required>
      <input type="password" name="password_check" placeholder="비밀번호 확인" required>

      <button type="submit">가입하기</button>
    </form>

    <p class="signup-text">
      이미 계정이 있으신가요?
      <a href="login.php">로그인</a>
    </p>

  </div>
</div>

</body>
</html>
