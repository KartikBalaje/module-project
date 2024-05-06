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
        tr{
            background-color: white;
        }
    </style>
</head>
<body>

<header style="background: #38C6A3">
      <h2>LabGaurd</h2>
  </header>
  <nav>
      <ul>
      <li><a href="ms.php" >Assing worker</a></li>
              <li><a href="add_user.php" >Add Employee</a></li>
              <!-- <li><a href="addequipment.php">Add Equipment</a></li> -->
              <li><a href="viewemployee.php" >Employee Details</a></li>
              <li><a href="mhistory.php" class="active">View Issue</a></li>
              <li><a href="assign_worker_sissues.php">Supervisor issues</a></li>
              <!-- <li><a href="mainstatus.php">Work Status</a></li> -->
              <!-- <li><a href="choose.php">Assign Issue</a></li> -->
              <!-- <li><a href="Rating.php">Rating</a></li> -->
              <!-- <li><a href="profile.php">My Profile</a></li> -->
              <li><a href="index.php">LogOut 📤</a></li>
      </ul>
  </nav>

<div id="issuesContainer"></div>

<footer>
    <!-- Your footer content goes here -->
    &copy; 2024 Your Company Name
</footer>
<script>
    // Function to render issues in a table
    function renderIssuesTable(issues) {
        const issuesContainer = document.getElementById('issuesContainer');

        // Create a table
        const table = document.createElement('table');

        // Create table header
        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');
        const headers = ['Equipment Name', 'Lab Name', 'Floor Number', 'Room Number', 'Status'];

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
            const values = [issue.equipmentName, issue.labName, issue.floorNumber, issue.roomNumber, issue.status];

            values.forEach(value => {
                const td = document.createElement('td');
                td.appendChild(document.createTextNode(value));
                row.appendChild(td);
            });

            tbody.appendChild(row);
        });

        table.appendChild(tbody);

        // Append the table to the container
        issuesContainer.appendChild(table);
    }

    // Function to fetch issues from the server and update the HTML
    async function fetchIssues() {
        try {
            // Replace '/equ health/endpoint.php' with the actual path to your PHP endpoint
            const response = await fetch('/equ health/endpoint2.php?action=getIssues');
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
