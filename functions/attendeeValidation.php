<?php

// Flag to track validation status
$validationPassed = true;
$messages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    include('../include/connection.php');


    $userType = $_POST['userType'];
    $image = $_POST['imageBase64'];
    $college = $_POST['college'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // to prevent from mysqli injection  
    $email = stripcslashes($email);
    $password = stripcslashes($password);
    $confirmPassword = stripcslashes($confirmPassword);

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $confirmPassword = mysqli_real_escape_string($conn, $confirmPassword);

    if ($userType == 'Attendee Signup') {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $birthDate = $_POST['birthDate'];

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

    $organizerNamePattern = "/^[A-Za-z ]+$/";
    $emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $passwordPattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/";

    if (empty($organizerName)) {
        $messages[] = "Organizer name not provided. Please enter the organizer name.";
        $validationPassed = false;
    }

    if (!preg_match($organizerNamePattern, $organizerName)) {
        $messages[] = "Organizer name can only contain English letters. Please enter a valid name.";
        $validationPassed = false;
    }

    if ($college === "Select College" || $college === "") {
        $messages[] = "Please select a college.";
        $validationPassed = false;
    }

    if (empty($email)) {
        $messages[] = "Email address not provided. Please enter your email address.";
        $validationPassed = false;
    }

    if (!preg_match($emailPattern, $email)) {
        $messages[] = "Please enter a valid email address.";
        $validationPassed = false;
    }

    if (empty($password)) {
        $messages[] = "Password not provided. Please enter your password.";
        $validationPassed = false;
    }

    if (!preg_match($passwordPattern, $password)) {
        $messages[] = "Password must be at least 8 characters long and include uppercase and lowercase letters, a number, and a special character.";
        $validationPassed = false;
    }

    if (empty($confirmPassword)) {
        $messages[] = "Please re-enter your password.";
        $validationPassed = false;
    }

    if ($password !== $confirmPassword) {
        $messages[] = "Passwords do not match.";
        $validationPassed = false;
    }

    if (!$validationPassed) {
        // Concatenate all messages into a single alert
        $alertMessage = implode("\\n", $messages);
        echo "<script type='text/javascript'>";
        echo "alert('$alertMessage');";
        echo "window.location.href = '../organizerSignupPage.php';";
        echo "</script>";
    } else {

        session_start();
        $_SESSION['organizerName'] = $organizerName;
        $_SESSION['college'] = $college;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        // Redirect to OTP verification page on successful validation
        echo "<script type='text/javascript'>";
        echo "window.location.href = 'sendOTP.php';";
        echo "</script>";
    }
} else {
    // If the form is not submitted, redirect back to the signup page
    header('Location: ../attendeeSignupPage.php');
    exit;
}

?>