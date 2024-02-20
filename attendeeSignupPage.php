<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = "Attendee Signup";
  include_once 'include/metaData.php';
  ?>
</head>

<body>
  <?php
  include_once 'include/navigationBar.php';

  if (empty($_SESSION['organizerID']) and empty($_SESSION['attendeeID'])) { ?>

    <div class="container-fluid ps-md-0">
      <div class="row g-0">
        <div class="col-md-8 col-lg-6">
          <div class="login d-flex align-items-center py-5">
            <div class="container">
              <div class="row">
                <div class="col-md-9 col-lg-8 mx-auto">
                  <h3 class="login-heading mb-4">Sign Up</h3>
                  <!-- Signup Form -->
                  <form name="signup" action="functions/authentication.php" onsubmit="return validation()" method="POST">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                      <label for="firstName">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                      <label for="lastName">Last Name</label>
                    </div>
                    <div class="form-floating mb-3">
                      <select class="form-select" id="gender" name="gender">
                        <option selected>Select your gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                      </select>
                      <label for="gender">Gender</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                      <label for="email">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                      <label for="password">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                        placeholder="Re-enter Password">
                      <label for="confirmPassword">Re-enter Password</label>
                    </div>
                    <div id="passwordStrength" class="password-strength mb-3">
                      <div id="passwordStrengthBar" class="strength-bar"></div>
                    </div>
                    <div id="passwordStrengthText" class="password-strength-text mb-3"></div>
                    <ul class="password-rules">
                      <li>At least 8 characters long - the more, the better</li>
                      <li>At least one uppercase letter</li>
                      <li>At least one lowercase letter</li>
                      <li>At least one number</li>
                      <li>At least one special character (e.g., !@#$%^&*)</li>
                    </ul>

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
        var email = document.signup.email.value;
        var password = document.signup.password.value;
        var confirmPassword = document.signup.confirmPassword.value;
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}$/;

        if (firstName.trim() === "") {
          alert("First name not provided. Please enter your first name.");
          return false;
        }

        if (lastName.trim() === "") {
          alert("Last name not provided. Please enter your last name.");
          return false;
        }

        if (gender === "Select your gender" || gender === "") {
          alert("Please select your gender.");
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
  } else {
    ?>

    <div style="text-align: center; margin-top:25%;">
      <h1>You are already logged in as
        <?php if (empty($_SESSION['organizerID'])) {
          echo "attendee";
        } else {
          echo "organizer";
        } ?>
      </h1>
      <br>
      <form action="functions/signOut.php" method="POST"><button class="btn btn-outline-success" type="submit">Sign Out</button>
      </form>
    </div>

    <?php
  }
  include_once 'include/footer.php';
  ?>
</body>

</html>