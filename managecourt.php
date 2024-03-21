<?php
// Include the database connection
require_once "dbconnect.php";

function getAllCourts()
{
    global $conn;
    $query = "SELECT courtID, courtType, courtName FROM courtinfo";
    $result = mysqli_query($conn, $query);

    $courts = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $courts[] = $row;
    }

    return $courts;
}

// Fetch all courts
$courts = getAllCourts();


// Function to update court data
function updateCourt($courtData)
{
    global $conn;
    $courtID = $courtData['courtID'];
    $courtType = $courtData['courtType'];
    $courtName = $courtData['courtName'];
    $courtPrice = $courtData['courtPrice'];

    // Update the court data
    $query = "UPDATE courtinfo SET courtType='$courtType', courtName='$courtName', courtPrice='$courtPrice' WHERE courtID='$courtID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p>Court data updated successfully.</p>";
    } else {
        echo "<p>Error updating court data: " . mysqli_error($conn) . "</p>";
    }
}

// Function to delete a court
function deleteCourt($courtID)
{
    global $conn;
    $query = "DELETE FROM courtinfo WHERE courtID='$courtID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p>Court deleted successfully.</p>";
    } else {
        echo "<p>Error deleting court: " . mysqli_error($conn) . "</p>";
    }
}

// Function to add a new court
function addCourt($courtData)
{
    global $conn;
    $courtID = $courtData['courtID'];
    $courtType = $courtData['courtType'];
    $courtName = $courtData['courtName'];
    $courtPrice = $courtData['courtPrice'];

    // Insert the new court
    $query = "INSERT INTO courtinfo (courtID, courtType, courtName, courtPrice) VALUES ('$courtID','$courtType', '$courtName', '$courtPrice')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p>New court added successfully.</p>";
    } else {
        echo "<p>Error adding new court: " . mysqli_error($conn) . "</p>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Add Court</title>
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
        background-color:cadetblue ;
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
    .nav-links ul li a{
        color:white;
        text-decoration: none;
        font-size: 15px;
        font-family:lato;
    }
    .nav-links ul li:hover::after{
        width: 100%;
        
    }

/*----------------End NAV Section CSS----------------------*/



    main {
        width: 50%; /* Adjust the width as needed */
        margin: auto;
        background-color: whitesmoke;
        font-size: 17px;
        margin-top: 20px; /* Add margin to push it below the nav */
    }
</style>


  
</head>




<body>

        <!-- Start webpage header html-->


     <section class="sub-header">
        <nav>
            <a href="adminhome.php"><img src="CSLogoNoBackground.png" height="100" width="280" ></a>
            <div class="nav-links" id="navLinks">
                <ul>
                    <li><a href="adminhome.php">Home</a></li>
                    <li><a href="adminbooking.php">Court Bookings</a></li>
                    <li><a href="adminmap.php">Map</a></li>
                    <li><a href="adminprofile.php">Manage Profiles</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </section>
    <!-- End webpage header html-->





    <main>
    <br>
    <h1>Admin Manage Court</h1><br>

    <!-- Court selection dropdown -->
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label>Select Court:</label>
        <select name="selected_court">
            <option value="">Select...</option>
            <?php foreach ($courts as $court) : ?>
                <option value="<?php echo $court['courtID']; ?>">
                    <?php echo $court['courtID'] . " - " . $court['courtName']; ?>
                </option>
            <?php endforeach; ?>
            <option value="add_new_court">Add New Court</option>
        </select>
        <input type="submit" name="submit" value="Select">
    </form>

    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
        $selectedCourt = $_POST['selected_court'];

        // Check if "Add New Court" option is selected
        if ($selectedCourt === "add_new_court") {
            // Display form for adding new court
            echo "<br><h2>Add New Court Form</h2><br>";
            echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
            echo "<label>Court ID:</label>";
            echo "<input type='text' name='courtID'><br>";
            echo "<label>Court Type:</label>";
            echo "<input type='text' name='courtType'><br>";
            echo "<label>Court Name:</label>";
            echo "<input type='text' name='courtName'><br>";
            echo "<label>Court Price:</label>";
            echo "<input type='text' name='courtPrice'><br>";
            echo "<input type='submit' name='add_court' value='Add'>";
            echo "</form>";
        } else {
            // Fetch court data from the database based on selected courtID
            $query = "SELECT * FROM courtinfo WHERE courtID = '$selectedCourt'";
            $result = mysqli_query($conn, $query);
            $courtData = mysqli_fetch_assoc($result);

            // Display court data in a form
            if ($courtData) {
                echo "<br><h2>Court Details</h2><br>";
                echo "<form method='post' action=''>";
                foreach ($courtData as $key => $value) {
                    // Output the label and input field for each court data field
                    echo "<label>$key:</label>";
                    echo "<input type='text' name='$key' value='$value'><br>";
                }
                // Add buttons for updating and deleting court data
                echo "<input type='submit' name='update' value='Update'>";
                echo "<input type='submit' name='delete' value='Delete'>";
                echo "</form>";
            } else {
                echo "<p>Court not found.</p>";
            }
        }
    }

    // Check if update button is clicked
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
        updateCourt($_POST); // Call function to update court data
    }

    // Check if delete button is clicked
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete"])) {
        $selectedCourt = $_POST['courtID'];
        deleteCourt($selectedCourt); // Call function to delete court
    }

    // Check if add button is clicked
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_court"])) {
        addCourt($_POST); // Call function to add court
    }
    ?>
</main>
</body>
</html>
