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
$organizerID = $_SESSION['organizerID'][0]; // Retrieve organizer ID from session

// Check if session variables are set
if (empty($eventTitle) || empty($eventType)) {
    die("Required session variables are not set.");
}

// Insert the event data into the database
$sql = "INSERT INTO events (title, eventType, date, time, location, description, organizerID, capacity, registrationDeadline, eventImage) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssssiiis", $eventTitle, $eventType, $eventDate, $eventTime, $eventLocation, $eventDescription, $organizerID, $eventCapacity, $registrationDeadline, $image);
    $executeResult = mysqli_stmt_execute($stmt);

    if (!$executeResult) {
        die("Error inserting event: " . mysqli_error($conn));
    }
} else {
    die("Error preparing event statement: " . mysqli_error($conn));
}

// Prepare the SQL statement for notification
$sql1 = "INSERT INTO notification (notificationType, message)
        VALUES ('New Event', CONCAT('New ', ?, ' event named ', ?, ', offered by ', ?, ' will be held on ', ?));";
$stmt1 = mysqli_prepare($conn, $sql1);

if ($stmt1) {
    mysqli_stmt_bind_param($stmt1, "ssss", $eventType, $eventTitle, $organizerID, $eventTime);
    $executeResult = mysqli_stmt_execute($stmt1);

    if (!$executeResult) {
        die("Error adding notification: " . mysqli_error($conn));
    } else {
        header('Location: ../organizerMyEventsPage.php');
    }
} else {
    die("Error preparing notification statement: " . mysqli_error($conn));
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmt1);
mysqli_close($conn);
?>