<?php
// Include the database connection
require_once "dbconnect.php";

// Start the session
session_start();

// Check if the session variable is set
if (!isset($_SESSION['username'])) {
    // If the session variable is not set, the user is not logged in
    // Redirect the user to the login page or display an error message
    header("Location: login.php"); // Redirect to the login page
    exit(); // Stop further execution of the script
}

// Initialize availability feedback variable
$availabilityFeedback = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data from POST request
    $bookingDate = $_POST['bookingDate']; // Use the selected date from the form

    $bookingStartTime = $_POST['bookingStartTime'];
    $bookingDuration = $_POST['bookingDuration'];

    // Calculate booking end time
    $bookingEndTime = date("H:i", strtotime($bookingStartTime) + $bookingDuration * 3600);

    // Retrieve all court IDs along with their details
    $sql = "SELECT c.courtID, c.courtName, c.courtType, c.courtPrice FROM courtinfo c";
    $result = $conn->query($sql);
    $courts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courts[] = $row;
        }
    }

    // Initialize array to store available courts
    $availableCourts = [];

    // Check availability for each court
    foreach ($courts as $court) {
        $courtID = $court['courtID'];
        $sql = "SELECT * FROM booking 
                WHERE courtID = ? 
                AND ((bookingStartTime < ? AND bookingEndTime > ?) 
                OR (bookingStartTime >= ? AND bookingStartTime < ?) 
                OR (bookingEndTime > ? AND bookingEndTime <= ?))";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $courtID, $bookingStartTime, $bookingStartTime, $bookingStartTime, $bookingEndTime, $bookingEndTime, $bookingEndTime);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingBookings = $result->fetch_all(MYSQLI_ASSOC);
        
        // If no overlapping bookings, the court is available
        if (count($existingBookings) == 0) {
            $availableCourts[] = $court;
        }
    }

    // Display availability feedback
    if (!empty($availableCourts)) {
        $availabilityFeedback = "The following courts are available for the selected date and time range:";
    } else {
        $availabilityFeedback = "<span class='error'>There are no courts available for the selected date and time range.</span>";
    }
}
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Court Availability</title>
    
    <link rel="icon" type="image/png" href="favicon.png">




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
        width: 65%; /* Adjust the width as needed */
        margin: auto;
        background-color: whitesmoke;
        font-size: 17px;
        margin-top: 20px; /* Add margin to push it below the nav */
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

    .submitted {
        color: blue;
    }
    
     /*  Success error message  */
     .submitted {
    color: green;
     }

    .error {
     color: red;
    }

    .buttonContainer {
        margin-top: 200px;
        margin-right: 20px;
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1000; /* Ensure it's above other content */
        }


        /* My Bookings Button */
        .buttonContainer .myButton {
            display: inline-block;
            padding: 10px 20px;
            background-color: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .buttonContainer .myButton:hover {
            background-color: navy;
            transform: scale(1.05); /* Increase size by 5% */
            cursor: pointer; /* Change cursor to pointer on hover */
        }


/*Try error inout*/

/* Style for date input */
input[type="date"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
    font-size: 16px;
}

/* Style for time input */
input[type="time"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
    font-size: 16px;
}

/* Style for select input */
select {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
    font-size: 16px;
    appearance: none; /* Remove default dropdown arrow */
    background-image: url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>'); /* Add custom dropdown arrow */
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 15px;
}

/* Style for select dropdown arrow */
select::-ms-expand {
    display: none; /* Hide default arrow in IE/Edge */
}

input[type="number"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    width: 100%;
    font-size: 16px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: steelblue;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    display: block; /* Make the button a block-level element */
    margin: 0 auto;
}

/* Hover effect for the Book Court button */
input[type="submit"]:hover {
    background-color: navy;
    transform: scale(1.05); /* Increase size by 5% */
}

label{font-weight: bold;}


.success {
            color: green;
            font-weight: bold;
        }

/* Style for error message */
.error {
            color: red;
            font-weight: bold;
        }

body {
    background-image: url('bodywallpaper.png'); /* Set the background image */
    background-size: cover; /* Cover the entire background */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Do not repeat the background image */
}

.CourtListTable th,
        .CourtListTable td {
            border: 1px solid #dddddd;
            padding: 2px;
            text-align: center;
        }

        .CourtListTable th {
            background-color: cadetblue;
        }

        .CourtListTable td {
            background-color: ghostwhite;
        }
</style>



<!----------------------- Java script -------------------->
    <script>
        //Prevent book before current time
        window.onload = function() {
            // Get today's date
            var today = new Date().toISOString().split('T')[0];

            // Get the date input element
            var dateInput = document.getElementById('bookingDate');

            // Check if the selected date is today
            dateInput.addEventListener('change', function() {
                var selectedDate = dateInput.value;
                var currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
                if (selectedDate === today) {
                    // If the selected date is today, set the minimum start time to the current time
                    document.getElementById('bookingStartTime').min = currentTime;
                } else {
                    // Otherwise, there is no minimum time restriction
                    document.getElementById('bookingStartTime').min = '00:00';
                }
            });


        // Update start time to nearest hour
        document.getElementById("bookingStartTime").addEventListener('change', function() {
            var startTime = document.getElementById("bookingStartTime").value;
            var hours = parseInt(startTime.split(":")[0]);
            var minutes = parseInt(startTime.split(":")[1]);
            if (minutes !== 0) {
                // If minutes are not 00, set the start time to the next hour
                document.getElementById("bookingStartTime").value = (hours + 1) + ":00";
            }
        });
        }
    


        function calculateEndTime() {
            // Get the selected start time and booking duration
            var startTime = document.getElementById("bookingStartTime").value;
            var bookingDuration = parseInt(document.getElementById("bookingDuration").value);

            // Convert start time to hours and minutes
            var startHours = parseInt(startTime.split(":")[0]);

            // Calculate end time hours
            var endHours = (startHours + bookingDuration) % 24;

            // Format end time
            var endTime = (endHours < 10 ? "0" : "") + endHours + ":00";

            // Set the value of the end time input field
            document.getElementById("bookingEndTime").value = endTime;
        }



    </script>


  
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




<div class="buttonContainer">
        <a href="bookcourt.php" class="myButton">Book Court</a>
    </div>

 <main>

        <br>
        <h1>Search Available Courts</h1><br><br>



        
         <form class="pickdatetimeForm" action="" method="post" oninput="calculateEndTime()">
        <table>
             <tr>
                <td><label for="bookingDate">Date:</label><br>
                <span>(Maximum booking allowed is 3 months ahead)</span>
                </td>
                <td><input type="date" id="bookingDate" name="bookingDate" required min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+3 months')); ?>"></td>
            </tr>
            
            <tr>
                <td>
                <label for="bookingStartTime">Start Time :</label><br>
                <span>(24-hour format, e.g., 08:00, minutes must be 00)</span>
                </td>

                <td><input type="time" id="bookingStartTime" name="bookingStartTime" min="00:00" max="23:00"  required></td>
            </tr>

            <tr>
                <td><label for="bookingDuration">Booking Duration:</label><br>
                    <span>(Hours)</span>
                </td>
                <td><input type="number" id="bookingDuration" name="bookingDuration" min="1" max="8" value="1" required>
                </td>
            </tr>
            <tr>
                <td><label for="bookingEndTime">End Time:</label></td>
                <td><input type="time" id="bookingEndTime" name="bookingEndTime" min="08:00" max="23:00" step="3600" readonly></td>
            </tr>
            
            <tr>
                <td colspan=2><input type="submit" value="Search">  
            </tr>
        </table>
        <br><br>
        
    </form>

     <!-- Display availability feedback in a table -->
    <?php if (!empty($availableCourts)) : ?>
        <h2>Available Courts</h2><br>

        <!-- Display availability feedback -->
    <p class="<?php echo $availabilityFeedbackClass; ?> "> 
    <?php echo $availabilityFeedback; ?></p>
        <table class="CourtListTable">
            <tr>
                <th>Court ID</th>
                <th>Court Name</th>
                <th>Court Type</th>
                <th>Court Price</th>
            </tr>
            <?php foreach ($availableCourts as $court) : ?>
                <tr>
                    <td><?php echo $court['courtID']; ?></td>
                    <td><?php echo $court['courtName']; ?></td>
                    <td><?php echo $court['courtType']; ?></td>
                    <td><?php echo $court['courtPrice']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>

        <form action="bookcourt.php" method="get">
        <input type="submit" value="Book Now">
    </form>
    <?php endif; ?>
<br>
        



      
    </main>

<br><br>
</body>
</html>