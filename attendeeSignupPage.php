<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = "Attendee Signup";
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
                  <h3 class="login-heading mb-4">Sign Up as Attendee</h3>
                  <!-- Signup Form -->
                  <form name="signup" action="functions/attendeeValidation.php" onsubmit="return validation()"
                    method="POST" enctype="multipart/form-data">

                    <!-- Image Upload Section -->
                    <div class="form-floating mb-3">
                      <input type="file" class="form-control" id="image" name="image" accept="image/*">
                      <label for="image">Upload Image</label>
                    </div>

                    <input type="hidden" id="userType" name="userType" value="<?php echo $title ?>">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                      <label for="firstName">First Name<span style="color: red;"> *</span></label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                      <label for="lastName">Last Name<span style="color: red;"> *</span></label>
                    </div>
                    <div class="form-floating mb-3">
                      <select class="form-select" id="gender" name="gender">
                        <option selected>Select your gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                      </select>
                      <label for="gender">Gender<span style="color: red;"> *</span></label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="date" class="form-control" id="birthDate" name="birthDate">
                      <label for="birthDate">Birth Date<span style="color: red;"> *</span></label>
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
                      <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                      <label for="email">Email address<span style="color: red;"> *</span></label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                      <label for="pass">Password<span style="color: red;"> *</span></label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                        placeholder="Re-enter Password">
                      <label for="confirmPassword">Re-enter Password<span style="color: red;"> *</span></label>
                    </div>
                    <div id="passwordStrength" class="password-strength mb-3">
                      <div id="passwordStrengthBar" class="strength-bar"></div>
                    </div>
                    <div id="passwordStrengthText" class="password-strength-text mb-3"></div>

                    <input type="hidden" id="userType" name="userType" value="<?php echo $title ?>">

                    <div class="d-grid">
                      <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit"
                        id="btn">Sign Up</button>
                    </div>

                    <div class="text-center">
                      <p style="display: inline;">You already have an account</p>
                      <a class="small" href="guestLoginPage.php">Login</a>
                      <br>
                      <p style="display: inline;">Want to organize your events?</p>
                      <a class="small" href="organizerSignupPage.php">Sign up as organizer now</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"
          style="background-image: url(./assets/attendeeSignupPageBackground.jpg);"></div>
      </div>
    </div>

    <script>
      function validation() {
        var firstName = document.signup.firstName.value;
        var lastName = document.signup.lastName.value;
        var gender = document.signup.gender.value;
        var birthDate = document.signup.birthDate.value;
        var college = document.signup.college.value;
        var email = document.signup.email.value;
        var pass = document.signup.pass.value;
        var confirmPassword = document.signup.confirmPassword.value;
        var attendeeNamePattern = /^[A-Za-z]+$/;
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/;

        if (firstName.trim() === "") {
          alert("First name not provided. Please enter your first name.");
          return false;
        }

        if (!attendeeNamePattern.test(firstName)) {
          alert("First name can only contain English letters. Please enter a valid first name.");
          return false;
        }

        if (lastName.trim() === "") {
          alert("Last name not provided. Please enter your last name.");
          return false;
        }

        if (!attendeeNamePattern.test(lastName)) {
          alert("Last name can only contain English letters. Please enter a valid last name.");
          return false;
        }

        if (gender === "Select your gender" || gender === "") {
          alert("Please select your gender.");
          return false;
        }

        if (birthDate.trim() === "") {
          alert("Birth date not provided. Please enter your birth date.");
          return false;
        }

        // Check if the user is older than 10 years
        var birthDateObject = new Date(birthDate);
        var today = new Date();
        var age = today.getFullYear() - birthDateObject.getFullYear();
        var m = today.getMonth() - birthDateObject.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDateObject.getDate())) {
          age--;
        }

        if (age < 10) {
          alert("You must be older than 10 years to sign up.");
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

        if (password !== confirmPassword) {
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
    ?>
  </body>

  <?php
  }
  ?>

</html>