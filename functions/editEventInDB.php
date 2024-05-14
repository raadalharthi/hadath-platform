<?php

// Start session and include the database connection
session_start();
require_once '../include/connection.php';

// Retrieve event data from session
$eventID = $_SESSION['eventID'];
$image = $_SESSION['image'];
$eventTitle = $_SESSION['eventTitle'];
$eventType = $_SESSION['eventType'];
$eventDate = $_SESSION['eventDate'];
$eventTime = $_SESSION['eventTime'];
$eventLocation = $_SESSION['eventLocation'];
$eventDescription = $_SESSION['eventDescription'];
$eventCapacity = $_SESSION['eventCapacity'];
$organizerID = $_SESSION['organizerID'][0]; // Retrieve organizer ID from session

// Update the event data in the database
$sql = "UPDATE events SET title = ?, eventType = ?, date = ?, time = ?, location = ?, description = ?, organizerID = ?, capacity = ?, eventImage = ? 
        WHERE eventID = ?;";
$stmt = mysqli_prepare($conn, $sql);

// Check if the statement was prepared successfully
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssssiiisi", $eventTitle, $eventType, $eventDate, $eventTime, $eventLocation, $eventDescription, $organizerID, $eventCapacity, $image, $eventID);
    $executeResult = mysqli_stmt_execute($stmt);

    if ($executeResult) {
        // If the update was successful, redirect to the index/home page
        header('Location: ../organizerMyEventsPage.php');
        exit();
    } else {
        // Handle error in execution, e.g., display or log error message
        echo "Error updating event: " . mysqli_error($conn);
    }
} else {
    // Handle error in statement preparation, e.g., display or log error message
    echo "Error preparing statement: " . mysqli_error($conn);
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
