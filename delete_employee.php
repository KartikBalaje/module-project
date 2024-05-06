<?php
// Include the MongoDB PHP driver
require 'vendor/autoload.php';

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('employee');

// Receive the employee ID from the request
$data = json_decode(file_get_contents('php://input'), true);
$employeeId = $data['employeeId'];

// Delete the corresponding document from the MongoDB collection
$deleteResult = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($employeeId)]);

// Send back a response indicating whether the deletion was successful
$response = ['success' => $deleteResult->getDeletedCount() > 0];
echo json_encode($response);
?>
