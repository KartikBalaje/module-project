<?php

// Your MongoDB connection code here

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    try {
        if ($_GET['action'] === 'getIssues') {
            // Your code to fetch and return issues
            header('Content-Type: application/json');
            echo json_encode(['example' => 'issues data']);
        } elseif ($_GET['action'] === 'markAsDone' && isset($_GET['id'])) {
            // Your code to update the issue status
            $issueId = $_GET['id'];

            // Use the correct field for identification (assuming it's '_id')
            $result = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectID($issueId)],
                ['$set' => ['status' => 'resolved']]
            );

            if ($result->getModifiedCount() > 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Issue not found or not modified']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Bad Request']);
        }
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Bad Request']);
}
?>
