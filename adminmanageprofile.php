<?php
// Include the database connection
require_once "dbconnect.php";
// Start the session
session_start();

// Function to update user data
function updateUser($userData)
{
    global $conn;
    $username = $userData['userUsername'];
    $firstName = $userData['userFirstName'];
    $lastName = $userData['userLastName'];
    $nric = $userData['userNRIC'];
    $password = $userData['userPassword'];
    $gender = $userData['userGender'];
    $phone = $userData['userPhone'];
    $email = $userData['userEmail'];
    $address = $userData['userAddress'];

    // Check if the username or NRIC already exists in the database
    $checkQuery = "SELECT * FROM user WHERE (userUsername='$username' OR userNRIC='$nric') AND userUsername != '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<p>Username or NRIC already exists. Please try again with a different username and NRIC.</p>";
        return; // Stop execution if duplicate found
    }

    // Update the user data
    $query = "UPDATE user SET userFirstName='$firstName', userLastName='$lastName', userNRIC='$nric', userPassword='$password', userGender='$gender', userPhone='$phone', userEmail='$email', userAddress='$address' WHERE userUsername='$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p>User data updated successfully.</p>";
    } else {
        echo "<p>Error updating user data: " . mysqli_error($conn) . "</p>";
    }
}





// Function to add a new user
function addUser($userData)
{
    global $conn;
    $username = $userData['userUsername'];
    $firstName = $userData['userFirstName'];
    $lastName = $userData['userLastName'];
    $nric = $userData['userNRIC'];
    $password = $userData['userPassword'];
    $gender = $userData['userGender'];
    $phone = $userData['userPhone'];
    $email = $userData['userEmail'];
    $address = $userData['userAddress'];

    // Check if the username or NRIC already exists in the database
    $checkQuery = "SELECT * FROM user WHERE userUsername='$username' OR userNRIC='$nric'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<p>Username or NRIC already exists. Please try again with a different username and NRIC.</p>";
        return; // Stop execution if duplicate found
    }

    // Insert the new user
    $query = "INSERT INTO user (userUsername, userFirstName, userLastName, userNRIC, userPassword, userGender, userPhone, userEmail, userAddress) VALUES ('$username', '$firstName', '$lastName', '$nric', '$password', '$gender', '$phone', '$email', '$address')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p>New user added successfully.</p>";
    } else {
        echo "<p>Error adding new user: " . mysqli_error($conn) . "</p>";
    }
}


// Function to delete a user
function deleteUser($username)
{
    global $conn;
    $query = "DELETE FROM user WHERE userUsername='$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p>User deleted successfully.</p>";
    } else {
        echo "<p>Error deleting user: " . mysqli_error($conn) . "</p>";
    }
}



// Function to fetch all users
function getAllUsers()
{
    global $conn;
    $query = "SELECT userUsername, userFirstName, userLastName FROM user";
    $result = mysqli_query($conn, $query);

    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}

// Fetch all users
$users = getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<title>Admin Manage Profile</title>
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


/*Form CSS*/

        /* Form styling */
        .form-container {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input[type=text],
        .form-container input[type=password],
        .form-container input[type=email],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container input[type=submit] {
            background-color: cadetblue;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .form-container input[type=submit]:hover {
            background-color: #45a049;
        }



/*TRY ERROR*/
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

input[type="submit"][name="update"] {
    background-color: blue;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
    margin-right: 10px;
}

input[type="submit"][name="update"]:hover {
    background-color: darkblue;
    transform: scale(1.05);
}

input[type="submit"][name="delete"] {
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
    transform: scale(1.05);
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

  <a href="adminmanagecourt.php"><span class="material-symbols-outlined">
sports_soccer
</span>  Manage Courts</a>

  <a href="adminmanagefeedback.php"><span class="material-symbols-outlined">
list_alt
</span>  View Feedbacks</a>

  <a class="active" href="adminmanageprofile.php"><span class="material-symbols-outlined">
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
    <h1>Admin Manage Profile</h1><br>

    <!-- User selection dropdown -->
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
         <div class="form-container">
        <label>Select User:</label>
        <select name="selected_user">
            <option value="">Select...</option>
            <?php foreach ($users as $user) : ?>
                <option value="<?php echo $user['userUsername']; ?>">
                    <?php echo $user['userUsername'] . " - " . $user['userFirstName'] . " " . $user['userLastName']; ?>
                </option>
            <?php endforeach; ?>
            <option value="add_new_user">Add New User</option>
        </select>
        <input type="submit" name="submit" value="Select">
    </div>
    </form>

    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
        $selectedUser = $_POST['selected_user'];

        // Check if "Add New User" option is selected
        if ($selectedUser === "add_new_user") {
            // Display form for adding new user
            echo "<br><h2>Add New User Form</h2><br>";
            echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
            echo "<label>Username:</label>";
            echo "<input type='text' name='userUsername'><br>";
            echo "<label>First Name:</label>";
            echo "<input type='text' name='userFirstName'><br>";
            echo "<label>Last Name:</label>";
            echo "<input type='text' name='userLastName'><br>";
            echo "<label>NRIC:</label>";
            echo "<input type='text' name='userNRIC'><br>";
            echo "<label>Password:</label>";
            echo "<input type='password' name='userPassword'><br>";
            echo "<label>Gender:</label>";
            echo "<select name='userGender'>";
            echo "<option value='Male'>Male</option>";
            echo "<option value='Female'>Female</option>";
            echo "</select><br>";
            echo "<label>Phone:</label>";
            echo "<input type='text' name='userPhone'><br>";
            echo "<label>Email:</label>";
            echo "<input type='email' name='userEmail'><br>";
            echo "<label>Address:</label>";
            echo "<input type='text' name='userAddress'><br>";
            echo "<input type='submit' name='add_user' value='Add'>";
            echo "</form>";

        } else {
            // Fetch user data from the database based on selected username
            $query = "SELECT * FROM user WHERE userUsername = '$selectedUser'";
            $result = mysqli_query($conn, $query);
            $userData = mysqli_fetch_assoc($result);

            // Display user data in a form
            if ($userData) {
                echo "<br><h2>User Profile</h2><br>";
                echo "<form method='post' action=''>";
                foreach ($userData as $key => $value) {
                    // Define custom labels for each field using a switch statement
                    $label = '';
                    switch ($key) {
                        case 'userUsername':
                $label = 'Username:';
                // Check if editing an existing user or adding a new one
                $readonly = isset($_POST['selected_user']) ? 'readonly' : ''; // Add this line
                // Output the label and input field for username
                echo "<label>$label</label>";
                echo "<input type='text' name='$key' value='$value' $readonly><br>"; // Add $readonly here
                break;
                        case 'userFirstName':
                            $label = 'First Name:';
                            break;
                        case 'userLastName':
                            $label = 'Last Name:';
                            break;
                        case 'userNRIC':
                            $label = 'NRIC:';
                            break;
                        case 'userPassword':
                            $label = 'Password:';
                            break;
                        case 'userGender':
                            $label = 'Gender:';
                            // Define options for the gender dropdown
                            $options = array('Male', 'Female');
                            // Output the label and dropdown menu
                            echo "<label>$label</label>";
                            echo "<select name='$key'>";
                            foreach ($options as $option) {
                                $selected = ($option == $value) ? 'selected' : '';
                                echo "<option value='$option' $selected>$option</option>";
                            }
                            echo "</select><br>";
                            break;
                        case 'userPhone':
                            $label = 'Phone:';
                            break;
                        case 'userEmail':
                            $label = 'Email:';
                            break;
                        case 'userAddress':
                            $label = 'Address:';
                            break;
                        default:
                            $label = ucfirst($key) . ':';
                            break;
                    }
                       // Output the label and input field for each user data field
                        if ($key !== 'userGender' && $key !== 'userUsername') {
            echo "<label>$label</label>";
            echo "<input type='text' name='$key' value='$value'><br>";
                        }
                    }
                // Add buttons for updating and deleting user data
                echo "<input type='submit' name='update' value='Update'>";
                echo "<input type='submit' name='delete' value='Delete'>";
                echo "</form>";
            } else {
                echo "<p>User not found.</p>";
            }
        }
    }

    // Check if update button is clicked
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
        updateUser($_POST); // Call function to update user data
    }

    // Check if delete button is clicked
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete"])) {
        $selectedUser = $_POST['userUsername'];
        deleteUser($selectedUser); // Call function to delete user
    }

    // Check if add button is clicked
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_user"])) {
        addUser($_POST); // Call function to add user
    }
    ?>
</main>
<?php
// Close the connection
mysqli_close($conn);
?>


</body>
</html>
