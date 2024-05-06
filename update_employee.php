<?php
// Include the MongoDB PHP driver
require 'vendor/autoload.php';

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('employee');

// Receive the updated employee details from the request
$data = json_decode(file_get_contents('php://input'), true);

try {
    // Update the corresponding document in the MongoDB collection
    $updateResult = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($data['_id'])],
        ['$set' => [
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'title' => $data['title']
        ]]
    );

    // Check if the update operation was successful
    if ($updateResult->getModifiedCount() > 0) {
        // Send a success response
        echo json_encode(['success' => true]);
    } else {
        // Send an error response
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'error' => 'Failed to update employee details']);
    }
} catch (Exception $e) {
    // Handle any exceptions
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
