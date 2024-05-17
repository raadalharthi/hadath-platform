<?php
session_start();

// Check if the necessary session variables are set
if (isset($_SESSION['pass'])) {
    $pass = $_SESSION['pass'];
    $hashedPassword = md5($pass);

    // Check if the email session variable is set for attendee or organizer
    if (isset($_SESSION['attendeeEmail'])) {
        $email = $_SESSION['attendeeEmail'];

        require_once '../include/connection.php';

        // Update the password for the attendee
        $sql = "UPDATE attendee SET password = '$hashedPassword' WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Password update successful
            session_destroy();

            session_start();

            if (empty($_SESSION['attendeeID'])) {
                $_SESSION['attendeeID'] = array();
            }

            $sql = "SELECT attendeeID FROM attendee WHERE email = ? AND password = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $id = $row['attendeeID'];
            array_push($_SESSION['attendeeID'], $id);

            // Redirect to the home/index page after successful password update
            header('Location: ../index.php');
            exit();
        } else {
            // Handle the case when the password update fails
            echo "Error updating password: " . mysqli_error($conn);
        }
    } elseif (isset($_SESSION['organizerEmail'])) {
        $email = $_SESSION['organizerEmail'];

        require_once '../include/connection.php';

        // Update the password for the organizer
        $sql = "UPDATE organizer SET password = '$hashedPassword' WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Password update successful
            session_destroy();

            session_start();

            if (empty($_SESSION['organizerID'])) {
                $_SESSION['organizerID'] = array();
            }

            $sql = "SELECT organizerID FROM organizer WHERE email = ? AND password = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $id = $row['organizerID'];
            array_push($_SESSION['organizerID'], $id);

            // Redirect to the home/index page after successful password update
            header('Location: ../index.php');
            exit();
        } else {
            // Handle the case when the password update fails
            echo "Error updating password: " . mysqli_error($conn);
        }
    } else {
        // Handle the case when the email session variable is not set
        echo "Email session variable not set or invalid.";
    }
} else {
    // Handle the case when the password session variable is not set
    echo "Password session variable not set or invalid.";
}
