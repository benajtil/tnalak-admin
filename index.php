<?php
session_start();
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);

if (isset($_SESSION['username'])) {
    header("Location: float/judgeTable.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<div class="background_image">
        <img src="images/tnalakbg.png" alt="T'nalak Background" class="background_image">
    </div>
  <div class="container">
    <div class="screen">
      <img src="/images/Eulap.png" alt="eulap" class="eulaplogo">
      <img src="/images/background.png" alt="Image" class="screen__image">
      <div class="screen__content">
        <form action="login.php" method="post">
          <div class="loginbox">
            <div class="login__field">
              <i class="login__icon fas fa-user"></i>
              <input type="text" class="login__input" placeholder="Username" name="username" required>
            </div>
            <div class="login__field">
              <i class="login__icon fas fa-lock"></i>
              <input type="password" class="login__input" placeholder="Password" name="password" required>
            </div>
            <button class="button login__submit">
              <span class="button__text">Log In Now</span>
            </button>
            <?php if (!empty($error_message)): ?>
              <div class="error-message" id="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <script src="js/login.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const errorMessage = document.getElementById('error-message');
      if (errorMessage.textContent !== '') {
        errorMessage.style.display = 'block';
      }
    });
  </script>
</body>
</html>
