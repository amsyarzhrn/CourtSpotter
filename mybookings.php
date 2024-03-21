<?php
// Include the database connection
require_once "dbconnect.php";

// Start the session
session_start();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>My Court Bookings</title>




<style>
   
    
  
     /*----------------Start NAV Section CSS----------------------*/

    *{
    margin:0;
    padding:0;
    font-family: 'Poppins', sans-serif;
    }

    .sub-header{
        height: 110px;
        width: 100%;
        background-color:steelblue ;
        image-resolution: from-image;
        background-position:center;
        background-size: cover;
        position: relative;
    }
    nav{
        display: flex;
        padding: 2% 3% 3% 3%;
        justify-content: space-between;
        align-items: center;
    }
    nav img{
        width: 130px;
        margin-top: -20px;
    }

    nav img:hover {
    width: 140px; /* Increase width on hover */
    }


    .nav-links{
        padding-top: 2px;
        flex:1;
        text-align: right;
    }
    .nav-links ul li{
        list-style: none;
        display: inline-block;
        padding: 8px 20px;
        position:relative;
    }
    .nav-links ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    font-family: lato;
    transition: font-size 0.3s; /* Add transition for smooth effect */
    }

    .nav-links ul li.active a {
    color: black;
    font-weight: bold;
    font-size: 18px; /* Maintain the same font size as hover state */
}

    .nav-links ul li:hover a {
    color: black;
    font-weight: bold;
    font-size: 18px; /* Increase font size on hover */
    }
    .nav-links ul li:hover::after{
        width: 100%;    
    }

    


/*----------------End NAV Section CSS----------------------*/



    main {
        width: 70%; /* Adjust the width as needed */
        margin: auto;
        background-color: whitesmoke;
        font-size: 17px;
        margin-top: 20px; /* Add margin to push it below the nav */
    }


    /* Styles for table */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: skyblue;
            text-align: center;
        }
        th {
            background-color: steelblue;
        }

        input[type=submit] {
            background-color: red;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type=submit]:hover {
            background-color: darkred;
        }


</style>


  
</head>




<body>

        <!-- Start webpage header html-->

   <section class="sub-header">

        <nav>

            <a href="home.php"><img src="CSLogoNoBackground.png" height="100" width="280" ></a>
            <div class="nav-links" id="navLinks">
                <ul>
                    <li><a href="home.php"><span class="material-symbols-outlined">
                    home
                    </span> Home</a></li>
                    <li class="active"><a href="bookcourt.php"><span class="material-symbols-outlined">
                    edit_calendar
                    </span> Book Court</a></li>
                    <li><a href="map.php"><span class="material-symbols-outlined">
                    space_dashboard
                    </span> Map</a></li>
                    <li><a href="about.php"><span class="material-symbols-outlined">
                    help
                    </span> About</a></li>
                    <li><a href="profile.php">
                    <span class="material-symbols-outlined">
                    manage_accounts
                    </span> Profile</a></li>
                    <li><a href="logout.php"><span class="material-symbols-outlined">
                    logout
                    </span> Logout</a></li>
                </ul>
 <!-- Display logged in username -->
        <?php
       // Check if the session variable is set
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<span style='font-size: 11px;font-weight: bold;'>Logged in as: $username";// Display a welcome message with the username
        } else {
            // If the session variable is not set, the user is not logged in
            // Redirect the user to the login page or display an error message
            header("Location: login.php"); // Redirect to the login page
            exit(); // Stop further execution of the script
        }
        ?>
            </div>
        </nav>
       
    </section>
<!-- End webpage header html-->



    

    <main>

        <br>
        <h1 style="margin-left: 50px;">My Bookings</h1><br><br>


          <form action="userdelete_bookings.php" method="post">
            <table class="mybookings">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Court Type</th>
                        <th>Court Name</th>
                        <th>Court Price(/hour)</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration(hour)</th>
                        <th>Total Payment</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch bookings for the logged-in user from the database
                    $username = $_SESSION['username'];
                    $sql = "SELECT b.bookingID, c.courtType, c.courtName, c.courtPrice, b.bookingDate, b.bookingStartTime, b.bookingEndTime, b.bookingDuration 
                    FROM booking b 
                    INNER JOIN courtinfo c ON b.courtID = c.courtID
                    WHERE b.userUsername = ?
                    ORDER BY b.bookingDate ASC, b.bookingStartTime ASC";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are no bookings
                    if ($result->num_rows === 0) {
                        echo "<tr><td colspan='9'>No recorded bookings, <a href='bookcourt.php'>Let's Book Now!</a></td></tr>";
                    } else {
                        // Display bookings in table rows
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["bookingID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["courtType"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["courtName"]) . "</td>";
                            echo "<td>RM" . htmlspecialchars($row["courtPrice"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["bookingDate"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["bookingStartTime"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["bookingEndTime"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["bookingDuration"]) . "</td>";
                            echo "<td>RM" . htmlspecialchars($row["bookingDuration"] * $row["courtPrice"]) . "</td>";

                            echo "<td><input type='radio' name='booking_ids[]' value='" . htmlspecialchars($row["bookingID"]) . "'></td>";
                            echo "</tr>";
                        }
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
            <input type='submit' name='delete' value='Delete Booking'>
        </form>

        <p style="margin-top: 20px; font-size: 16px; ">Dear valued customers, please show your booking ID at the counter and make payment before playing. Thank You!</p><br><br>
    </main>
</body>
</html>
