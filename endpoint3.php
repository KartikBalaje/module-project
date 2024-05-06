<?php

require 'vendor/autoload.php'; // Include the MongoDB PHP driver

// MongoDB connection string
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);

// Select the database and collection
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('issues');

// Endpoint for fetching issues from MongoDB
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getIssues') {
    try {
        // Filter to fetch issues with status not equal to "resolve"
        $filter = ['status' => ['$ne' => 'resolved']];
        $cursor = $collection->find($filter);

        $issues = iterator_to_array($cursor);

        header('Content-Type: application/json');
        echo json_encode($issues);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request']);
}
?>
