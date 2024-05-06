<?php

require 'vendor/autoload.php'; // Include the MongoDB PHP driver

// Add your MongoDB connection details and other configurations here
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->equipment->supervisor_issues;

// Decode JSON data from the request body
$data = json_decode(file_get_contents("php://input"));

// Assuming you receive the issueId through JSON
$issueId = $data->issueId ?? null;

if ($issueId) {
    // Fetch remarks based on issueId
    $document = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($issueId)]);

    if ($document) {
        $remarks = $document['remarks'] ?? 'No remarks available';
        echo json_encode(['success' => true, 'remarks' => $remarks]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Issue not found']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}
?>