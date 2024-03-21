<?php
// Include the database connection
require_once "dbconnect.php";

// Start the session
session_start();

// Function to check if courtID exists in the database
function isCourtIDExists($conn, $courtID) {
    $sql = "SELECT courtID FROM courtinfo WHERE courtID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $courtID);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve court information from the form
    $courtID = $_POST['courtID'];
    $courtType = $_POST['courtType'];
    $courtName = $_POST['courtName'];
    $courtPrice = $_POST['courtPrice'];

    // Check if courtID already exists
    if (isCourtIDExists($conn, $courtID)) {
        // Redirect to adminmanagecourt.php with error message
        header("Location: adminadd_court.php?add_error=court_exists");
        exit();
    }

    // SQL query to insert court information into the database
    $insertSql = "INSERT INTO courtinfo (courtID, courtType, courtName, courtPrice) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssss", $courtID, $courtType, $courtName, $courtPrice);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to adminmanagecourt.php after successful addition
        header("Location: adminmanagecourt.php?add_success=true");
        exit();
    } else {
        // Redirect to adminmanagecourt.php with error message if addition fails
        header("Location: adminmanagecourt.php?add_error=true");
        exit();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<title>Admin Add Court</title>
<link rel="icon" type="image/png" href="favicon.png">
<style>



body {
  margin: 0;
  font-family: "Lato", sans-serif;
}

.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}
 
.sidebar a.active {
  background-color: #04AA6D;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #555;
  color: white;
}

main {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}


/*  Table FEEDBACK CSS  */
table {
        border: 1px;
        width: 50%;
    }

    th, td {
        border: 1px solid #dddddd;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    .submitted {
        color: blue;
    }

/* Position the message at the bottom left */
.logged-in-message {
  position: fixed;
  bottom: 0;
  left: 0;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 12px;
}

input[type="submit"] {
    background-color: #45a049;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 250px;
    margin-right: 10px;
}

input[type="submit"]:hover {
    background-color: green;
    transform: scale(1.05);

}

form {
    width: 50%;
    margin: 0 auto;
    background-color: #f2f2f2;
  padding: 20px;
  border-radius: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"],
input[type="email"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}



</style>
</head>
<body>


 

<div class="sidebar">
  <a href="adminhome.php"><span class="material-symbols-outlined">
home
</span>  Dashboard</a>

  <a href="adminmanagebookings.php"><span class="material-symbols-outlined">
receipt_long
</span>  Manage Bookings</a>

  <a class="active" href="adminmanagecourt.php"><span class="material-symbols-outlined">
sports_soccer
</span>  Manage Courts</a>

  <a href="adminmanagefeedback.php"><span class="material-symbols-outlined">
list_alt
</span>  View Feedbacks</a>

  <a href="adminmanageprofile.php"><span class="material-symbols-outlined">
supervisor_account
</span>  Manage Profiles</a>

  <a href="logout.php"><span class="material-symbols-outlined">
logout
</span>  Logout</a>

<a href="home.php" style="margin-top: 195px;"><img src="CSLogoNoBackground.png" height="100" width="150" ></a>
  <!-- Display logged in username -->
    
  <?php
  // Check if the session variable is set
  if(isset($_SESSION['username'])) {
      $username = $_SESSION['username'];
      echo "<div class='logged-in-message'>Logged in as: $username</div>"; // Display a welcome message with the username
  } else {
      // If the session variable is not set, the user is not logged in
      // Redirect the user to the login page or display an error message
      header("Location: login.php"); // Redirect to the login page
      exit(); // Stop further execution of the script
  }
?>

</div>

<main>

        <br>
        <h1>Admin Add Court</h1><br><br>
       
       <form method="post">
        <label for="courtID">Court ID:</label>
        <input type="text" id="courtID" name="courtID" ><br><br>
        
        <label for="courtType">Court Type:</label>
        <input type="text" id="courtType" name="courtType" ><br><br>
        
        <label for="courtName">Court Name:</label>
        <input type="text" id="courtName" name="courtName" ><br><br>
        
        <label for="courtPrice">Court Price:</label>
        <input type="text" id="courtPrice" name="courtPrice" ><br><br>
        
        <input type="submit" name="submit" value="Add Court">
    </form>

    <?php
    // Display error message if court exists
    if(isset($_GET['add_error']) && $_GET['add_error'] == 'court_exists') {
        echo '<p style="color: red;">Error: Court with the same ID already exists. Please try again with a different ID.</p>';
    }
    ?>
        
    </main>



</body>
</html>
