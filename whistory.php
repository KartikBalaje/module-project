<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="mbar.css?v=2">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #BEF7E9;
        }

        header {
            background-color: #1c0d3f;
            color: white;
            padding: 1px;
            text-align: center;
        }

        nav {
            background-color: white;
            color: white;
            padding: 1px;
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 6px !important;
        }

        tr{
            background-color:white;
        }

        li {
            display: inline;
            margin-right: 20px;
            font-size: 13px;
        }

        a {
            text-decoration: none;
            color: black;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #1c0d3f;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #1c0d3f;
            color: white;
            text-align: center;
            padding: 10px;
        }
        .done{
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
}
.show{
    background-color: #ff3a20;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
}
        
    </style>
</head>
<body>

<header style="background: #38C6A3">
    <h2>LabGuard</h2>
</header>
<nav>
    <ul>
    <!-- <li><a href="ms.php">Home</a></li> -->
            <li><a href="whistory.php" class="active">View issues</a></li>
            <li><a href="wsuperhistory.php">Supervisor issues</a></li>
            <!-- <li><a href="mhistory.php">View Issue</a></li> -->
            <!-- <li><a href="profile.php">My Profile</a></li> -->
            <li><a href="index.php">Logout 📤</a></li>
    </ul>
</nav>





<div id="issuesContainer"></div>

<?php
// Start the session
session_start();

require 'vendor/autoload.php'; 

// Replace with your MongoDB connection details
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");

// Select the database and collection
$collection = $mongoClient->equipment->issues;

// Fetch the logged-in worker's username from the session
$loggedInUsername = $_SESSION['username'] ?? null;

// Fetch issues with no status or status is nil for the assigned worker
$cursor = $collection->find([
    'assignedWorker' => ['$eq' => $loggedInUsername],
    '$or' => [['status' => null], ['status' => 'nil']],
]);

echo '<table>';
echo '<tr><th>Equipment Name</th><th>Lab Name</th><th>Floor Number</th><th>Room Number</th><th>Action</th><th>Remarks</th></tr>';

foreach ($cursor as $document) {
    echo '<tr>';
    echo '<td>' . $document['equipmentName'] . '</td>';
    echo '<td>' . $document['labName'] . '</td>';
    echo '<td>' . $document['floorNumber'] . '</td>';
    echo '<td>' . $document['roomNumber'] . '</td>';
    echo '<td><button class="done" onclick="updateStatus(\'' . $document['_id'] . '\')">Done</button></td>';

    echo '<td><button class="show" onclick="showRemarks(\'' . $document['_id'] . '\')">Show</button></td>'; // New button for showing remarks
    echo '</tr>';
}

echo '</table>';
?>


<script>
   function updateStatus(issueId) {
    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ issueId: issueId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status updated successfully!');
                // Reload the page after the user clicks "OK"
                location.reload();
            } else {
                alert('Failed to update status. ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('An error occurred while updating status.');
        });
}

    function showRemarks(issueId) {
        fetch('get_remarks.php', { // Replace with the actual endpoint to fetch remarks
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ issueId: issueId }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Remarks: ' + data.remarks);
                } else {
                    alert('Failed to fetch remarks. ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('An error occurred while fetching remarks.');
            });
    }
</script>


</body>
</html>
