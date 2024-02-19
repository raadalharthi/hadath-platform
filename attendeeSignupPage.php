<!DOCTYPE html>

<html lang="en">

<head>
  <?php
  $title = "Sign Up";
  include_once 'include/metaData.php';
  ?>
</head>

<body>
  <?php
  include_once 'include/navigationBar.php';

  if (empty($_SESSION['organizerID']) and empty($_SESSION['attendeeID'])) { ?>



    <!-- setting the main div for the form-->
    <div class="container2">
      <!-- setting up the inputs for the login page with placeholder -->
      <input type="checkbox" id="check" />
      <!---Login page--->
    <div class="login form">
      <header>Sign Up</header>
      <form name="signup" action="authentication.php" onsubmit="return validation()" method="POST">
        <input type="text" id="email" name="email" placeholder="Email Address" />
        <input type="password" id="password" name="password" placeholder="Password" />
        <input type="hidden" id="type" name="type" value="<?php echo $title ?>">
        <input type="submit" class="button" value="Sign Up" id="btn" />
      </form>

      <script>
        // validation for empty field   
        function validation() {
          var email = document.signup.email.value;
          var password = document.signup.password.value;
          if (email.length == "" && password.length == "") {
            alert("User Name and Password fields are empty");
            return false;
          }
          else {
            if (email.length == "") {
              alert("User Name is empty");
              return false;
            }
            if (password.length == "") {
              alert("Password field is empty");
              return false;
            }
          }
        }  
      </script>

      <!-- switching to sign up form-->
        <div class="signup">
          <span class="signup">Already have an account
            <label><a href="loginPage.php">Login</a></label>
          </span>
        </div>
        <br>
      </div>
    </div>
    </div>
    <?php
  } else {
    ?>

    <div style="text-align: center; margin-top:25%;">
      <h1>You already Logged in as
        <?php if (empty($_SESSION['organizerID'])) {
          echo "customer";
        } else {
          echo "Admin";
        } ?>
      </h1>
      <br>
      <form action="signOut.php" method="POST"><button class="btn btn-outline-success" type="submit">Sign Out</button>
      </form>
    </div>

    <?php
  }
  include_once 'include/footer.php';
  ?>
</body>

</html>