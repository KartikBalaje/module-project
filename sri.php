<?php
     // Start or resume the session
     session_start();
     
     // Check if the user is logged in
     if (isset($_SESSION['user_email'])) {
         $userEmail = $_SESSION['user_email'];
     } else {
         // Redirect to login page or handle the case when the user is not logged in
         header("Location: /path/to/slogin.php");
         exit();
     }
     ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="mbar.css?v=2">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: #1c0d3f;
            color: white;
            padding: 1px;
            text-align: center;
        }

        nav {
            background-color: white;
            color: white;
            padding: 1px;
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            display: inline;
            margin-right: 20px;
            font-size: 13px;
        }



        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #1c0d3f;
            color: white;
            text-align: center;
            padding: 10px;
        }





        body {
            overflow: hidden;
            margin: 0; /* Reset default margin */
            padding: 0; /* Reset default padding */
        }

        .balu {
            display: flex;
            justify-content: space-between; /* Align items with space between them */
            align-items: center;
            text-align: center;
            background-color: antiquewhite;
            width: 100%;
            height: 58px;
        }

        .profile,
        .view_issues,
        .logout {
            font-size: 1.1em;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            margin-right: 40px; /* Adjust margin to your liking */
        }

        .container {
            height: 565px;
            padding: 20px; /* Add some padding to the container */
        }

        .text {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .input-data {
            position: relative;
            margin-bottom: 25px;
        }

        input,
        textarea {
            width: 100%;
            border: none;
            outline: none;
            font-size: 1em;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }

        label {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: #333;
            font-size: 1em;
            pointer-events: none;
            transition: 0.5s;
        }

        input:focus~label,
        textarea:focus~label,
        input:valid~label,
        textarea:valid~label {
            transform: translateY(-150%);
            font-size: 0.8em;
            color: #8e44ad;
        }

        .underline {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 100%;
            background: #8e44ad;
            transform: scaleX(0);
            transition: 0.5s;
        }

        input:focus~.underline,
        textarea:focus~.underline,
        input:valid~.underline,
        textarea:valid~.underline {
            transform: scaleX(1);
        }

        .submit-btn {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        input[type="submit"] {
            background-color: #8e44ad;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
        }
    </style>
</head>
<body>

<header style="background: rgb(18,14,96);
background: linear-gradient(90deg, rgba(18,14,96,1) 0%, rgba(13,80,212,1) 50%, rgba(5,181,217,1) 100%);">
    <h2>Electrical Equipment</h2>
</header>
<nav>
    <ul>
    <li><a href="super.php">Home</a></li>
            <!-- <li><a href="add_user.html">Add Employee</a></li> -->
            <!-- <li><a href="addequipment.php">Add Equipment</a></li> -->
            <li><a href="sview_emp.php">Employee Details</a></li>
            <li><a href="shistory.php">View Issue</a></li>
            <li><a href="sissue.php">Raise Issues</a></li>
            <!-- <li><a href="choose.php">Assign Issue</a></li> -->
            <!-- <li><a href="Rating.php">Rating</a></li> -->
            <li><a href="sprofile.php">My Profile</a></li>
            <li><a href="index.html">Logout</a></li>
    </ul>
</nav>

     
     <div class="container">
         <div class="text">Raise Issues (equipments)</div>
         <form action="submit_issues.php" method="post">
          <div class="form-row">
              <div class="input-data">
                  <input type="text" name="equipmentName" required>
                  <div class="underline"></div>
                  <label for="equipmentName">Equipment Name</label>
              </div>
              <div class="input-data">
                  <input type="text" name="labName" required>
                  <div class="underline"></div>
                  <label for="labName">Lab Name</label>
              </div>
          </div>
          <div class="form-row">
              <div class="input-data">
                  <input type="text" name="floorNumber" required>
                  <div class="underline"></div>
                  <label for="floorNumber">Floor Number</label>
              </div>
              <div class="input-data">
                  <input type="text" name="roomNumber" required>
                  <div class="underline"></div>
                  <label for="roomNumber">Room Number</label>
              </div>
          </div>
          <div class="form-row">
              <div class="box input-data">
                  <textarea name="issues" rows="8" cols="80" style="height: 100px;top: 10px;position: relative;" required></textarea>
                  <div class="underline" style="top: 109px;"></div>
                  <label for="issues">Write the Issues</label>
              </div>
          </div>
 </div>
          <div class="form-row submit-btn">
              <div class="input-data">
                  <div class="inner"></div>
                  <input type="submit" value="Submit">
                               </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </form>
     </div>
 </body>
</html>
