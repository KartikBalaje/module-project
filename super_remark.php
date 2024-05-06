<?php
require 'vendor/autoload.php';

// Assuming you have already established the MongoDB connection

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $issueId = $_POST['issueId'];
        $remark = $_POST['remark'];

        // Convert issueId back to ObjectID
        $issueId = new MongoDB\BSON\ObjectID($issueId);

        $mongoUri = "mongodb://localhost:27017/";
        $client = new MongoDB\Client($mongoUri);

        $database = $client->selectDatabase('equipment'); // Replace with your actual database name
        $collection = $database->selectCollection('supervisor_issues');

        $result = $collection->updateOne(
            ['_id' => $issueId],
            ['$set' => ['remark' => $remark]]
        );

        if ($result->getModifiedCount() > 0) {
            echo 'success';
        } else {
            echo 'failed';
        }
    } else {
        echo 'Invalid request';
    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>
