<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="ulogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover"> 
    <img class="backImg" src="wl.jpg" alt=""> 
      <div class="back">
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Worker Login</div>
          <form action="wlogin_process.php" method="post">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="username" placeholder="Enter your username" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
              </div>
              <!-- <div class="text"><a href="#">Forgot password?</a></div> -->
              <div class="button input-box">
                <input type="submit" value="SignIn">
              </div>
              <!-- <div class="text sign-up-text">Don't have an account? <a href="usignup.html"><label>Signup now</label></a></div> -->
            </div>
        </form>
      </div>
    </div>
    </div>
  </div>
</body>
</html>
