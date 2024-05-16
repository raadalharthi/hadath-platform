<?php
session_start();

// Initialize variables
$firstName = $lastName = $organizerName = $email = $gender = $college = $birthDate = "";
$firstNameError = $lastNameError = $organizerNameError = $emailError = $genderError = $collegeError = $birthDateError = "";

// Validate form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name and last name (for attendees)
    if (!empty($_SESSION['attendeeID'])) {
        $firstName = trim($_POST["firstName"]);
        $lastName = trim($_POST["lastName"]);

        if (empty($firstName)) {
            $firstNameError = "First Name is required.";
        }

        if (empty($lastName)) {
            $lastNameError = "Last Name is required.";
        }
    }

    // Validate organizer name (for organizers)
    if (!empty($_SESSION['organizerID'])) {
        $organizerName = trim($_POST["organizerName"]);

        if (empty($organizerName)) {
            $organizerNameError = "Organizer Name is required.";
        }
    }

    // Validate email
    $email = trim($_POST["email"]);
    if (empty($email)) {
        $emailError = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
    }

    // Validate gender (for attendees)
    if (!empty($_SESSION['attendeeID'])) {
        $gender = trim($_POST["gender"]);
        if (empty($gender)) {
            $genderError = "Gender is required.";
        }
    }

    // Validate college
    $college = trim($_POST["college"]);
    if (empty($college)) {
        $collegeError = "College is required.";
    }

    // Validate birth date (for attendees)
    if (!empty($_SESSION['attendeeID'])) {
        $birthDate = trim($_POST["birthDate"]);
        if (empty($birthDate)) {
            $birthDateError = "Birth Date is required.";
        }
    }

    // If no errors, proceed to update the database
    if (empty($firstNameError) && empty($lastNameError) && empty($organizerNameError) && empty($emailError) && empty($genderError) && empty($collegeError) && empty($birthDateError)) {
        updateProfileInDB($firstName, $lastName, $organizerName, $email, $gender, $college, $birthDate);
    }
}

function updateProfileInDB($firstName, $lastName, $organizerName, $email, $gender, $college, $birthDate)
{
    // Database Connection
    require 'include/connection.php';

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
    header("Location: ../index.php");
    exit();
}
?>
