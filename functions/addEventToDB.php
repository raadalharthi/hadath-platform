<?php

// Start session and include the database connection
session_start();
require_once '../include/connection.php';

// Retrieve event data from session
$image = $_SESSION['image'];
$eventTitle = $_SESSION['eventTitle'];
$eventType = $_SESSION['eventType'];
$eventDate = $_SESSION['eventDate'];
$eventTime = $_SESSION['eventTime'];
$registrationDeadline = $_SESSION['registrationDeadline'];
$eventLocation = $_SESSION['eventLocation'];
$eventDescription = $_SESSION['eventDescription'];
$eventCapacity = $_SESSION['eventCapacity'];
$organizerID = $_SESSION['organizerID']; // Retrieve organizer ID from session

// Insert the event data into the database
$sql = "INSERT INTO events (title, eventType, date, time, location, description, organizerID, capacity, registrationDeadline, eventImage) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$stmt = mysqli_prepare($conn, $sql);

// Check if the statement was prepared successfully
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssssiiis", $eventTitle, $eventType, $eventDate, $eventTime, $eventLocation, $eventDescription, $organizerID, $eventCapacity, $registrationDeadline, $image);
    $executeResult = mysqli_stmt_execute($stmt);

    if ($executeResult) {
        // If the insert was successful, redirect to the index/home page
        header('Location: ../index.php');
        exit();
    } else {
        // Handle error in execution, e.g., display or log error message
        echo "Error inserting event: " . mysqli_error($conn);
    }
} else {
    // Handle error in statement preparation, e.g., display or log error message
    echo "Error preparing statement: " . mysqli_error($conn);
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
