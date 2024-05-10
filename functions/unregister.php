<?php
session_start();
require_once '../include/connection.php';

if (isset($_POST['eventID']) && isset($_SESSION['attendeeID'])) {
    $eventID = intval($_POST['eventID']);
    $attendeeID = intval($_SESSION['attendeeID'][0]);

    // Unregister attendee from the event
    $sql = "DELETE FROM registrations WHERE eventID = ? AND attendeeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $eventID, $attendeeID);

    if ($stmt->execute()) {
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
