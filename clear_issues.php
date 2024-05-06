<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['issueId'])) {
        $issueId = $_POST['issueId'];

        require 'vendor/autoload.php';

        $mongoUri = "mongodb://localhost:27017/";
        $client = new MongoDB\Client($mongoUri);
        $database = $client->selectDatabase('equipment');
        $collection = $database->selectCollection('issues');

        // Update the status to 'resolved'
        $updateResult = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($issueId)],
            ['$set' => ['status' => 'resolved']]
        );

        if ($updateResult->getModifiedCount() > 0) {
            echo "success";
        } else {
            echo "failed";
        }
    } else {
        echo "failed";
    }
} else {
    echo "failed";
}
?>
