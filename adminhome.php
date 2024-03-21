<?php
// Include the database connection
require_once "dbconnect.php";
// Start the session
session_start();

date_default_timezone_set('Asia/Kuala_Lumpur');

// Query to get the count of courts
$sqlCountCourts = "SELECT COUNT(*) AS totalCourts FROM courtinfo";
$resultCountCourts = $conn->query($sqlCountCourts);
$countCourts = $resultCountCourts->fetch_assoc()["totalCourts"];

// Query to count the number of feedback entries
$sql = "SELECT COUNT(*) AS totalFeedback FROM feedback";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalFeedback = $row['totalFeedback'];

// Execute SQL query to count total bookings
$sql = "SELECT COUNT(*) AS totalBookings FROM booking";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalBookings = $row["totalBookings"];
} else {
    $totalBookings = 0;
}
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<title>Admin Home</title>
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
        background-color: #f2f2f2;
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



/*Dashboard CSS*/
.dashboard .dash-content{
    padding-top: 50px;
    margin-left: 500px;

}


.dash-content .boxes{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 10px;

}

.dash-content .boxes .box{
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius: 12px;
    width: calc(50% / 3 - 15px);
    padding: 15px 20px;
    background-color: var(--box1-color);
    transition: var(--tran-05);
}



.boxes .box.box1{
    margin-left: 100px;

}

.boxes .box.box2{
    background-color: var(--box2-color);

}
.boxes .box.box3{
    background-color: var(--box3-color);
    margin-right: 150px;
}
.dash-content .activity .activity-data{
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}



:root{
    /* ===== Colors ===== */
    
    --box1-color: cadetblue;
    --box2-color: cadetblue;
    --box3-color: cadetblue;
    
   
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

  a {
    color: inherit; /* Use the default text color */
    text-decoration: none; /* Remove underline */
}

.texttitle{
  font-weight: Bold;
}


/*Bagi ada popup skit div*/
.Today_booking{ 
  background-color: #f2f2f2;
  padding: 20px;
  border-radius: 10px;
}

.feedbackCount{
  font-weight: bold;
  margin-left: 40px;
  font-size: 25px;
}

.bookingCount{
  font-weight: bold;
  margin-left: 40px;
  font-size: 25px;
}

.courtCount{
  font-weight: bold;
  margin-left: 40px;
  font-size: 25px;
}
</style>
</head>
<body>
 

 

<div class="sidebar">
  <a class="active"href="adminhome.php"><span class="material-symbols-outlined">
home
</span>  Dashboard</a>

  <a href="adminmanagebookings.php"><span class="material-symbols-outlined">
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
        <h1>Admin Dashboard</h1><br><br>

        <div class="dash-content">
           
                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-thumbs-up"></i>
                        <a href="adminmanagecourt.php">
                        <span class="texttitle">Total Courts :</span><br><br>
                        <span class="courtCount"><?php echo $countCourts; ?></span> 
                      </a>
                    </div>

                    <div class="box box2">
                      <a href="adminmanagefeedback.php">
                        <i class="uil uil-comments"></i>
                        <span class="texttitle">Total Feedback : </span><br><br>
                        <span class="feedbackCount"><?php echo $totalFeedback; ?></span>
                      </a>
                    </div>

                    <div class="box box3">
                      <a href="adminmanagebookings.php">
                        <i class="uil uil-share"></i>
                        <span class="texttitle">Total Bookings :</span><br><br>
                        <span class="bookingCount"><?php echo $totalBookings; ?></span>
                      </a>
                    </div>
                </div>

                </div>
            </div>




     <br><br>
     <h2>Today's Booking</h2><br>
     <div class="Today_booking">
      <a href="adminmanagebookings.php">
     
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Book Date</th>
                <th>Book Start Time</th>
                <th>Book End Time</th>
                <th>Booking Duration</th>
                <th>Court ID</th>
                <th>Court Name</th>
                <th>Customer Name</th>
                <th>Customer Phone</th>
                <th>Customer Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch today's bookings, court, and user information
            $today = date("Y-m-d"); // Get today's date
            $sql = "SELECT b.bookingID, b.bookingDate, b.bookingStartTime, b.bookingEndTime, b.bookingDuration, b.courtID, c.courtName, u.userFirstName, u.userPhone, u.userEmail 
                    FROM booking b 
                    INNER JOIN courtinfo c ON b.courtID = c.courtID 
                    INNER JOIN user u ON b.userUsername = u.userUsername 
                    WHERE b.bookingDate = '$today'
                    ORDER BY b.bookingStartTime ASC";
            $result = $conn->query($sql);
            
            // Check if there are bookings for today
            if ($result->num_rows === 0) {
                echo "<tr><td colspan='10'>No bookings recorded for today</td></tr>";
            } else {
                // Display bookings, court, and user information in table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["bookingID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingDate"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingStartTime"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingEndTime"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["bookingDuration"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["courtID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["courtName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userFirstName"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userPhone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["userEmail"]) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

       
        
    </main>



</body>
</html>
