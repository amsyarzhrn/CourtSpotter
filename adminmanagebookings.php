<?php
// Include the database connection
require_once "dbconnect.php";
// Start the session
session_start();

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<title>Admin Manage Bookings</title>
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

input[type="submit"] {
    background-color: #ff4d4d;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
    margin-right: 10px;
}

input[type="submit"]:hover {
    background-color: #cc0000; /* Darker red color on hover */
  transform: scale(1.05); /* Slightly bigger size on hover */
}

.ListTable{
    background-color: #f2f2f2;
  padding: 20px;
  border-radius: 10px;
  width: 150%; /* Set width to 100% */
    box-sizing: border-box; /* Include padding and border in the element's total width */
}
</style>
</head>
<body>


 

<div class="sidebar">
  <a href="adminhome.php"><span class="material-symbols-outlined">
home
</span>  Dashboard</a>

  <a class="active" href="adminmanagebookings.php"><span class="material-symbols-outlined">
receipt_long
</span>  Manage Bookings</a>

  <a href="adminmanagecourt.php"><span class="material-symbols-outlined">
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

<a href="home.php" style="margin-top: 180px;"><img src="CSLogoNoBackground.png" height="100" width="150" ></a>
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
    <h1>Admin Manage Bookings</h1>
    <div class="ListTable">
   <form action="delete_booking.php" method="post">
    <table>
        <thead>
            <tr>
                <th>Select</th> <!-- Moved to the left -->
                <th>Booking ID</th>
                <th>Court ID</th>
                <th>Court Type</th>
                <th>Court Name</th>
                <th>Court Price</th>
                <th>Book Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
                <th>Total Payment</th>
                <th>First Name</th> <!-- Moved to the right -->
                <th>Last Name</th> <!-- Moved to the right -->
                <th>Phone</th> <!-- Moved to the right -->
                <th>Email</th> <!-- Moved to the right -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch bookings and court information
            $sql = "SELECT b.bookingID, u.userFirstName, u.userLastName, u.userPhone, u.userEmail, b.courtID, b.bookingDate, b.bookingStartTime, b.bookingEndTime, b.bookingDuration, c.courtType, c.courtName, c.courtPrice 
                    FROM booking b 
                    INNER JOIN courtinfo c ON b.courtID = c.courtID 
                    INNER JOIN user u ON b.userUsername = u.userUsername
                    ORDER BY b.bookingDate ASC, b.bookingStartTime ASC"; // Modified SQL query
            $result = $conn->query($sql);
            
            // Check if there are no bookings recorded
            if ($result->num_rows === 0) {
                echo "<tr><td colspan='15'>No bookings recorded</td></tr>";
            } else {
                // Display bookings and court information in table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='booking_ids[]' value='" . htmlspecialchars($row["bookingID"]) . "'></td>"; // Moved to the left
                    echo "<td>" . htmlspecialchars($row["bookingID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["courtID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["courtType"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["courtName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["courtPrice"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingDate"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingStartTime"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingEndTime"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingDuration"]) . "</td>";
                    echo "<td>RM" . htmlspecialchars($row["bookingDuration"] * $row["courtPrice"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userFirstName"]) . "</td>"; // Moved to the right
                    echo "<td>" . htmlspecialchars($row["userLastName"]) . "</td>"; // Moved to the right
                    echo "<td>" . htmlspecialchars($row["userPhone"]) . "</td>"; // Moved to the right
                    echo "<td>" . htmlspecialchars($row["userEmail"]) . "</td>"; // Moved to the right
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <br><input type='submit' name='delete' value='Delete Selected Bookings'>
</form>

</div>
</main>




</body>
</html>
