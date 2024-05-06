<?php
// Start or resume the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle the case when the user is not logged in
    header("Location: slogin.html");
    exit();
}
?>
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

        .assign-worker-container {
            display: flex;
            align-items: center;
        }

        .assign-worker-dropdown {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<header style="background: #38C6A3">
    <h2>LabGuard</h2>
</header>
<nav>
    <ul>
            <li><a href="super.php" class="active">Home</a></li>
            <!-- <li><a href="add_user.html">Add Employee</a></li> -->
            <!-- <li><a href="addequipment.php">Add Equipment</a></li> -->
            <li><a href="sview_emp.php">Employee Details</a></li>
            <li><a href="shistory.php">View Issue</a></li>
            <li><a href="sissue.php">Raise Issues</a></li>
            <!-- <li><a href="choose.php">Assign Issue</a></li> -->
            <!-- <li><a href="Rating.php">Rating</a></li> -->
            <!-- <li><a href="sprofile.php">My Profile</a></li> -->
            <li><a href="index.html">Logout 📤</a></li>
    </ul>
</nav>

<div id="issuesContainer"></div>


<script>
    // Function to render issues in a table
    function renderIssuesTable(issues) {
    const issuesContainer = document.getElementById('issuesContainer');

    // Create a table
    const table = document.createElement('table');

    // Create table header
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    const headers = ['Equipment Name', 'Lab Name', 'Floor Number', 'Room Number', 'Assigned Worker', 'Action'];

    headers.forEach(headerText => {
        const th = document.createElement('th');
        th.appendChild(document.createTextNode(headerText));
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Create table body
    const tbody = document.createElement('tbody');

    issues.forEach(issue => {
        const row = document.createElement('tr');
        const values = [issue.equipmentName, issue.labName, issue.floorNumber, issue.roomNumber, issue.assignedWorker];

        values.forEach(value => {
            const td = document.createElement('td');
            td.appendChild(document.createTextNode(value));
            row.appendChild(td);
        });

        // Create a cell for the "Actions" buttons in the "Action" column
        const actionsCell = document.createElement('td');

        // Create "Done" button
        const doneButton = document.createElement('button');
        doneButton.textContent = 'Done';
        doneButton.style.backgroundColor = '#63c463'; // Green color for "Done"
        doneButton.style.borderRadius = '10px'; // Rounded corners
        doneButton.style.padding = '8px 16px'; // Increased padding for larger size
        // Add an event listener to handle the "Done" logic
        doneButton.addEventListener('click', () => showRatingPopup(issue._id['$oid']));
        actionsCell.appendChild(doneButton);

        // Add a gap between buttons
        const buttonGap = document.createElement('span');
        buttonGap.style.marginRight = '10px';
        actionsCell.appendChild(buttonGap);

        // Create "Redo" button
        const redoButton = document.createElement('button');
        redoButton.textContent = 'Redo';
        redoButton.style.backgroundColor = 'orange'; // Orange color for "Redo"
        redoButton.style.borderRadius = '10px'; // Rounded corners
        redoButton.style.padding = '8px 16px'; // Increased padding for larger size
        // Add an event listener to handle the "Redo" logic
        redoButton.addEventListener('click', () => showRemarksPopup(issue._id['$oid']));
        actionsCell.appendChild(redoButton);

        row.appendChild(actionsCell);
        tbody.appendChild(row);
    });

    table.appendChild(tbody);

    // Append the table to the container
    issuesContainer.appendChild(table);
}

function showRatingPopup(issueId) {
    // Display alert
    const userConfirmed = confirm(`Close the case issue for: ${issueId}`);

    if (userConfirmed) {
    // Check if 'issueId' is defined
    if (typeof issueId !== 'undefined') {
         // Log 'issueId' to the console for debugging
         console.log('issueId:', issueId);
        // Make an AJAX request to update the status in the database
        const url = 'sdone.php'; // Replace with your actual endpoint

        fetch(url, {
            method: 'POST', // or 'PUT', depending on your API
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                issueId: issueId,
                newStatus: 'resolved', // Update to the desired status
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Status updated successfully:', data);
        })
        .catch(error => {
            console.error('Error updating status:', error);
        });
    } else {
        console.error('Error: issueId is not defined.');
    }
}
}

function showRemarksPopup(issueId) {
    // Replace this with your actual remarks pop-up logic
    const remarks = prompt('Enter Remarks:');
    if (remarks !== null) {
        // User clicked OK in the prompt
        updateRemarksAndStatus(issueId, remarks);
    }
    
}
    // Function to handle the assignment logic
    function assignWorker(issue, selectedWorker) {
        // Replace this with your actual assignment logic
        console.log(`Assigned ${selectedWorker} to ${issue.equipmentName}`);
    }

   
    async function updateRemarksAndStatus(issueId, remarks) {
        
    try {
        // Convert issueId to string
        const issueIdString = typeof issueId === 'string' ? issueId : issueId.toString();

        console.log('Sending JSON data:', { issueId: issueIdString, remarks: remarks }); // Log JSON data
        const response = await fetch('sredo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ issueId: issueIdString, remarks: remarks }),  
        });

        if (!response.ok) {
            console.error('Fetch error:', response.status, response.statusText);
            throw new Error(`Failed to fetch: ${response.status} ${response.statusText}`);
        }

        const data = await response.json();
        if (data.success) {
            console.log('Remarks updated successfully!');
            alert(`Remarks updated successfully!`);
            // Reload the page after the user clicks "OK"
            location.reload();
        } else {
            console.error(`Failed to update remarks. ${data.message}`);
            alert(`Failed to update remarks. ${data.message}`);
        }
    } catch (error) {
        console.error('Error updating remarks:', error);
        console.error('Details:', error.message, error.stack);
        alert('An error occurred while updating remarks.');
    }
}



    // Function to fetch issues from the server and update the HTML
    async function fetchIssues() {
        try {
            // Replace '/equ health/endpoint.php' with the actual path to your PHP endpoint
            const response = await fetch('/equ health/endpoint.php?action=getIssues');
            const data = await response.json();
            renderIssuesTable(data);
        } catch (error) {
            console.error('Error fetching issues:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchIssues();
    });
</script>

</body>
</html>
