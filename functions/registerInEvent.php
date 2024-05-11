<?php
session_start();

$attendeeID = $_POST['attendeeID'];
$eventID = $_POST['eventID'];

require_once '../include/connection.php';

// Check if attendeeID exists
$checkAttendee = mysqli_prepare($conn, "SELECT attendeeID FROM attendee WHERE attendeeID = ?");
mysqli_stmt_bind_param($checkAttendee, 'i', $attendeeID);
mysqli_stmt_execute($checkAttendee);
mysqli_stmt_store_result($checkAttendee);

// Check if eventID exists along with its capacity and number of registered attendees
$checkEvent = mysqli_prepare($conn, "SELECT eventID, capacity, numberOfRegistered FROM events WHERE eventID = ?");
mysqli_stmt_bind_param($checkEvent, 'i', $eventID);
mysqli_stmt_execute($checkEvent);
mysqli_stmt_store_result($checkEvent);
mysqli_stmt_bind_result($checkEvent, $fetchedEventID, $capacity, $numberOfRegistered);

// Check if the attendee is already registered for the event
$checkRegistration = mysqli_prepare($conn, "SELECT registrationID FROM registrations WHERE attendeeID = ? AND eventID = ?");
mysqli_stmt_bind_param($checkRegistration, 'ii', $attendeeID, $eventID);
mysqli_stmt_execute($checkRegistration);
mysqli_stmt_store_result($checkRegistration);

if (mysqli_stmt_num_rows($checkAttendee) == 1 && mysqli_stmt_num_rows($checkEvent) == 1) {
    mysqli_stmt_fetch($checkEvent);  // Fetch the capacity and current number of registered attendees
    if (mysqli_stmt_num_rows($checkRegistration) > 0) {
        // Attendee is already registered for the event
        echo "You are already registered for this event.";
    } else if ($numberOfRegistered >= $capacity) {
        // Check if the event is at full capacity
        echo "Registration failed: The event is at full capacity.";
    } else {
        // Both IDs exist and the attendee is not registered for the event, proceed with insert
        $sql = "INSERT INTO registrations (attendeeID, eventID) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $attendeeID, $eventID);

        if (mysqli_stmt_execute($stmt)) {
            // Update the number of registered attendees
            $updateSql = "UPDATE events SET numberOfRegistered = numberOfRegistered + 1 WHERE eventID = ?";
            $updateStmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($updateStmt, 'i', $eventID);
            mysqli_stmt_execute($updateStmt);

            header("location: ../attendeeRegisteredEventsPage.php");
            exit;
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }
    }
} else {
    echo "Error: Invalid attendee ID or event ID.";
}

?>
