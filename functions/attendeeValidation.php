<?php

// Flag to track validation status
$validationPassed = true;
$messages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include('../include/connection.php');

    $userType = $_POST['userType'];
    $image = $_POST['imageBase64'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $birthDate = $_POST['birthDate'];
    $college = $_POST['college'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // to prevent from mysqli injection
    $firstName = stripcslashes($firstName);
    $lastName = stripcslashes($lastName);
    $email = stripcslashes($email);
    $password = stripcslashes($password);
    $confirmPassword = stripcslashes($confirmPassword);

    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $confirmPassword = mysqli_real_escape_string($conn, $confirmPassword);

    // Query the database to find if the email is already registered
    $query = "SELECT email FROM attendee WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    $namePattern = "/^[A-Za-z]+$/";
    $emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    $passwordPattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/";

    if (empty($firstName)) {
        $messages[] = "First name not provided. Please enter your first name.";
        $validationPassed = false;
    }

    if (!preg_match($namePattern, $firstName)) {
        $messages[] = "First name can only contain English letters. Please enter a valid first name.";
        $validationPassed = false;
    }

    if (empty($lastName)) {
        $messages[] = "Last name not provided. Please enter your last name.";
        $validationPassed = false;
    }

    if (!preg_match($namePattern, $lastName)) {
        $messages[] = "Last name can only contain English letters. Please enter a valid last name.";
        $validationPassed = false;
    }

    if ($gender === "Select your gender" || $gender === "") {
        $messages[] = "Please select your gender.";
        $validationPassed = false;
    }

    if (empty($birthDate)) {
        $messages[] = "Birth date not provided. Please enter your birth date.";
        $validationPassed = false;
    } else {
        // Convert birth date to PHP DateTime object
        $birthDateObject = DateTime::createFromFormat('Y-m-d', $birthDate);
        $today = new DateTime();

        // Calculate age
        $diff = $today->diff($birthDateObject);
        $age = $diff->y;

        // Check if the user is older than 10 years
        if ($age < 10) {
            $messages[] = "You must be older than 10 years to sign up.";
            $validationPassed = false;
        }
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

    if (mysqli_num_rows($result) > 0) {
        $messages[] = "This email is already registered. Please use a different email.";
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
        echo "window.location.href = '../attendeeSignupPage.php';";
        echo "</script>";
    } else {

        session_start();
        $_SESSION['userType'] = $userType;
        $_SESSION['imageBase64'] = $image;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['gender'] = $gender;
        $_SESSION['birthDate'] = $birthDate;
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