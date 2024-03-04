<!DOCTYPE html>
<html lang="en">
<head>
    <title>OTP Verification</title>
    <?php
    include_once 'include/metaData.php';
    if (isset($_SESSION['error_message'])) {
        $errorMessage = $_SESSION['error_message'];
        unset($_SESSION['error_message']); // Clear the error message after displaying
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
                                <?php if (!empty($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>
                                <!-- OTP Verification Form -->
                                <form name="verifyOTP" action="functions/authentication.php" method="POST">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                                        <label for="otp">Enter OTP</label>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Verify</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image" style="background-image: url('./assets/organizerSignupPageBackground.jpg');"></div>
        </div>
    </div>
    <?php include_once 'include/footer.php'; ?>
</body>
</html>
