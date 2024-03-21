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

        // Get the current date and time
        $current_datetime = date('Y-m-d H:i:s');

        // Prepare a statement to fetch booking start times for selected bookings
        $sql = "SELECT bookingStartTime FROM booking WHERE bookingID = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters and execute the statement for each booking ID
        foreach ($booking_ids as $booking_id) {
            $stmt->bind_param("s", $booking_id);
            $stmt->execute();
            $stmt->bind_result($booking_start_time);
            $stmt->fetch();

            // Calculate the difference in hours between current time and booking start time
            $time_diff = strtotime($booking_start_time) - strtotime($current_datetime);
            $hours_diff = $time_diff / (60 * 60);

            // Check if the booking start time is in the past or less than 4 hours from now
            if ($hours_diff < 4 || $time_diff < 0) {
                // If less than 4 hours or in the past, redirect back with an error message
                header("Location: mybookings.php?error=1");
                exit();
            }

        }

        // Close the statement
        $stmt->close();

        // Prepare a statement to delete bookings
        $sql = "DELETE FROM booking WHERE bookingID = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters and execute the statement for each booking ID
        foreach ($booking_ids as $booking_id) {
            $stmt->bind_param("s", $booking_id);
            if ($stmt->execute() === FALSE) {
                // If an error occurred during deletion, redirect back with an error message
                header("Location: mybookings.php?error=1");
                exit();
            }
        }

        // Close the statement
        $stmt->close();

        // Redirect back to the mybookings.php page with a success message
        header("Location: mybookings.php?success=1");
        exit();
    } else {
        // No court selected for delete
        header("Location: mybookings.php?delete_error=true");
        exit();
    }
}
?>
