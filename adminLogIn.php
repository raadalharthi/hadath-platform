<!DOCTYPE html>

<html lang="en">
  <head>
    <?php
      $title = "Admin Sign in";
      include_once 'include/metaHead.php';
    ?>
  </head>
  <body>
    <?php
      include_once 'include/navBar.php';

      if (empty($_SESSION['adminID']) and empty($_SESSION['userID']) ) { ?>

    <!-- setting the main div for the form-->
    <div class="container2">
      <!-- setting up the inputs for the login page with placeholder -->
      <input type="checkbox" id="check" />
      <!---Login page--->
      <div class="login form">
        <header>Login</header>
        <form  name="login" action = "authentication.php" onsubmit = "return validation()" method = "POST">
          <input type="text" id ="email" name  = "email" placeholder="Email Address" />
          <input type="password" id ="password" name  = "password" placeholder="Password" />
          <input type="hidden" id ="type" name = "type" value="<?php echo $title ?>">
          <input type="submit" class="button" id = "btn" value="Login" />
        </form>

        <!-- switching to sign up form-->
      </div>
    </div>

    <script>  
            function validation()  
            {  
                var email=document.login.email.value;  
                var password=document.login.password.value;  
                if(email.length=="" && password.length=="") {  
                    alert("User Name and Password fields are empty");  
                    return false;  
                }  
                else  
                {  
                    if(email.length=="") {  
                        alert("User Name is empty");  
                        return false;  
                    }   
                    if (password.length=="") {  
                    alert("Password field is empty");  
                    return false;  
                    }  
                }                             
            }  
        </script>  


    <?php
      }

    else  { 
      ?>

    <div style="text-align: center; margin-top:25%;">
      <h1>You alreday signed in as <?php if (empty($_SESSION['adminID'])) {echo "customer";} else {echo "Admin";}?></h1>
      <br>
      <form action="signout.php" method="POST"><button class="btn btn-outline-success" type="submit">Sign Out</button></form>
    </div>

    <?php
    }
      include_once 'include/footer.php';
    ?>
  </body>
</html>
