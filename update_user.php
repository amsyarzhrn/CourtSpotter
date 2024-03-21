<?php
// Include the database connection
require_once "dbconnect.php";

// Function to sanitize user input
function sanitize_input($data) {
    // Remove whitespace from the beginning and end of the string
    $data = trim($data);
    // Remove backslashes (\)
    $data = stripslashes($data);
    // Convert special characters to HTML entities
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $nric = sanitize_input($_POST['nric']);
    $gender = sanitize_input($_POST['gender']);
    $phone = sanitize_input($_POST['phone']);
    $email = sanitize_input($_POST['email']);
    $address = sanitize_input($_POST['address']);
    $pic = sanitize_input($_POST['pic']);

    // Update user data in the database
    $sql = "UPDATE user SET userFirstName='$firstName', userLastName='$lastName', userNRIC='$nric', userGender='$gender', userPhone='$phone', userEmail='$email', userAddress='$address', userPic='$pic' WHERE userUsername='$username'";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the page where the form was submitted
        header("Location: adminprofile.php");
        exit();
    } else {
        // Handle the update error
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>
