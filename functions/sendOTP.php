<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjust this to the path where PHPMailer is located

// Function to validate form data
function formIsValid()
{
    // Perform your validation checks here
    // For example, check if email is valid, fields are not empty, etc.
    // Return true if valid, false otherwise
    return true; // This is just a placeholder
}

// Function to send OTP using PHPMailer and Outlook SMTP
function sendOTP($recipientEmail)
{
    $otp = rand(100000, 999999); // Generate OTP
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'smtp.office365.com';                   // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'Hadath_Platform@outlook.com';          // SMTP username
        $mail->Password = 'Hadath@2023';                          // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('Hadath_Platform@outlook.com', 'Hadath Platform');
        $mail->addAddress($recipientEmail);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your OTP for Signup';
        $mail->Body = 'Your OTP is: ' . $otp;

        $mail->send();
        return $otp;
    } catch (Exception $e) {
        // Handle error; perhaps log it and return false or an error message
        return false;
    }
}

if (formIsValid()) {
    // Capture all necessary information from the form
    $email = $_SESSION['email']; // Make sure to sanitize this

    // Now send the OTP
    $otp = sendOTP($email);

    if ($otp !== false) {
        // Store the form data and OTP in the session or a database temporarily
        $_SESSION['otp'] = $otp; // Store the OTP for verification

        // Redirect to OTP verification page
        header('Location: ../otpVerificationPage.php');
        exit;
    } else {
        // Handle error in sending OTP
        echo "There was an error sending the OTP. Please try again.";
    }
} else {
    // Form is not valid
    echo "The form is not valid. Please go back and try again.";
}
?>