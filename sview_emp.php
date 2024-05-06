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
        <link rel="stylesheet" href="mbar.css?v=2">
    </head>
    <body>
    <header style="background: #38C6A3">
    <h2>LabGuard</h2>
</header>
        <nav>
            <ul>
            <li><a href="super.php">Home</a></li>
            <!-- <li><a href="add_user.html">Add Employee</a></li> -->
            <!-- <li><a href="addequipment.php">Add Equipment</a></li> -->
            <li><a href="sview_emp.php" class="active" >Employee Details</a></li>
            <li><a href="shistory.php">View Issue</a></li>
            <li><a href="sissue.php">Raise Issues</a></li>
            <!-- <li><a href="choose.php">Assign Issue</a></li> -->
            <!-- <li><a href="Rating.php">Rating</a></li> -->
            <!-- <li><a href="profile.php">My Profile</a></li> -->
            <li><a href="index.html">Logout</a></li>
            </ul>
        </nav>
        <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cursor as $document): ?>
    <?php if ($document['title'] == 'worker'): ?>
        <tr>
            <td><?php echo $document['firstName']; ?></td>
            <td><?php echo $document['lastName']; ?></td>
            <td><?php echo $document['email']; ?></td>
            <td><?php echo $document['title']; ?></td>
        </tr>
    <?php endif; ?>
<?php endforeach; ?>
        </tbody>
    </table>
    </body>
    <style>
            <style>
        .custom-image {
            width: 170px;
            margin-left: 90px;
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
            padding: 6px !important;
        }

        tr{
            background-color:white;
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
                background-color: #BEF7E9;
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
      
    </style>
    </html>
    