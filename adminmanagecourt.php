<?php
// Include the database connection
require_once "dbconnect.php";
// Start the session
session_start();


// Fetch all data from the courtinfo table
$sql = "SELECT * FROM courtinfo";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<title>Admin Manage Court</title>
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
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        padding: 8px;


    }

    th {
        background-color: cadetblue;


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

input[type="submit"][name="edit"]{
    background-color: blue;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
    margin-right: 10px;
}

input[type="submit"][name="edit"]:hover {
    background-color: darkblue;
    transform: scale(1.05); /* Slightly bigger size on hover */
}

input[type="submit"][name="delete"]{
    background-color: #ff4d4d;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
    margin-right: 10px;
}

input[type="submit"][name="delete"]:hover {
    background-color: #cc0000;
    transform: scale(1.05); /* Slightly bigger size on hover */
}


input[type="submit"][name="add"]{
    background-color: #45a049;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
    margin-right: 10px;
}

input[type="submit"][name="add"]:hover {
    background-color: green;
    transform: scale(1.05); /* Slightly bigger size on hover */
}

.ListTable{
    background-color: #f2f2f2;
  padding: 20px;
  border-radius: 10px;
  
    box-sizing: border-box; /* Include padding and border in the element's total width */
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
        <h1>Admin Manage Courts</h1><br>
       
       <div class="ListTable">
       <form action="admindeletecourt.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Court ID</th>
                    <th>Court Type</th>
                    <th>Court Name</th>
                    <th>Court Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include the database connection
                require_once "dbconnect.php";

                // Fetch all data from the courtinfo table
                $sql = "SELECT * FROM courtinfo";
                $result = $conn->query($sql);

                // Display court data in table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='radio' name='court_ids[]' value='" . $row['courtID'] . "'></td>";
                    echo "<td>" . $row['courtID'] . "</td>";
                    echo "<td>" . $row['courtType'] . "</td>";
                    echo "<td>" . $row['courtName'] . "</td>";
                    echo "<td>" . $row['courtPrice'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <input type="submit" name="edit" value="Edit Selected Court">
        <input type="submit" name="delete" value="Delete Selected Court">
        <input type="submit" name="add" value="Add New Court">
    </form>
        
    </div>
    </main>



</body>
</html>
