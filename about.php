<?php
// Include the database connection
require_once "dbconnect.php";
// Start the session
session_start();

// Set the timezone to Kuala Lumpur
date_default_timezone_set('Asia/Kuala_Lumpur');

// Function to generate feedback ID
function generateFeedbackID($username) {
    $randomSuffix = bin2hex(random_bytes(4)); // Generate a random hexadecimal string (8 characters)
    $timestamp_kl = time(); // Get current timestamp adjusted to Kuala Lumpur time
    return $username . '_' . $timestamp_kl;
}

// Check if the user is logged in
if(isset($_SESSION['username'])) {
    // Retrieve user information from the user table
    $username = $_SESSION['username'];
    $sql = "SELECT userFirstName, userLastName, userEmail, userPhone FROM user WHERE userUsername = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the user exists in the database
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userFirstname = $row['userFirstName'];
        $userLastname = $row['userLastName'];
        $userEmail = $row['userEmail'];
        $userPhone = $row['userPhone'];
    } else {
        echo "Error: User not found in the database.";
    }
    $stmt->close();
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

// Initialize variables for messages
$successMessage = $errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $feedbackID = generateFeedbackID($username);
    $feedbackType = $_POST['feedbackType'];
    $feedbackDescription = $_POST['feedbackDescription'];
    $feedbackStatus = "Submitted"; // Set feedback status to "Submitted"

    // Prepare and execute SQL statement to insert feedback into the database
    $sql = "INSERT INTO feedback (feedbackID, userUsername, userFirstName, userLastName, userEmail, userPhone, feedbackType, feedbackDescription, feedbackStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $feedbackID, $username, $userFirstname, $userLastname, $userEmail, $userPhone, $feedbackType, $feedbackDescription, $feedbackStatus);
    
    // Check if the SQL statement was executed successfully
    if ($stmt->execute()) {
        $successMessage = "Feedback submitted successfully!";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>About Us</title>
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
        width: 100%; /* Adjust the width as needed */
        margin: auto;
        background-color: whitesmoke;
        font-size: 17px;
        margin-top: 20px; /* Add margin to push it below the nav */
        background-image: url('bodywallpaper.png'); /* Set the background image */
    background-size: cover; /* Cover the entire background */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Do not repeat the background image */
    }

    body {
    background-image: url('bodywallpaper.png'); /* Set the background image */
    background-size: cover; /* Cover the entire background */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Do not repeat the background image */
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
    text-align: left;
}

input[type="text"],
input[type="password"],
input[type="email"],
select {
    width: 50%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: cadetblue;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
    margin-right: 10px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    .googleMap{
        width: 600px;
        margin: 0 auto;
        
    }

    .FeedbackForm{
        margin-left: 50px;
    }



/*Business Details*/
.businessDetails {

    width: 50%; /* Adjust the width as needed */
    margin: 20px auto; /* Center the section horizontally with some margin */
    background-color: #f2f2f2;
    padding: 20px;
   
}

.businessDetails h2 {
    margin-bottom: 10px; /* Add some bottom margin to separate heading from details */
    padding-left: 80px;
}

.businessDetails p {
    margin-bottom: 8px; /* Add some bottom margin to separate details */
    padding-left: 80px;
}

.googleMap{
    border: 2px solid;
    border-radius: 10px;

}
form {
    border: 1px solid;
    padding-left: 80px;
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
                    <li><a href="bookcourt.php"><span class="material-symbols-outlined">
                    edit_calendar
                    </span> Book Court</a></li>
                    <li><a href="map.php"><span class="material-symbols-outlined">
                    space_dashboard
                    </span> Map</a></li>
                    <li class="active"><a href="about.php"><span class="material-symbols-outlined">
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
        <h1 style="margin-left: 100px;">About Us</h1>



        <div class="googleMap">

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1527.5849791111127!2d101.76074772065633!3d3.0340874164019516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc34d2e0e3bbf7%3A0x9a5069148f594819!2sSports%20station%20futsal!5e0!3m2!1sen!2smy!4v1708826697632!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            <br><br>


        </div>



         <div class="businessDetails">
        <h2>Business Details</h2>
        <p>Phone Number: +0390812704</p>
        <p>Email: SportFStation@gmail.com.com</p>
        </div>
        

        <div class="FeedbackForm">
        

        <!-- Feedback Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Send some inquiries</h2><br>
        <p>We'll get back to you via email</p>
       
        <br><br>
            <!-- Hidden fields to store user information -->
            <input type="hidden" name="userUsername" value="<?php echo $username; ?>">
            <input type="hidden" name="userFirstName" value="<?php echo $userFirstname; ?>">
            <input type="hidden" name="userLastName" value="<?php echo $userLastname; ?>">
            <input type="hidden" name="userEmail" value="<?php echo $userEmail; ?>">
            <input type="hidden" name="userPhone" value="<?php echo $userPhone; ?>">
            
            <!-- FeedbackID field (auto-generated) -->
            <input type="hidden" name="feedbackID" value="<?php echo generateFeedbackID($username); ?>">

            <label for="feedbackType">Feedback Type:</label>
            <select id="feedbackType" name="feedbackType">
                <option value="Inquiries">Inquiries</option>
                <option value="Complaint">Complaint</option>
                <option value="Improvement Recommendation">Improvement Recommendation</option>
            </select>
            
            <br><br>

            <label for="feedbackDescription">Feedback Description:</label>
            <textarea id="feedbackDescription" name="feedbackDescription" rows="4" cols="50" required></textarea>
            
            <br><br>
            
            <input type="submit" value="Submit Feedback">
            <br><br>

                 <!-- Display Success and Error Messages -->
        <?php if(!empty($successMessage)): ?>
            <p style="color: green;"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        
        <?php if(!empty($errorMessage)): ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        </form>
    </div>
    </main>
    <br><br>

</body>
</html>
