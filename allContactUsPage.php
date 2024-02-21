<!DOCTYPE html>

<html lang="en">
  <head>
    <?php
      $title = "Contact Us";
      include_once 'include/metaData.php';
    ?>
  </head>
  <body>
    <?php
      include_once 'include/navigationBar.php';

      if (empty($_SESSION['organizerID']) == false){

        ?>
        <div style="text-align: center; margin-top:25%;">
        <h1>You not allowed to reach contact us as admin please sign out first</h1>
        <br>
        <form action="functions/signOut.php" method="POST"><button class="btn btn-outline-success" type="submit">Sign out</button></form>
      </div>
    
      <?php
    } else {
      ?>



<div class="container-fluid px-5 my-5">
  <div class="row justify-content-center">
    <div class="col-xl-10">
      <div class="card border-0 rounded-3 shadow-lg overflow-hidden">
        <div class="card-body p-0">
          <div class="row g-0">
            <div class="col-sm-6">
              <!-- Header and Text for Technical Support -->
              <div class="p-4">
                <h3 class="fw-light">E-services Issues Technical Support</h3>
                <p>For Employees, Faculty Members and Students</p>
                <p>Tel: 0133331111</p>
              </div>
              <!-- Google Maps iframe -->
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d228791.7317672436!2d49.992540180581884!3d26.36304025059799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ef85c961edaf%3A0x7b2db98f2941c78c!2sImam%20Abdulrahman%20Bin%20Faisal%20University!5e0!3m2!1sen!2ssa!4v1672229820933!5m2!1sen!2ssa" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            
            <div class="col-sm-6 p-4">
              <!-- Contact Form Content Here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



    <?php
    }
      include_once 'include/footer.php';
    ?>
    </form>
  </body>
</html>
