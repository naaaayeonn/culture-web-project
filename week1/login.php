<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="stylogin.css">

</head>
<body>
  <header class="header">
    <h1 class="logo">MyStage</h1>
  </header>

  <?php if (isset($_GET['error'])): ?>
  <div class="alert">
    아이디 또는 비밀번호가 올바르지 않습니다.
  </div>
<?php endif; ?>

  <div class="container">
    <div class="login-card">
      <h2>로그인</h2>

      <form action="login_process.php" method="post">
        <input type="text" name="username" placeholder="아이디" required>
        <input type="password" name="password" placeholder="비밀번호" required>
        <button type="submit">로그인</button>
      </form>

      <p class="signup-text">
        회원이 아니신가요?
        <a href="signup.php">회원가입하기</a>
      </p>
    </div>
  </div>
</body>
</html>
