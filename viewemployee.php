<?php
    require 'vendor/autoload.php'; // Include the MongoDB PHP driver
    
    // MongoDB connection string
    $mongoUri = "mongodb://localhost:27017/";
    $client = new MongoDB\Client($mongoUri);
    
    // Select the database and collection
    $database = $client->selectDatabase('equipment');
    $collection = $database->selectCollection('employee');
    
    // Retrieve employee data from MongoDB
    $cursor = $collection->find();
    
    ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Details</title>
    <link rel="stylesheet" href="mbar.css?v=2">
    <style>
        /* Your custom CSS styles here */
    </style>
</head>
<body>
<header style="background: #38C6A3">
    <h2>LabGuard</h2>
</header>
<nav>
    <ul>
        <li><a href="ms.php">Assing worker</a></li>
        <li><a href="add_user.php">Add Employee</a></li>
        <li><a href="viewemployee.php" class="active">Employee Details</a></li>
        <li><a href="mhistory.php">View Issue</a></li>
        <li><a href="assign_worker_sissues.php">Supervisor issues</a></li>
        <li><a href="index.php">LogOut 📤</a></li>
    </ul>
</nav>
<table>
    <thead>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Title</th>
        <th>Action</th> <!-- Add this column for Edit button -->
    </tr>
    </thead>
    <tbody>
    <?php 
    if ($cursor) {
        foreach ($cursor as $document): ?>
            <tr>
                <td><?php echo $document['firstName']; ?></td>
                <td><?php echo $document['lastName']; ?></td>
                <td><?php echo $document['email']; ?></td>
                <td><?php echo $document['title']; ?></td>
                <td><button onclick="openEditModal('<?php echo $document['_id']; ?>', '<?php echo $document['firstName']; ?>', '<?php echo $document['lastName']; ?>', '<?php echo $document['email']; ?>', '<?php echo $document['title']; ?>')">Edit</button>
                <button onclick="deleteEmployee('<?php echo $document['_id']; ?>')">Delete</button> <!-- Add Delete button -->
            </td> <!-- Add Edit button -->
            </tr>
    <?php 
        endforeach;
    } else {
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
    ?>
    </tbody>
</table>
<!-- Modal for editing employee details -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Employee Details</h2>
        <!-- Form for editing employee details -->
        <form id="editForm">
    <!-- Hidden input field for employee ID -->
    <input type="hidden" id="editId" name="editId" value="<?php echo $document['_id']; ?>">

    <!-- Input fields for editing employee details -->
    <label for="editFirstName">First Name:</label>
    <input type="text" id="editFirstName" name="editFirstName">
    <label for="editLastName">Last Name:</label>
    <input type="text" id="editLastName" name="editLastName"><br>
    <label for="editEmail">Email:</label>
    <input type="email" id="editEmail" name="editEmail"><br>
    <label for="editTitle">Title:</label>
    <input type="text" id="editTitle" name="editTitle"><br>

    <!-- Save button -->
    <input type="button" value="Save" onclick="saveEmployeeDetails()">
</form>

    </div>
</div>


<script>
    // Get the modal
    var editModal = document.getElementById('editModal');

    // Function to open the edit modal and populate fields with employee details
// Function to open the edit modal and populate fields with employee details
function openEditModal(employeeId, firstName, lastName, email, title) {
    // Populate the form fields with employee details
    document.getElementById('editFirstName').value = firstName;
    document.getElementById('editLastName').value = lastName;
    document.getElementById('editEmail').value = email;
    document.getElementById('editTitle').value = title;

    // Display the edit modal
    editModal.style.display = 'block';
}


    // Function to close the edit modalss
    function closeEditModal() {
        var editModal = document.getElementById('editModal');
        editModal.style.display = 'none';
    }

    // Call closeEditModal() to close the modal when needed
    // For example, when clicking a button
    function closePopup() {
        closeEditModal(); // Call the closeEditModal function
    }

    // Function to save edited employee details
// Function to save edited employee details
// Function to save edited employee details
function saveEmployeeDetails() {
    // Get the updated employee details from the form
    var editedEmployee = {
        _id: document.getElementById('editId').value,
        firstName: document.getElementById('editFirstName').value,
        lastName: document.getElementById('editLastName').value,
        email: document.getElementById('editEmail').value,
        title: document.getElementById('editTitle').value
    };

    // Send the updated employee details to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_employee.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Response from the server
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Employee details updated successfully
                    alert('Employee details updated successfully');
                    closeEditModal(); // Close the edit modal after updating
                } else {
                    // Error updating employee details
                    alert('Error updating employee details: ' + response.error);
                }
            } else {
                // Error handling HTTP status codes other than 200
                alert('Error: ' + xhr.status + ' ' + xhr.statusText);
            }
        }
    };
    xhr.send(JSON.stringify(editedEmployee));
}


    window.onclick = function(event) {
        if (event.target == editModal) {
            closeEditModal();
        }
    }
    
    // Function to delete an employee
function deleteEmployee(employeeId) {
    // Confirmation dialog before deleting
    var confirmDelete = confirm("Are you sure you want to delete this employee?");
    if (confirmDelete) {
        // Send the employee ID to the server for deletion
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_employee.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Response from the server
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Employee deleted successfully
                        alert('Employee deleted successfully');
                        // Optionally, you can reload the page to reflect the changes
                        location.reload();
                    } else {
                        // Error deleting employee
                        alert('Error deleting employee: ' + response.error);
                    }
                } else {
                    // Error handling HTTP status codes other than 200
                    alert('Error: ' + xhr.status + ' ' + xhr.statusText);
                }
            }
        };
        xhr.send(JSON.stringify({ employeeId: employeeId }));
    }
}

</script>
</body>
<style>
    /* Modal styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Adjust the width as needed */
}

/* Close button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

        /* Your CSS styles here */
        .custom-image {
            width: 170px;
            margin-left: 90px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #BEF7E9 !important;
        }

        a {
            text-decoration: none;
            color: black;
        }

        ul {
    list-style: none !important;
    padding: 6px !important;
}
        nav {
            background-color: white;
            color: white;
            padding: 1px;
            text-align: center;
        }

        li {
            display: inline;
            margin-right: 20px;
            font-size: 13px;
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
     
         body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
            }
    
          a {
                text-decoration: none;
                color: black;
            }
    
         ul {
                list-style: none;
                padding: 0;
            }
    
        nav {
                background-color: white;
                color: white;
                padding: 1px;
                text-align: center;
            }
    
        li {
                display: inline;
                margin-right: 20px;
                font-size: 13px;
            }
        tr{
            background-color:white;
        }
      /* Modal container */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    /* width: 100%; 
    height: 100%;  */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal content */
.modal-content {
    background-color: #fefefe;
    margin: 10% auto; /* 10% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 60%; /* Adjust width as needed */
}


/* Close button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Form label */
label {
    margin-top: 10px;
    margin-left: 150px;
    display: inline-block;
}

/* Form input fields */
input[type=text], input[type=email] {
    width: 100%
    padding: 12px 20px; 
    margin: 8px 0;
    box-sizing: border-box;
}

/* Save button */
input[type=button] {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    margin-left: 450px;
    border: none;
    cursor: pointer;
    /* width: 50%; */
}

input[type=button]:hover {
    background-color: #45a049;
}

    </style>
</html>
    