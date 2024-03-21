<?php
// Include the database connection
require_once "dbconnect.php";
// Start the session
session_start();

// Function to delete feedback entry
function deleteFeedback($conn, $feedbackID) {
    // Use prepared statement to avoid SQL injection
    $sql = "DELETE FROM feedback WHERE feedbackID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $feedbackID);
    mysqli_stmt_execute($stmt);
    // Check if the deletion was successful
    if(mysqli_stmt_affected_rows($stmt) > 0) {
        return true;
    } else {
        return false;
    }
}

// Check if the deleteFeedback form is submitted
if(isset($_POST['deleteFeedback'])) {
    $feedbackID = $_POST['feedbackID'];
    // Call deleteFeedback function
    if(deleteFeedback($conn, $feedbackID)) {
        // Reload the page after deletion
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error deleting feedback.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<title>Admin Manage Feedback</title>
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

.ListTable{
    background-color: #f2f2f2;
  padding: 20px;
  border-radius: 10px;
  width: 100%; /* Set width to 100% */
    box-sizing: border-box; /* Include padding and border in the element's total width */
}

.delete-button {
  background-color: #ff4d4d; /* Red color */
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s, transform 0.3s;
}

.delete-button:hover {
  background-color: #cc0000; /* Darker red color on hover */
  transform: scale(1.05); /* Slightly bigger size on hover */
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

  <a  href="adminmanagecourt.php"><span class="material-symbols-outlined">
sports_soccer
</span>  Manage Courts</a>

  <a class="active" href="adminmanagefeedback.php"><span class="material-symbols-outlined">
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
  <h2>Admin Manage Feedback</h2>

  <div class="ListTable">
  <table>
            <tr>
                <th>Feedback ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Type</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            
            <?php
            // Fetch feedback data
            $sql = "SELECT * FROM feedback";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Output table row for each feedback record
                    echo "<tr>";
                    echo "<td>" . $row['feedbackID'] . "</td>";
                    echo "<td>" . $row['userUsername'] . "</td>";
                    echo "<td>" . $row['userFirstName'] . "</td>";
                    echo "<td>" . $row['userLastName'] . "</td>";
                    echo "<td>" . $row['userEmail'] . "</td>";
                    echo "<td>" . $row['userPhone'] . "</td>";
                    echo "<td>" . $row['feedbackType'] . "</td>";
                    echo "<td>" . $row['feedbackDescription'] . "</td>";
                    


                    echo "<td>";
                    // Form for deleting feedback
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='feedbackID' value='" . $row['feedbackID'] . "'>";
                    echo "<button type='submit' name='deleteFeedback' class='delete-button'>Delete</button>";
                    echo "</form>";
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No feedback available</td></tr>";
            }
            ?>
        </table>

</div>
        <!-- End of Feedback Table -->
    </main>

<?php
// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
