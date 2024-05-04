<?php
include_once '../include/connection.php';

// Check if the eventID is present in the POST request
if (!isset($_POST['eventID'][0])) {
    die('Event ID is missing.');
}

// Escape the input to prevent SQL Injection
$id = mysqli_real_escape_string($conn, $_POST['eventID'][0]);

// Prepare the SQL statement to avoid SQL Injection
$sql = "DELETE FROM events WHERE eventID = ?";

// Prepare the query
if ($stmt = mysqli_prepare($conn, $sql)) {
    // Bind the integer id to the prepared statement
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Redirect if the deletion is successful
        header("Location: ../organizerMyEventsPage.php");
        exit;
    } else {
        // Error in execution
        die('Error executing the query: ' . mysqli_error($conn));
    }
} else {
    // Error preparing the query
    die('Error preparing the query: ' . mysqli_error($conn));
}

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close the connection
mysqli_close($conn);
?>