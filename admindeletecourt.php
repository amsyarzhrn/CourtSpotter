<?php
// Include the database connection
require_once "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the edit button is pressed
    if (isset($_POST['edit'])) {
        // Check if a court is selected
        if (isset($_POST['court_ids']) && !empty($_POST['court_ids'])) {
            // Get the selected court ID
            $courtID = $_POST['court_ids'][0]; // Since only one court can be selected

            // Redirect to the edit court page with the court ID as a parameter
            header("Location: adminedit_court.php?courtID=$courtID");
            exit();
        } else {
            // No court selected for editing
            header("Location: adminmanagecourt.php?edit_error=true");
            exit();
        }
    }

    // Check if the add button is pressed
    if (isset($_POST['add'])) {
        // Redirect to the add court page
        header("Location: adminadd_court.php");
        exit();
    }

    // Check if the delete button is pressed
    if (isset($_POST['delete'])) {
        // Check if a court is selected
        if (isset($_POST['court_ids']) && !empty($_POST['court_ids'])) {
            // Get the selected court ID
            $courtID = $_POST['court_ids'][0]; // Since only one court can be selected

            // SQL query to delete court data by Court ID
            $deleteSql = "DELETE FROM courtinfo WHERE courtID = ?";
            $stmt = $conn->prepare($deleteSql);
            $stmt->bind_param("s", $courtID);

            // Execute the statement
            $stmt->execute();

            // Close the statement
            $stmt->close();

            // Redirect back to adminmanagecourt.php
            header("Location: adminmanagecourt.php");
            exit();
        } else {
            // No court selected for delete
            header("Location: adminmanagecourt.php?delete_error=true");
            exit();
        }
    }
}
?>
