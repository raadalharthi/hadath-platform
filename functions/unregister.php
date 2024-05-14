<?php
session_start();
require_once '../include/connection.php';

if (isset($_POST['eventID']) && isset($_SESSION['attendeeID'])) {
    $eventID = intval($_POST['eventID']);
    $attendeeID = intval($_SESSION['attendeeID'][0]);

    // Get the current numberOfRegistered for the event
    $sql = "SELECT numberOfRegistered FROM events WHERE eventID = ?";
    $stmt1 = $conn->prepare($sql);
    $stmt1->bind_param("i", $eventID);
    $stmt1->execute();
    $result = $stmt1->get_result();
    $row = $result->fetch_assoc();
    $numberOfRegistered = $row['numberOfRegistered'];

    // Unregister attendee from the event
    $sql = "DELETE FROM registrations WHERE eventID = ? AND attendeeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $eventID, $attendeeID);

    if ($stmt->execute()) {
        // Update the numberOfRegistered in the events table
        $numberOfRegistered--;
        $updateSql = "UPDATE events SET numberOfRegistered = ? WHERE eventID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $numberOfRegistered, $eventID);
        $updateStmt->execute();

        header("Location: ../attendeeRegisteredEventsPage.php?message=unrolled");
        exit();
    } else {
        header("Location: ../attendeeRegisteredEventsPage.php?error=failed");
        exit();
    }
} else {
    header("Location: ../attendeeRegisteredEventsPage.php?error=invalid");
    exit();
}
?>