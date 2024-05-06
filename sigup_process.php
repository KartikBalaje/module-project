<?php

require 'vendor/autoload.php'; // Include the MongoDB PHP driver

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('user_details');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $fullName = isset($_POST['fullName']) ? $_POST['fullName'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : null;
    $regNo = isset($_POST['regNo']) ? $_POST['regNo'] : null;
    $age = isset($_POST['age']) ? $_POST['age'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Check if all required fields are present
    if ($fullName && $username && $email && $phoneNumber && $regNo && $age && $password) {
        // Create an array with user details
        $userDetails = [
            'fullName' => $fullName,
            'username' => $username,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'regNo' => $regNo,
            'age' => $age,
            'password' => $password,
        ];

        // Insert user details into MongoDB collection
        $result = $collection->insertOne($userDetails);

        // Check if the insertion was successful
        if ($result->getInsertedCount() > 0) {
            header("Location: /equ health/ulogin.html");
        } else {
            echo "Error registering user.";
        }
    } else {
        echo "Some required fields are missing.";
    }
} else {
    echo "Invalid request method.";
}

?>
