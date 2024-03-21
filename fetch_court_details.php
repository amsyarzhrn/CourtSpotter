<?php
// Include the database connection
require_once "dbconnect.php";

// Check if courtID is provided via GET parameter
if(isset($_GET['courtID'])) {
    // Sanitize the input to prevent SQL injection
    $courtID = $_GET['courtID'];

    // Query to fetch court details based on courtID
    $query = "SELECT courtType, courtName, courtPrice FROM courtinfo WHERE courtID = ?";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $courtID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if court details are found
    if ($result->num_rows > 0) {
        // Fetch court details as an associative array
        $courtDetails = $result->fetch_assoc();
        
        // Return court details as JSON response
        header('Content-Type: application/json');
        echo json_encode($courtDetails);
    } else {
        // If court details are not found, return an empty JSON object
        echo json_encode((object) array());
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If courtID is not provided, return an error message
    echo "Error: Court ID not provided.";
}
?>
