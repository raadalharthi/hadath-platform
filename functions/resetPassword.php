<?php


session_start();

$pass = $_SESSION['pass'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once '../include/connection.php';

    if (isset($_SESSION['attendeeEmail'])) {

        $email = $_SESSION['attendeeEmail'];

        $sql = "UPDATE attendee SET password = '$pass' WHERE email = '$email';";
        $result = mysqli_query($conn, $sql);

        session_destroy();

        session_start();

        if (empty($_SESSION['attendeeID'])) {
            $_SESSION['attendeeID'] = array();
        }

        $sql = "SELECT attendeeID FROM attendee WHERE email = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $pass);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $id = $row['attendeeID'];
        array_push($_SESSION['attendeeID'], $id);
    }

    if (isset($_SESSION['organizerEmail'])) {

        $email = $_SESSION['organizerEmail'];

        $sql = "UPDATE organizer SET password = '$pass' WHERE email = '$email';";
        $result = mysqli_query($conn, $sql);

        session_destroy();

        session_start();

        if (empty($_SESSION['organizerID'])) {
            $_SESSION['organizerID'] = array();
        }

        $sql = "SELECT organizerID FROM organizer WHERE email = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $pass);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $id = $row['organizerID'];
        array_push($_SESSION['organizerID'], $id);
    }

    // Redirect to the home/index page after successful registration
    header('Location: ../index.php');
    exit();
} else {
    // Redirect back if accessed directly without POST data or to handle other logic
    $_SESSION['error_message'] = 'OTP not provided. Please try again.';
    header('Location: ../guestSetNewPasswordPage.php'); // Adjust based on your form page
    exit();
}
?>