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
            padding: 6px;
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
        .active{
            color:black;
        }

        .assign-worker-container {
            display: flex;
            align-items: center;
        }

        .assign-worker-dropdown {
            margin-right: 10px;
        }
        tr{
            background-color:white;
        }
    </style>
</head>
<body>

<header style="background: #38C6A3">
    <h2>LabGaurd</h2>
</header>
<nav>
    <ul>
    <li><a href="ms.php" class="active">Assign worker</a></li>
            <li><a href="add_user.php">Add Employee</a></li>
            <!-- <li><a href="addequipment.php">Add Equipment</a></li> -->
            <li><a href="viewemployee.php">Employee Details</a></li>
            <li><a href="mhistory.php">View Issue</a></li>
            <li><a href="assign_worker_sissues.php">Supervisor issues</a></li>
            <!-- <li><a href="mainstatus.php">Work Status</a></li> -->
            <!-- <li><a href="choose.php">Assign Issue</a></li> -->
            <!-- <li><a href="Rating.php">Rating</a></li> -->
            <!-- <li><a href="profile.php">My Profile</a></li> -->
            <li><a href="index.php">LogOut 📤</a></li>
    </ul>
</nav>

<div id="issuesContainer"></div>

<!-- <footer>
    &copy; 2024 Your Company Name
</footer> -->
<script>
// Function to render issues in a table
function renderIssuesTable(issues) {
    const issuesContainer = document.getElementById('issuesContainer');

    // Create a table
    const table = document.createElement('table');

    // Create table header
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    const headers = ['Equipment Name', 'Lab Name', 'Floor Number', 'Room Number', 'Assign Worker', 'Action'];

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
        const values = [issue.equipmentName, issue.labName, issue.floorNumber, issue.roomNumber];

        values.forEach(value => {
            const td = document.createElement('td');
            td.appendChild(document.createTextNode(value));
            row.appendChild(td);
        });

        // Create a dropdown for assigning workers
        const assignWorkerCell = document.createElement('td');
        const assignWorkerContainer = document.createElement('div');
        assignWorkerContainer.classList.add('assign-worker-container');

        const assignWorkerDropdown = document.createElement('select');
        assignWorkerDropdown.classList.add('assign-worker-dropdown');
        // Add options dynamically, replace with your logic
        const workerOptions = ['Worker 1', 'Worker 2', 'Worker 3'];
        workerOptions.forEach(worker => {
            const option = document.createElement('option');
            option.value = worker;
            option.text = worker;
            assignWorkerDropdown.appendChild(option);
        });

        assignWorkerContainer.appendChild(assignWorkerDropdown);
        assignWorkerCell.appendChild(assignWorkerContainer);
        row.appendChild(assignWorkerCell);

        // Create a cell for the "Assign" button in the "Action" column
        const actionCell = document.createElement('td');
        const assignButton = document.createElement('button');
        assignButton.textContent = 'Assign';
        // Add an event listener to handle the assignment logic
        assignButton.addEventListener('click', () => assignWorker(issue, assignWorkerDropdown.value));

        actionCell.appendChild(assignButton);
        row.appendChild(actionCell);

        tbody.appendChild(row);
    });

    table.appendChild(tbody);

    // Append the table to the container
    issuesContainer.appendChild(table);
}


// Function to handle the assignment logic
async function assignWorker(issue, selectedWorker) {
    try {
        console.log('Assigning worker:', selectedWorker, 'to issue:', issue._id.$oid);

        const response = await fetch('/equ health/endpoint.php?action=assignWorker', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded', // Change the content type
            },
            body: new URLSearchParams({
                'issueId': issue._id.$oid,
                'selectedWorker': selectedWorker,
            }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        console.log('Response from server:', data);

        if (data.success) {
            console.log(`Assigned ${selectedWorker} to ${issue.equipmentName}`);
            alert('Issue assigned successfully!');
            // Refresh the page or update the UI as needed
            fetchIssues(); // Assuming fetchIssues() updates the table and dropdowns
        } else {
            console.error('Failed to assign worker:', data.message);
            alert(`Failed to assign worker: ${data.message}`);
        }
    } catch (error) {
        console.error('Error assigning worker:', error);
        alert('Error assigning worker. Please try again.');
    }
}




// Function to fetch worker data from the server
async function fetchWorkers() {
    try {
        const response = await fetch('/equ health/endpoint.php?action=getWorkers');
        const data = await response.json();
        return data || []; // Return the array of workers directly
    } catch (error) {
        console.error('Error fetching workers:', error);
        return [];
    }
}

// Function to populate worker dropdowns
// Function to populate worker dropdowns
async function populateWorkerDropdowns() {
    const issuesContainer = document.getElementById('issuesContainer');
    const dropdowns = issuesContainer.querySelectorAll('.assign-worker-dropdown');

    try {
        const workers = await fetchWorkers();

        dropdowns.forEach(dropdown => {
            // Clear existing options
            dropdown.innerHTML = '';

            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.text = 'Select Worker';
            dropdown.appendChild(defaultOption);

            // Add workers from the database
            workers.forEach(worker => {
                // Adapt this based on your worker data structure
                const option = document.createElement('option');
                option.value = worker.username || '';
                option.text = worker.firstName || '';
                dropdown.appendChild(option);
            });
        });
    } catch (error) {
        console.error('Error populating worker dropdowns:', error);
    }
}

// Function to fetch worker data from the server
async function fetchWorkers() {
    try {
        const response = await fetch('/equ health/endpoint.php?action=getWorkers');
        const data = await response.json();
        console.log('Received worker data:', data); // Add this line for debugging
        return data || [];
    } catch (error) {
        console.error('Error fetching workers:', error);
        return [];
    }
}




// Function to fetch issues from the server and update the HTML
async function fetchIssues() {
    try {
        const response = await fetch('/equ health/endpoint.php?action=getIssues');
        const data = await response.json();
        document.getElementById("issuesContainer").innerHTML = "";
        renderIssuesTable(data);
        await populateWorkerDropdowns(); // Populate worker dropdowns after rendering the table
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
