<?php
// Start or resume the session
session_start();

// Include the MongoDB PHP driver
require 'vendor/autoload.php';

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('user_details');

// Assuming you have the user's email stored in a session variable after login
if (isset($_SESSION['user_email'])) {
    $userEmail = $_SESSION['user_email'];

    // Query the MongoDB collection for the user with the provided email
    $user = $collection->findOne(['email' => $userEmail]);

    if ($user) {
        // Extract user details
        $fullName = $user['fullName'];
        $username = $user['username'];
        $email = $user['email'];
        $regNo = $user['regNo'];
        $phoneNumber = $user['phoneNumber'];
        $age = $user['age'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>

    <!-- Custom Css -->
    <link rel="stylesheet" href="uprofile.css">

    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <style>
        .balu {
            display: flex;
            justify-content: space-between; /* Align items with space between them */
            align-items: center;
            text-align: center;
            background-color: #38C6A3;
            width: 100%;
            height: 58px;
        }
        * {
    margin: 0;
    padding: 0;
    outline: none;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
div {
    display: block;
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
        </style>
</head>
<body>
    <!-- Navbar top -->
    <div class="balu">
        <h1 style="font-size: larger;font-weight: 700;margin-left: 10px;">LabGuard</h1>
        <div class="logout" style="right: 10px;position: relative;">
            <a href="uprofile.php" style="right: 29px;position: relative;text-decoration: auto;color: white;">Profile</a>
            <a href="viewissues.php" style="right: 17px;position: relative;text-decoration: auto;color: white;font-size: 16px;">View Issues</a>
            <a href="index.php" style="right: 4px;position: relative;text-decoration: auto;color: white;">LogOut 📤</a>
            </div>
    </div>
    <!-- End -->

    <!-- Main -->
    <div class="main">
        <h2>IDENTITY</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <table>
                    <tbody>
                        <tr>
                            <td>Full Name</td>
                            <td>:</td>
                            <td><?php echo $fullName; ?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td><?php echo $username; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <tr>
                            <td>Reg No</td>
                            <td>:</td>
                            <td><?php echo $regNo; ?></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><?php echo $phoneNumber; ?></td>
                        </tr>
                        <tr>
                            <td>Age</td>
                            <td>:</td>
                            <td><?php echo $age; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End -->
</body>
</html>
<?php
    } else {
        echo 'User not found.';
    }
} else {
    echo 'User email not available in session.';
}
?>
