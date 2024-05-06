<?php

require 'vendor/autoload.php'; // Include the MongoDB PHP driver

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collections
$database = $client->selectDatabase('equipment');
$employeeCollection = $database->selectCollection('employee');
$workerCollection = $database->selectCollection('worker');
$supervisorCollection = $database->selectCollection('supervisor');

$response = ['status' => 'error', 'message' => 'Failed to add employee']; // Default response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve form data
        $firstName = $_POST['fname'];
        $lastName = $_POST['lname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $title = $_POST['title'];

        // Insert data into employee collection
        $employeeData = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'title' => $title,
        ];

        $employeeResult = $employeeCollection->insertOne($employeeData);

        // Insert data into specific collection based on title
        if ($title === 'worker') {
            $result = $workerCollection->insertOne($employeeData);
        } elseif ($title === 'supervisor') {
            $result = $supervisorCollection->insertOne($employeeData);
        }

        if ($employeeResult->getInsertedCount() > 0 && $result->getInsertedCount() > 0) {
            // Employee added successfully
            $response = ['status' => 'success', 'message' => 'Employee added successfully', 'redirect' => 'add_user.html'];
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode($response);
    }
} else {
    http_response_code(400);
    echo json_encode($response);
}
?>
