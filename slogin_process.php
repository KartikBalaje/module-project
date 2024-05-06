<?php
require 'vendor/autoload.php'; // Include the MongoDB PHP driver

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('supervisor');

// Start or resume the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Check if both username and password are present
    if ($username && $password) {
        // Query the MongoDB collection for the user with the provided username and password
        $user = $collection->findOne(['username' => $username, 'password' => $password]);

        // Debug statement: Output user data
        var_dump($user);

        if ($user) {
            // Login successful
            $_SESSION['username'] = $username;
            echo "<script>alert('Login successful!');</script>";
            header("Location: /equ health/super.php");
            exit; // Important to prevent further execution of the script
        } else {
            // Login failed
            echo "<script>alert('Invalid username or password.');</script>";
            echo "<script>window.location.href = 'slogin.html';</script>";
            exit; // Important to prevent further execution of the script
        }
    } else {
        // Username or password missing
        echo "<script>alert('Username and password are required.');</script>";
        echo "<script>window.location.href = 'slogin.html';</script>";
        exit; // Important to prevent further execution of the script
    }
} else {
    // Invalid request method
    echo "<script>alert('Invalid request method.');</script>";
    echo "<script>window.location.href = 'slogin.html';</script>";
    exit; // Important to prevent further execution of the script
}
?>
