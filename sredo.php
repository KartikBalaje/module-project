<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php'; // Include the MongoDB PHP driver

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read raw JSON data from the request
    $json_data = file_get_contents("php://input");

    // Decode the JSON data
    $data = json_decode($json_data, true);

    // Check if 'issueId' is set in the decoded data
    if (isset($data['issueId']) && isset($data['remarks'])) {
        // Assign 'issueId' and 'remarks' from decoded data
        $issueId = $data['issueId'];
        $remarks = $data['remarks'];

        // MongoDB connection parameters
        $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
        $database = $mongoClient->equipment; // Change to your actual database name
        $collection = $database->issues; // Change to your actual collection name
        
        // Update remarks and remove status in MongoDB
        $filter = ['_id' => new MongoDB\BSON\ObjectID($issueId)];;
        $update = [
            '$set' => [
                'remarks' => $remarks,
                'status' => 'nil' // Remove 'status' field
            ]
        ];
        

        $result = $collection->updateOne($filter, $update);

        if ($result->getModifiedCount() > 0) {
            // Remarks and status updated successfully
            $response = ['success' => true, 'message' => 'Remarks and status updated successfully'];
            http_response_code(200);
        } else {
            // Failed to update remarks and status
            $response = ['success' => false, 'message' => 'Failed to update remarks and status', 'error' => $result->getWriteErrors()];
            http_response_code(500);
        }
        

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit; // Ensure no further output
    } else {
        // 'issueId' or 'remarks' is not set in the decoded data
        http_response_code(400); // Bad Request
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Missing or invalid issueId or remarks in JSON data']);
    }
} else {
    // Not a POST request
    http_response_code(405); // Method Not Allowed
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Only POST requests are allowed']);
}
?>
