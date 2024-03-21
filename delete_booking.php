<?php
// Include the database connection
require_once "dbconnect.php";

// Start the session
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the delete button was clicked and booking IDs are set
    if(isset($_POST['delete']) && isset($_POST['booking_ids'])) {
        // Sanitize the input (prevent SQL injection)
        $booking_ids = $_POST['booking_ids'];

        // Prepare a statement to delete bookings
        $sql = "DELETE FROM booking WHERE bookingID = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters and execute the statement for each booking ID
        foreach ($booking_ids as $booking_id) {
            $stmt->bind_param("s", $booking_id);
            if ($stmt->execute() === FALSE) {
                // If an error occurred during deletion, redirect back with an error message
                header("Location: adminmanagebookings.php?error=1");
                exit();
            }
        }

        // Close the statement
        $stmt->close();

        // Redirect back to the mybookings.php page with a success message
        header("Location: adminmanagebookings.php?success=1");
        exit();
    }
    else {
            // No court selected for delete
            header("Location: adminmanagebookings.php?delete_error=true");
            exit();
        }
}
?>
