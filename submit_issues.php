<?php
// Include the MongoDB PHP driver
require 'vendor/autoload.php';

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('issues');

// Start or resume the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_email'])) {
    $userEmail = $_SESSION['user_email'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $equipmentName = isset($_POST['equipmentName']) ? $_POST['equipmentName'] : null;
        $labName = isset($_POST['labName']) ? $_POST['labName'] : null;
        $floorNumber = isset($_POST['floorNumber']) ? $_POST['floorNumber'] : null;
        $roomNumber = isset($_POST['roomNumber']) ? $_POST['roomNumber'] : null;
        $issues = isset($_POST['issues']) ? $_POST['issues'] : null;

        // Check if all required fields are present
        if ($equipmentName && $labName && $floorNumber && $roomNumber && $issues) {
            // Create an array with the data to be inserted
            $issueData = [
                'user_email' => $userEmail,
                'equipmentName' => $equipmentName,
                'labName' => $labName,
                'floorNumber' => $floorNumber,
                'roomNumber' => $roomNumber,
                'issues' => $issues,
            ];

            // Insert the data into the MongoDB collection
            $insertResult = $collection->insertOne($issueData);

            if ($insertResult->getInsertedCount() > 0) {
                header("Location: /equ health/viewissues.php");
            } else {
                echo "Failed to submit issue.";
            }
        } else {
            echo "Please fill in all required fields.";
        }
    } else {
        echo "Invalid request method.";
    }
} else {
    // Redirect to login page or handle the case when the user is not logged in
    header("Location: /path/to/login.php");
    exit();
}
?>
