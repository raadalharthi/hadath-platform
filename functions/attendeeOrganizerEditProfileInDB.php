<?php
session_start();

// Database Connection
require 'include/connection.php';

// Retrieve form data
$firstName = $_POST["firstName"] ?? "";
$lastName = $_POST["lastName"] ?? "";
$organizerName = $_POST["organizerName"] ?? "";
$email = $_POST["email"];
$gender = $_POST["gender"] ?? "";
$college = $_POST["college"];
$birthDate = $_POST["birthDate"] ?? "";

// Update attendee profile
if (!empty($_SESSION['attendeeID'])) {
    $attendeeID = $_SESSION['attendeeID'][0];
    $sql = "UPDATE attendee SET firstName = ?, lastName = ?, email = ?, gender = ?, college = ?, birthDate = ? WHERE attendeeID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $firstName, $lastName, $email, $gender, $college, $birthDate, $attendeeID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Update organizer profile
if (!empty($_SESSION['organizerID'])) {
    $organizerID = $_SESSION['organizerID'][0];
    $sql = "UPDATE organizer SET organizerName = ?, email = ?, college = ? WHERE organizerID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $organizerName, $email, $college, $organizerID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Close database connection
mysqli_close($conn);

// Redirect back to the edit profile page
header("Location: attendeeOrganizerEditProfilePage.php");
exit();
?>
