<?php
// Include the MongoDB PHP driver
require 'vendor/autoload.php';

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('supervisor_issues');

// Start or resume the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $equipmentName = isset($_POST['equipmentName']) ? trim($_POST['equipmentName']) : null;
        $labName = isset($_POST['labName']) ? trim($_POST['labName']) : null;
        $floorNumber = isset($_POST['floorNumber']) ? trim($_POST['floorNumber']) : null;
        $roomNumber = isset($_POST['roomNumber']) ? trim($_POST['roomNumber']) : null;
        $issues = isset($_POST['issues']) ? trim($_POST['issues']) : null;

        // Check if all required fields are present
        if ($equipmentName && $labName && $floorNumber && $roomNumber && $issues) {
            // Create a new document to insert into MongoDB
            $newDocument = [
                'username' => $username,
                'equipmentName' => $equipmentName,
                'labName' => $labName,
                'floorNumber' => $floorNumber,
                'roomNumber' => $roomNumber,
                'issues' => $issues,
            ];

            // Insert the new document into the MongoDB collection
            try {
                $insertResult = $collection->insertOne($newDocument);

                if ($insertResult->getInsertedCount() > 0) {
                    // Redirect to the desired page after successful insertion
                    header("Location: /equ health/viewsissues.php");
                    exit();
                } else {
                    echo "Failed to insert the document into MongoDB.";
                }
            } catch (MongoDB\Driver\Exception\Exception $e) {
                echo "MongoDB Error: " . $e->getMessage();
            }
        } else {
            echo "Please fill in all required fields.";
        }
    } else {
        echo "Invalid request method.";
    }
} else {
    echo "User not logged in.";
}
?>
