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

// Define variables to store messages
$updateMessage = ""; // Initialize the message variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process the form submission to save changes

    // Example: Update user information in the database
    $newFirstName = $_POST['userFirstName'];
    $newLastName = $_POST['userLastName'];
    $newGender = $_POST['userGender'];
    $newPhone = $_POST['userPhone'];
    $newEmail = $_POST['userEmail'];
    $newAddress = $_POST['userAddress'];
    $username = $_SESSION['username'];

    // Construct the SQL query
    $sql = "UPDATE user SET userFirstName = '$newFirstName', userLastName = '$newLastName', userGender = '$newGender', userPhone = '$newPhone', userEmail= '$newEmail', userAddress = '$newAddress' WHERE userUsername = '$username'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Database update successful
        $updateMessage = "<span style='color: green; font-weight: bold;'>Profile updated successfully, <br>your information has been updated! </span>";
    } else {
        // Database update failed
        $updateMessage = "<span style='color: red;'>Error updating profile: " . $conn->error . "</span>";
    }

    }

// Fetch user information from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE userUsername = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, display profile form
    $row = $result->fetch_assoc();
} else {
    // User not found, handle the error
    // You may display an error message or redirect the user
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Profile</title>





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
        margin-top: 50px;
        width: 60%; /* Adjust the width as needed */
        margin: auto;
        background-color: steelblue;
        font-size: 17px;
        margin-top: 20px; /* Add margin to push it below the nav */
        border-radius: 20px;
    }




    form {
    width: 50%;
    margin: 0 auto;
    background-color: lightblue;
  padding: 20px;
  border-radius: 10px;
  padding-left: 50;
  padding-left: 50px;
}

label {
    display: block;
    margin-top: 5px;
}

input[type="text"],
input[type="password"],
input[type="email"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 2px;
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
    margin-left: 200px;
    margin-right: 10px;
}

input[type="submit"]:hover {
    background-color: #45a049;;
}

body {
    background-image: url('loginBackground.png'); /* Set the background image */
    background-size: cover; /* Cover the entire background */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Do not repeat the background image */
}
    </style>
    </head>

    <body>
        <!-- Start webpage header html -->
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
                    <li><a href="about.php"><span class="material-symbols-outlined">
                    help
                    </span> About</a></li>
                    <li class="active"><a href="profile.php">
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
        <h1 style="margin-left: 50px;">Your Profile</h1><br> <br>
        <!-- Display update message -->
        
        
        <!-- Profile Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

            <?php echo $updateMessage; ?><br><br>
            <label for="userUsername">Username:</label><br>
            <input type="text" id="userUsername" name="userUsername" value="<?php echo $row['userUsername']; ?>" readonly><br>

            <label for="userFirstName">First Name:</label><br>
            <input type="text" id="userFirstName" name="userFirstName" value="<?php echo $row['userFirstName']; ?>"><br>

            <label for="userLastName">Last Name:</label><br>
            <input type="text" id="userLastName" name="userLastName" value="<?php echo $row['userLastName']; ?>"><br>

            <label for="userNRIC">NRIC:</label><br>
            <input type="text" id="userNRIC" name="userNRIC" value="<?php echo $row['userNRIC']; ?>" readonly><br>

            <label for="userGender">Gender:</label><br>
            <select id="userGender" name="userGender">
                <option value="Male" <?php if ($row['userGender'] === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($row['userGender'] === 'Female') echo 'selected'; ?>>Female</option>
            </select><br>

            <label for="userPhone">Phone:</label><br>
            <input type="text" id="userPhone" name="userPhone" value="<?php echo $row['userPhone']; ?>"><br>

            <label for="userEmail">Email:</label><br>
            <input type="email" id="userEmail" name="userEmail" value="<?php echo $row['userEmail']; ?>"><br>

            <label for="userAddress">Address:</label><br>
            <textarea id="userAddress" name="userAddress" rows="2" cols="65"><?php echo $row['userAddress']; ?></textarea><br>

            <script>
            //to resize textarea as userType
            function autoResize(textarea) {
              textarea.style.height = 'auto';
              textarea.style.height = textarea.scrollHeight + 'px';
            }
            </script>

            

           
           
           

            <!-- Button -->
            <input type="submit" value="Save">
        </form>
        <br><br><br><br>
    </main>
<br><br>
            <br>    <br>
</body>
</html>
