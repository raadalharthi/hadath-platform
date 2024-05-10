<?php
session_start();
require_once '../include/connection.php';

if (isset($_SESSION['attendeeID']) && isset($_POST['notificationID'])) {
    $attendeeID = intval($_SESSION['attendeeID'][0]);
    $notificationID = intval($_POST['notificationID']);

    $sql = "DELETE FROM attendeeNotifications WHERE attendeeID = ? AND notificationID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare Statement Error: " . $conn->error);
    }

    $stmt->bind_param("ii", $attendeeID, $notificationID);

    if ($stmt->execute()) {
        header("Location: ../attendeeNotificationsPage.php?message=dismissed");
    } else {
        header("Location: ../attendeeNotificationsPage.php?error=failed");
    }
} else {
    header("Location: ../attendeeNotificationsPage.php?error=invalid");
}
?>
