<!DOCTYPE html>
<html lang="en">
    <head> 
           <link rel="stylesheet" href="mbar.css?v=2">
    </head>
    <header style="background: #38C6A3">
      <h2>LabGuard</h2>
  </header>
  <nav>
      <ul>
      <li><a href="ms.php" >Assing worker</a></li>
              <li><a href="add_user.php" class="active">Add Employee</a></li>
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
    <div class="worker_form">
      <form id="worker_form" action="add_employee.php" method="post">

    <img src="owner.png" alt="Description of the image" class="custom-image"><br>
    <label for="fname">First Name*: </label><input type="text" id="fname" name="fname" ><br>
    <label for="lname">Last Name*: </label><input type="text" id="lname" name="lname" ><br>
    <label for="Username">Work username*: </label><input type="text" id="username" name="username" ><br>
    <label for="email">Work Email*: </label><input type="email" id="email" name="email" ><br>
    <label for="password">Work password*: </label><input type="text" id="password" name="password" ><br>
    <label for="phoneNumber">Workers phone number*: </label>
<input type="text" id="phoneNumber" name="phoneNumber" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" required><br>
    <label for="title">Select option: </label>
    <select id="title" name="title">
      <option value="worker">worker</option>
      <option value="supervisor">supervisor</option>
    </select><br>
    <input type="submit" value="Submit">
</form>
</div>
<script>
    document.getElementById('worker_form').addEventListener('submit', async function (event) {
        event.preventDefault();

        // Validate form fields before submission
        if (validateForm()) {
            const formData = new FormData(this);
            const response = await fetch('add_employee.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            console.log(result); // Log the response for debugging

            // Handle the response accordingly
            if (result.status === 'success') {
                alert('Employee added successfully');
                // Perform any additional actions if needed
            } else {
                alert('Failed to add employee');
            }
        } else {
            alert('Please fill in all fields before submitting');
        }
    });

    // Function to validate form fields
    function validateForm() {
        const inputs = document.querySelectorAll('#worker_form input, #worker_form select');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value) {
                isValid = false;
            }
        });

        return isValid;
    }
</script>


  <style>
    .custom-image {
    width:  154px;
    margin-left: 90px;
}
     body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #bef7e9;
            overflow: hidden;
        }

      a {
            text-decoration: none;
            color: black;
        }

     ul {
            list-style: none;
            padding: 6px;
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
  form {
    font-family: Arial, sans-serif;
    margin: -11px auto;
    left: 10px;
    position: relative;
    width: 349px;
    border: double;
    padding: 20px;
    padding-bottom: 1px;
    background-color: #f6f6f6;
  }
  
  label {
    display: block;
    margin-top: 10px;
  }
  
  input[type="text"], input[type="email"] {
    width: 332px;
    padding: 5px;
    margin-top: 5px;
  }

  #phoneNumber {
    margin-right: 10px;
    width: 333px;
    padding: 5px;
    margin-top: 5px;
}
  select {
    width:  341px;
    padding: 5px;
    margin-top: 5px;
  }
  
  input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px;
    margin-top: 15px;
    cursor: pointer;
    width: 260px;
    margin-left: 40px;
  }

  .worker_form {
    padding: 13px;

 }
</style>
