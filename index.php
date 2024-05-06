<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="ulogin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .forms .form-content .button {
      color: #000;
      margin-top: 40px;
      padding: 10px; /* Adjust padding as needed */
      margin-left: 10px;
      background: #33FFCC;
      transition: background 0.3s; /* Adding transition for smooth effect */
      width: 150px; /* Fixed width for all buttons */
      height: 70px;/* Fixed height for all buttons */
      display: inline-block; /* Ensures buttons are displayed inline */
      text-align: center; /* Centers the text horizontally */
      line-height: 50px; /* Centers the text vertically */
      font-size: 17px; /* Set font size to make the text bigger */
      border: none; /* Remove button border */
      cursor: pointer; /* Change cursor to pointer on hover */
      text-decoration: none; /* Remove underline from links */
    }

    /* Change background color on hover */
    .forms .form-content .button:hover {
      background: #00cc99; /* Change to a different color when hovering */
    }

    /* Style hyperlinks within buttons */
    .forms .form-content .button a {
      text-decoration: none; /* Disable underline */
      color: inherit; /* Inherit color from parent */
    }
  </style>
</head>

<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <img class="backImg" src="ml.jpg" alt="">
      <div class="back">
        <img class="backImg" src="images/backImg.jpg" alt="">
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Manager Login</div>
          <!-- Button Boxes -->
          <div class="button-boxes">
            <a href="ulogin.html" class="button">User</a>
            <a href="mlogin.php" class="button">Manager</a>
            <a href="slogin.html" class="button">Supervisor</a>
            <a href="wlogin.php" class="button">Worker</a>
          </div>
          <!-- End Button Boxes -->
        </div>
      </div>
    </div>
  </div>
</body>

</html>
