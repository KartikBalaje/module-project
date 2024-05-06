<?php
// Start or resume the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_email'])) {
    $userEmail = $_SESSION['user_email'];
} else {
    // Redirect to the login page or handle the case when the user is not logged in
    header("Location: /path/to/login.php");
    exit();
}

require 'vendor/autoload.php';

// Fetch issue history from MongoDB and convert the cursor to an array
$mongoUri = "mongodb://localhost:27017/";
$client = new MongoDB\Client($mongoUri);
$database = $client->selectDatabase('equipment');
$collection = $database->selectCollection('issues');
$cursor = $collection->find(['user_email' => $userEmail]);
$issues = iterator_to_array($cursor);

// Custom sorting function to arrange issues by status
usort($issues, function ($a, $b) {
    // Assigning numeric values for sorting: 0 for clear, 1 for resolved
    $aStatus = isset($a['status']) && $a['status'] == 'resolved' ? 1 : 0;
    $bStatus = isset($b['status']) && $b['status'] == 'resolved' ? 1 : 0;

    return $aStatus - $bStatus;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issues History</title>
    <style>
        body{
            overflow-x:hidden;
        }
        .balu {
            display: flex;
            justify-content: space-between; /* Align items with space between them */
            align-items: center;
            text-align: center;
            background: #38C6A3; 
            width: 100%;
            height: 58px;
        }
        body {
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 0;
            background: #BEF7E9;
        }

        table {
            width: 80%;
            margin: 55px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #38C6A3;
            padding: 10px;
            text-align: left;
            
        }

        th {
            background-color: #38C6A3;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .clear-btn {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .act{
            background-color:red;
        }
    </style>
</head>

<body>
<div class="balu">
        <h1 style="font-size: larger;font-weight: 700;margin-left: 10px;">LabGuard</h1>
        <div class="logout" style="right: 10px;position: relative;">
            <a href="uprofile.php" style="right: 29px;position: relative;text-decoration: auto;">Profile</a>
            <a href="issue.php" style="right: 17px;position: relative;text-decoration: auto;">Issues</a>
           <a href="index.php"> <button class="btnlogin-popup">LogOut</button></div></a>
    </div>
    <div class="text" style="left: 45%;top: 22px;font-size: larger;position: relative;">Your Issues History</div>
    <div class="container">
        
        <table>
            <thead>
                <tr>
                    <th>Equipment Name</th>
                    <th>Lab Name</th>
                    <th>Floor Number</th>
                    <th>Room Number</th>
                    <th>Issues</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach ($issues as $document): ?>
        <tr>
            <td><?php echo $document['equipmentName']; ?></td>
            <td><?php echo $document['labName']; ?></td>
            <td><?php echo $document['floorNumber']; ?></td>
            <td><?php echo $document['roomNumber']; ?></td>
            <td><?php echo $document['issues']; ?></td>
            <td>
                <?php if (isset($document['status']) && $document['status'] == 'resolved'): ?>
                    <span>Resolved</span>
                <?php else: ?>
                    <button class='clear-btn' onclick='clearIssue("<?php echo $document['_id']; ?>")'>
                        Clear Issue
                    </button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function clearIssue(issueId) {
            if (confirm("Are you sure you want to clear this issue?")) {
                // Make an AJAX request to update the issue status
                $.ajax({
                    type: "POST",
                    url: "clear_issues.php", // Create this PHP file to handle the server-side logic
                    data: { issueId: issueId },
                    success: function(response) {
                        if (response === "success") {
                            // Update the UI or perform any necessary actions
                            alert("Issue cleared successfully");
                            // You may want to remove the corresponding row from the table
                            location.reload(); // Reload the page for simplicity; you may want to update the DOM instead
                        } else {
                            alert("Failed to clear the issue");
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>
