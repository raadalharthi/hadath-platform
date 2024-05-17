<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../include/connection.php');

    $pass = $_POST['pass'];
    $confirmPassword = $_POST['confirmPassword'];

    // to prevent from mysqli injection
    $pass = stripcslashes($pass);
    $confirmPassword = stripcslashes($confirmPassword);

    $pass = mysqli_real_escape_string($conn, $pass);
    $confirmPassword = mysqli_real_escape_string($conn, $confirmPassword);

    $passwordPattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/";

    $validationPassed = true; // Initialize $validationPassed as true
    $messages = array(); // Initialize $messages as an empty array

    if (empty($pass)) {
        $messages[] = "Password not provided. Please enter your password.";
        $validationPassed = false;
    }

    if (!preg_match($passwordPattern, $pass)) {
        $messages[] = "Password must be at least 8 characters long and include uppercase and lowercase letters, a number, and a special character.";
        $validationPassed = false;
    }

    if (empty($confirmPassword)) {
        $messages[] = "Please re-enter your password.";
        $validationPassed = false;
    }

    if ($pass !== $confirmPassword) {
        $messages[] = "Passwords do not match.";
        $validationPassed = false;
    }

    if (!$validationPassed) {
        // Concatenate all messages into a single alert
        $alertMessage = implode("\\n", $messages);
        echo "<script type='text/javascript'>";
        echo "alert('$alertMessage');";
        echo "window.location.href = '../guestSetNewPasswordPage.php';";
        echo "</script>";
    } else {
        if (!empty($_SESSION['pass'])) {
            unset($_SESSION["pass"]);
        }
        session_start();
        $_SESSION['pass'] = $pass;

        echo "<script type='text/javascript'>";
        echo "window.location.href = 'resetPasswordInDB.php';";
        echo "</script>";
    }
} else {
    // If the form is not submitted, redirect back to the signup page
    header('Location: ../guestSetNewPasswordPage.php');
    exit;
}
