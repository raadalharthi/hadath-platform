<?php
include_once '../include/connection.php';

session_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from POST
    $eventID = $_POST['eventID'];
    $ratingValue = $_POST['ratingValue'];
    $attendeeID = $_SESSION['attendeeID'][0];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO ratings (eventID, attendeeID, ratingValue, ratingDate) VALUES (?, ?, ?, NOW())");

    // Bind parameters
    $stmt->bind_param("iii", $eventID, $attendeeID, $ratingValue);

    // Execute the query
    if ($stmt->execute()) {
        header('Location: ../attendeeRegisteredEventsPage.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>