<!DOCTYPE html>

<html lang="en">

<head>
    <?php
    $title = "Confirm New Password";
    include_once 'include/metaData.php';

    if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER']) || !empty($_SESSION['organizerID']) || !empty($_SESSION['attendeeID'])) {
        require_once 'include\accessDenied.php';
    } else {
        ?>
</head>

<body>
    <?php
    include_once 'include/navigationBar.php';
    ?>

        <div class="container-fluid ps-md-0">
            <div class="row g-0">
                <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"
                    style="background-image: url(./assets/guestLoginPageBackground.jpg);"></div>
                <div class="col-md-8 col-lg-6">
                    <div class="login d-flex align-items-center py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9 col-lg-8 mx-auto">
                                    <h3 class="login-heading mb-4">Please enter your new password</h3>

                                    <form name="login" action="functions/resetPassword.php" onsubmit="return validation()"
                                        method="POST">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="pass" name="pass"
                                                placeholder="Password">
                                            <label for="pass">Password<span style="color: red;"> *</span></label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="confirmPassword"
                                                name="confirmPassword" placeholder="Re-enter Password">
                                            <label for="confirmPassword">Re-enter Password<span style="color: red;">
                                                    *</span></label>
                                        </div>
                                        <div id="passwordStrength" class="password-strength mb-3">
                                            <div id="passwordStrengthBar" class="strength-bar"></div>
                                        </div>
                                        <div id="passwordStrengthText" class="password-strength-text mb-3"></div>

                                        <input type="hidden" id="userType" name="userType" value="<?php echo $title ?>">

                                        <div class="d-grid">
                                            <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2"
                                                type="submit" value="resetPassword" id="btn">Reset Password</button>
                                            <div class="text-center">
                                                <p style="display: inline;">Want to go back?</p>
                                                <a class="small" href="guestLoginPage.php">Login</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function validation() {
                var pass = document.signup.pass.value;
                var confirmPassword = document.signup.confirmPassword.value;
                var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/;

                if (pass.trim() === "") {
                    alert("Password not provided. Please enter your password.");
                    return false;
                }

                if (!passwordPattern.test(pass)) {
                    alert("Password must be at least 8 characters long and include uppercase and lowercase letters, a number, and a special character.");
                    return false;
                }

                if (confirmPassword.trim() === "") {
                    alert("Please re-enter your password.");
                    return false;
                }

                if (pass !== confirmPassword) {
                    alert("Passwords do not match.");
                    return false;
                }
                return true;
            }

            document.getElementById("pass").addEventListener("input", function () {
                var passwordValue = this.value;
                var strengthBar = document.getElementById("passwordStrengthBar");
                var strengthText = document.getElementById("passwordStrengthText");
                var strength = 0;
                if (passwordValue.length >= 8) strength += 1;
                if (passwordValue.match(/[a-z]+/)) strength += 1;
                if (passwordValue.match(/[A-Z]+/)) strength += 1;
                if (passwordValue.match(/[0-9]+/)) strength += 1;
                if (passwordValue.match(/[^a-zA-Z0-9]+/)) strength += 1;

                switch (strength) {
                    case 0:
                        strengthBar.style.width = "0%";
                        strengthText.textContent = "";
                        break;
                    case 1:
                    case 2:
                        strengthBar.style.width = "50%";
                        strengthBar.className = "strength-bar weak";
                        strengthText.textContent = "Weak";
                        break;
                    case 3:
                    case 4:
                        strengthBar.style.width = "75%";
                        strengthBar.className = "strength-bar moderate";
                        strengthText.textContent = "Moderate";
                        break;
                    case 5:
                        strengthBar.style.width = "100%";
                        strengthBar.className = "strength-bar strong";
                        strengthText.textContent = "Strong";
                        break;
                }
            });
        </script>

        <?php
        include_once 'include/footer.php';

    }
    ?>
</body>

</html>