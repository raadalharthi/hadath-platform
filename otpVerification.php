<!DOCTYPE html>
<html lang="en">

<head>
    <title>OTP Verification</title>
    <?php
    include_once 'include/metaData.php';

    // Initialize error message
    $errorMessage = '';

    // Check for error message in session and clear it after displaying
    if (isset($_SESSION['error_message'])) {
        $errorMessage = $_SESSION['error_message'];
        unset($_SESSION['error_message']); // Clear the error message after displaying
    }

    $userType = $_SESSION['userType'];

    if ($userType == 'Organizer Signup') {
        $backgroundPath = "assets/organizerSignupPageBackground.jpg";
    }

    if ($userType == 'Attendee Signup') {
        $backgroundPath = "assets/attendeeSignupPageBackground.jpg";
        echo $_SESSION['imageBase64'];
        $_SESSION['imageBase64'] = $image;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['gender'] = $gender;
        $_SESSION['birthDate'] = $birthDate;
        $_SESSION['college'] = $college;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enterdOTP'])) {
        // Check if OTP matches the session
        if (isset($_SESSION['otp']) && $_POST['enterdOTP'] == $_SESSION['otp']) {

            if ($userType == 'Organizer Signup') {
                require_once 'functions/o.php';
            }

            if ($userType == 'Attendee Signup') {
                require_once 'functions/a.php';
            }
        } else {
            // Set error message if OTP is incorrect
            $errorMessage = 'Invalid OTP. Please try again.';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Set error message if no OTP is submitted
        $errorMessage = 'Please enter the OTP.';
    }
    ?>
</head>

<body>
    <?php include_once 'include/navigationBar.php'; ?>

    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h3 class="login-heading mb-4">OTP Verification</h3>
                                <?php if (!empty($errorMessage))
                                    echo "<p style='color:red;'>$errorMessage</p>"; ?>
                                <!-- OTP Verification Form -->
                                <form name="verifyOTP" action="" method="POST">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="enterdOTP" name="enterdOTP"
                                            placeholder="Enter OTP" required>
                                        <label for="enterdOTP">Enter OTP</label>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2"
                                            type="submit">Verify</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"
                style="background-image: url('<?php echo $backgroundPath; ?>');"></div>
        </div>
    </div>
    <?php include_once 'include/footer.php'; ?>
</body>

</html>