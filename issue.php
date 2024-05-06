<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Issues</title>
    <link rel="stylesheet" href="issue.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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
            background-color: #38C6A3;
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
   <?php
    // Start or resume the session
    session_start();
    
    // Check if the user is logged in
    if (isset($_SESSION['user_email'])) {
        $userEmail = $_SESSION['user_email'];
    } else {
        // Redirect to login page or handle the case when the user is not logged in
        header("Location: /path/to/login.php");
        exit();
    }
    ?>
    <div class="balu">
        <h1 style="font-size: larger;font-weight: 700;margin-left: 10px;">LabGuard</h1>
        <div class="logout" style="right: 10px;position: relative;">
            <a href="uprofile.php" style="right: 29px;position: relative;text-decoration: auto;color: white;">Profile</a>
            <a href="viewissues.php" style="right: 17px;position: relative;text-decoration: auto;color: white;font-size: 16px;">View Issues</a>
            <a href="index.php" style="right: 4px;position: relative;text-decoration: auto;color: white;">LogOut 📤</a>
            </div>
    </div>
    <div class="container" style="border: inset;border-color: greenyellow;">
        <div class="text">Raise Issues</div>
        <div class="text" style="font-size: 15px;bottom: 24px;position: relative;">(equipments)</div>
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
