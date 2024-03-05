<!DOCTYPE html>

<html lang="en">

<head>
    <?php
    $title = "Reset Password";
    include_once 'include/metaData.php';
    ?>
</head>

<body>
    <?php
    include_once 'include/navigationBar.php';

    if (empty($_SESSION['organizerID']) and empty($_SESSION['attendeeID'])) { ?>

        <div class="container-fluid ps-md-0">
            <div class="row g-0">
                <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"
                    style="background-image: url(./assets/guestLoginPageBackground.jpg);"></div>
                <div class="col-md-8 col-lg-6">
                    <div class="login d-flex align-items-center py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9 col-lg-8 mx-auto">
                                    <h3 class="login-heading mb-4">Please enter your email address</h3>

                                    <!-- Login Form -->
                                    <form name="login" action="functions/resetPasswordValidation.php" onsubmit="return validation()"
                                        method="POST">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="name@example.com">
                                            <label for="email">Email address</label>
                                        </div>

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
                var email = document.login.email.value;
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regular expression for email validation

                if (email.length == "") {
                    alert("Email address not provided. Please enter your email address.");
                    return false;
                } else if (!emailPattern.test(email)) { // Check if email matches the pattern
                    alert("Please enter a valid email address.");
                    return false;
                }
            }
        </script>

        <?php
    } else {
        ?>

        <div style="text-align: center; margin-top:25%;">
            <h1>You already Logged in as
                <?php if (empty($_SESSION['organizerID'])) {
                    echo "attendee";
                } else {
                    echo "organizer";
                } ?>
            </h1>
            <br>
            <form action="functions/signOut.php" method="POST"><button class="btn btn-outline-success" type="submit">Sign
                    Out</button>
            </form>
        </div>

        <?php
    }
    include_once 'include/footer.php';
    ?>
</body>

</html>