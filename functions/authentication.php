<?php 
session_start();

include('../include/connection.php');

$userType = $_POST['userType'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// to prevent from mysqli injection  
$userType = stripcslashes($userType);
$email = stripcslashes($email);
$password = stripcslashes($password);
$confirmPassword = stripcslashes($confirmPassword);

$userType = mysqli_real_escape_string($conn, $userType);
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);
$confirmPassword = mysqli_real_escape_string($conn, $confirmPassword);

if ($userType == 'Attendee Signup') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];

    $firstName = stripcslashes($firstName);
    $lastName = stripcslashes($lastName);
    $gender = stripcslashes($gender);

    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $gender = mysqli_real_escape_string($conn, $gender);

} elseif ($userType == 'Organizer Signup') {
    $organizerName = $_POST['organizerName'];
    $college = $_POST['college'];

    $organizerName = stripcslashes($organizerName);
    $college = stripcslashes($college);

    $organizerName = mysqli_real_escape_string($conn, $organizerName);
    $college = mysqli_real_escape_string($conn, $college);
}


if ($userType == 'Attendee Signup') {
    $sql = "INSERT INTO attendee (firstName, lastName, email, password, gender) VALUES ('$firstName', '$lastName', '$email', '$password', '$gender');";
    $result = mysqli_query($conn, $sql);
    header('Location: ../index.php');
} elseif ($userType == 'Organizer Signup') {
    $sql = "INSERT INTO organizer (organizerName, email, password, college) VALUES ('$organizerName', '$email', '$password', '$college');";
    $result = mysqli_query($conn, $sql);
    header('Location: ../index.php');
} else {

    // Initialize session arrays if not already set
    if (empty($_SESSION['organizerID'])) {
        $_SESSION['organizerID'] = array();
    }
    if (empty($_SESSION['attendeeID'])) {
        $_SESSION['attendeeID'] = array();
    }

    // First, check in the 'attendee' table
    $sqlAttendee = "SELECT * FROM attendee WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sqlAttendee);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $resultAttendee = mysqli_stmt_get_result($stmt);
    $countAttendee = mysqli_num_rows($resultAttendee);

    // If found in 'attendee' table
    if ($countAttendee == 1) {
        $row = mysqli_fetch_array($resultAttendee, MYSQLI_ASSOC);
        $id = $row['ID'];
        array_push($_SESSION['attendeeID'], $id);
        header('Location: ../index.php');
        exit(); // Make sure no further code is executed
    } else {
        // If not found in 'attendee', check in 'organizer' table
        $sqlOrganizer = "SELECT * FROM organizer WHERE email = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sqlOrganizer);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $resultOrganizer = mysqli_stmt_get_result($stmt);
        $countOrganizer = mysqli_num_rows($resultOrganizer);

        // If found in 'organizer' table
        if ($countOrganizer == 1) {
            $row = mysqli_fetch_array($resultOrganizer, MYSQLI_ASSOC);
            $id = $row['ID'];
            array_push($_SESSION['organizerID'], $id);
            header('Location: ../index.php');
            exit(); // Make sure no further code is executed
        } else {
            // If not found in both tables, redirect to the error page
            header('Location: errorpage.php');
            exit();
        }
    }
}
?>