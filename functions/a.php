<?php

session_start();

if (isset($_POST['enterdOTP'])) {
    $userOtp = $_POST['enterdOTP'];
    $sessionOtp = $_SESSION['otp'] ?? ''; // Safe fallback to ensure there's no undefined index error

    if ($userOtp == $sessionOtp) {
        // OTP is correct, proceed with preparing data for database insertion

        // Hash the password before storing it in the database

        // Store additional user details in session if needed



        // Insert the user data into the database, using the hashed password
        $sql = "INSERT INTO organizer (firstName, lastName, email, password, gender, college, attendeeImage, birthDate) VALUES ('$firstName', '$lastName', '$email', '$password', '$gender', '$college', '$image', $birthDate');";
        $result = mysqli_query($conn, $sql);

        session_destroy();

        session_start();

        if (empty($_SESSION['attendeeID'])) {
            $_SESSION['attendeeID'] = array();
        }

        // Redirect to the home/index page after successful registration
        header('Location: ../index.php');
        exit();
    } else {
        // OTP is incorrect, set an error message and redirect back to the OTP page
        $_SESSION['error_message'] = 'Invalid OTP. Please try again.';
        header('Location: ../otpVerification.php'); // Adjust this to your OTP form page
        exit();
    }
} else {
    // Redirect back if accessed directly without POST data or to handle other logic
    $_SESSION['error_message'] = 'OTP not provided. Please try again.';
    header('Location: ../otpVerification.php'); // Adjust based on your form page
    exit();
}

?>