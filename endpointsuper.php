<?php
require 'vendor/autoload.php'; // Include the MongoDB PHP driver

// Replace with your MongoDB connection details
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->equipment;
$issuesCollection = $database->supervisor_issues;
$workersCollection = $database->worker;

// Function to fetch issues from the database
function getIssues() {
    global $issuesCollection;
    try {
        $cursor = $issuesCollection->find([
            '$and' => [
                ['$or' => [['status' => null], ['status' => 'compeleted'], ['status' => 'nil']]],
                ['status' => ['$ne' => 'resolved']] // Exclude 'resolved' status
            ]
        ]);

        $issues = iterator_to_array($cursor);
        return $issues;
    } catch (MongoDB\Driver\Exception\Exception $e) {
        return ['error' => 'Failed to fetch issues.'];
    }
}

// Function to fetch workers from the database
function getWorkers() {
    global $workersCollection;
    try {
        $cursor = $workersCollection->find();
        $workers = iterator_to_array($cursor);
        return $workers;
    } catch (MongoDB\Driver\Exception\Exception $e) {
        return ['error' => 'Failed to fetch workers.'];
    }
}

// Function to assign a worker to an issue
// Function to assign a worker to an issue
function assignWorker($issueId, $selectedWorker) {
    global $issuesCollection;

    try {
        // Convert $issueId to MongoDB ObjectId
        $issueObjectId = new MongoDB\BSON\ObjectId($issueId);

        // Update the issue with the selected worker's username
        $result = $issuesCollection->updateOne(
            ['_id' => $issueObjectId],
            ['$set' => ['assignedWorker' => $selectedWorker]]
        );

        if ($result->getModifiedCount() > 0) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'No modifications. Issue might not exist or worker already assigned.'];
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        // Log the error for debugging
        error_log('Error updating issue: ' . $e->getMessage());

        return ['success' => false, 'message' => 'Error updating issue.'];
    }
}


// Handle different actions
if (isset($_GET['action'])) {
    header('Content-Type: application/json');

    switch ($_GET['action']) {
        case 'getIssues':
            $issues = getIssues();
            echo json_encode($issues);
            break;

        case 'getWorkers':
            $workers = getWorkers();
            echo json_encode($workers);
            break;

        case 'assignWorker':
            $issueId = $_POST['issueId'];
            $selectedWorker = $_POST['selectedWorker'];
            $result = assignWorker($issueId, $selectedWorker);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['error' => 'Action parameter missing']);
}
?>
