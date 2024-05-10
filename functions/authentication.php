<?php



session_start(); // Start or resume the current session

require_once '../include/connection.php';

// Initialize session arrays if not already set
if (!isset($_SESSION['organizerID'])) {
    $_SESSION['organizerID'] = array();
}
if (!isset($_SESSION['attendeeID'])) {
    $_SESSION['attendeeID'] = array();
}

$email = $_POST['email'];
$pass = $_POST['pass'];

// Prepared statement for 'attendee' table
$sqlAttendee = "SELECT * FROM attendee WHERE email = ? AND password = ?";
$stmt = mysqli_prepare($conn, $sqlAttendee);
mysqli_stmt_bind_param($stmt, "ss", $email, $pass);
mysqli_stmt_execute($stmt);
$resultAttendee = mysqli_stmt_get_result($stmt);
$countAttendee = mysqli_num_rows($resultAttendee);

// If found in 'attendee' table
if ($countAttendee == 1) {
    $row = mysqli_fetch_assoc($resultAttendee);
    $id = $row['attendeeID'];
    // Ensure unique entry
    if (!in_array($id, $_SESSION['attendeeID'])) {
        array_push($_SESSION['attendeeID'], $id);
    }
    header('Location: ../index.php');
    exit();
} else {
    // Prepared statement for 'organizer' table
    $sqlOrganizer = "SELECT * FROM organizer WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sqlOrganizer);
    mysqli_stmt_bind_param($stmt, "ss", $email, $pass);
    mysqli_stmt_execute($stmt);
    $resultOrganizer = mysqli_stmt_get_result($stmt);
    $countOrganizer = mysqli_num_rows($resultOrganizer);

    // If found in 'organizer' table
    if ($countOrganizer == 1) {
        $row = mysqli_fetch_assoc($resultOrganizer);
        $id = $row['organizerID'];
        // Ensure unique entry
        if (!in_array($id, $_SESSION['organizerID'])) {
            array_push($_SESSION['organizerID'], $id);
        }
        header('Location: ../index.php');
        exit();
    } else {
        // If not found in both tables, redirect to the error page
        header('Location: ../errorpage.php');
        exit();
    }
}

?>