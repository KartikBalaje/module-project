<?php
// update_status.php
require 'vendor/autoload.php'; 
// Replace with your MongoDB connection details
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->equipment->supervisor_issues;

// Read the POST data containing the issueId
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->issueId)) {
    $issueId = new MongoDB\BSON\ObjectId($data->issueId);

    // Update the status to 'resolved'
    $result = $collection->updateOne(
        ['_id' => $issueId],
        ['$set' => ['status' => 'compeleted']]
    );

    if ($result->getModifiedCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
