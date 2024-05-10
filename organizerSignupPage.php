<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Organizer Signup";
    include_once 'include/metaData.php';

    if (!empty($_SESSION['organizerID']) || !empty($_SESSION['attendeeID'])) {
        require_once 'include\accessDenied.php';
    } else { ?>
    </head>

    <body>
        <?php
        include_once 'include/navigationBar.php';
        ?>
        <div class="container-fluid ps-md-0">
            <div class="row g-0">
                <div class="col-md-8 col-lg-6">
                    <div class="login d-flex align-items-center py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9 col-lg-8 mx-auto">
                                    <h3 class="login-heading mb-4">Organizer Sign Up</h3>
                                    <!-- Signup Form -->
                                    <form name="signup" action="functions/organizerValidation.php"
                                        onsubmit="return validation()" method="POST" enctype="multipart/form-data">

                                        <!-- Image Upload Section -->
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*">
                                            <label for="image">Upload Image</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="organizerName" name="organizerName"
                                                placeholder="Organizer Name">
                                            <label for="organizerName">Organizer Name<span style="color: red;">
                                                    *</span></label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="college" name="college">
                                                <option selected>Select College</option>
                                                <option value="CCSIT">College of Computer Science and Information Technology
                                                </option>
                                                <option value="CBA">College of Business administration</option>
                                                <option value="COE">College of Engineering</option>
                                                <option value="ARCH">College of Architecture and Planning</option>
                                                <option value="MED">College of Medicine</option>
                                            </select>
                                            <label for="college">College<span style="color: red;"> *</span></label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="name@example.com">
                                            <label for="email">Email address<span style="color: red;"> *</span></label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password">
                                            <label for="password">Password<span style="color: red;"> *</span></label>
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
                                                type="submit" id="btn">Sign Up</button>
                                        </div>

                                        <div class="text-center">
                                            <p style="display: inline;">You already have an account</p>
                                            <a class="small" href="guestLoginPage.php">Login</a>
                                            <br>
                                            <p style="display: inline;">Want to attend an event?</p>
                                            <a class="small" href="attendeeSignupPage.php">Sign up as attendee now</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"
                    style="background-image: url(./assets/organizerSignupPageBackground.jpg);"></div>
            </div>
        </div>

        <script>
            function validation() {
                var organizerName = document.signup.organizerName.value;
                var college = document.signup.college.value;
                var email = document.signup.email.value;
                var password = document.signup.password.value;
                var confirmPassword = document.signup.confirmPassword.value;
                var organizerNamePattern = /^[A-Za-z ]+$/;
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/;

                if (organizerName.trim() === "") {
                    alert("Organizer name not provided. Please enter the organizer name.");
                    return false;
                }

                if (!organizerNamePattern.test(organizerName)) {
                    alert("Organizer name can only contain English letters. Please enter a valid name.");
                    return false;
                }

                if (college === "Select College" || college === "") {
                    alert("Please select a college.");
                    return false;
                }

                if (email.trim() === "") {
                    alert("Email address not provided. Please enter your email address.");
                    return false;
                }

                if (!emailPattern.test(email)) {
                    alert("Please enter a valid email address.");
                    return false;
                }

                if (password.trim() === "") {
                    alert("Password not provided. Please enter your password.");
                    return false;
                }

                if (!passwordPattern.test(password)) {
                    alert("Password must be at least 8 characters long and include uppercase and lowercase letters, a number, and a special character.");
                    return false;
                }

                if (confirmPassword.trim() === "") {
                    alert("Please re-enter your password.");
                    return false;
                }

                if (password !== confirmPassword) {
                    alert("Passwords do not match.");
                    return false;
                }

                return true;
            }

            document.getElementById("password").addEventListener("input", function () {
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
        ?>
    </body>

    <?php
    }
    ?>

</html>