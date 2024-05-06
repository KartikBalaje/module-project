<?php

require 'vendor/autoload.php'; // Include the MongoDB PHP driver

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('user_details');

// Start or resume the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Check if both email and password are present
    if ($email && $password) {
        // Query the MongoDB collection for the user with the provided email
        $user = $collection->findOne(['email' => $email]);

        if ($user) {
            // User found, verify the password
            if ($user['password'] === $password) {
                // Password is correct, set session variables
                $_SESSION['user_email'] = $email;
                $_SESSION['user_id'] = (string)$user['_id'];

                // Proceed with login
                echo "<script>alert('Login successful!');</script>";
                header("Location: /equ health/issue.php");
                exit; // Important to prevent further execution of the script
            } else {
                echo "<script>alert('Invalid password.');</script>";
                echo "<script>window.location.href = 'ulogin.html';</script>";
            }
        } else {
            echo "<script>alert('Email and password are required.');</script>";
            echo "<script>window.location.href = 'ulogin.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid request method.');</script>";
        echo "<script>window.location.href = 'ulogin.html';</script>";
    }
}
?>
