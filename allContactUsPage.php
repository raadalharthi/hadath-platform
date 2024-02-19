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
        <form action="signout.php" method="POST"><button class="btn btn-outline-success" type="submit">Sign out</button></form>
      </div>
    
      <?php
    } else {
      ?>



    <div class="container contact-form">
      <div class="contact-image">
        <img src="assets\contactUs\email.png" alt="Email Icon" />
      </div>
        <h3>Send Us a Message</h3>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input
                type="text"
                name="txtName"
                class="form-control"
                placeholder="Your Name *"
                value=""
                required
              />
            </div>
            <br />
            <div class="form-group">
              <input
                type="text"
                name="txtEmail"
                class="form-control"
                placeholder="Your Email *"
                value=""
                required
              />
            </div>
            <br />
            <div class="form-group">
              <input
                type="text"
                name="txtPhone"
                class="form-control"
                placeholder="+966"
                value=""
                required
              />
            </div>
            <br />
            <div class="form-group">
              <input
                type="submit"
                name="btnSubmit"
                class="btnContact"
                value="Send Message"
                required
              />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <textarea
                name="txtMsg"
                class="form-control"
                placeholder="Your Message *"
                style="width: 100%; height: 150px"
              ></textarea>

              <br />
              <br />



              <div class="contact-formmap">
                <h3>lociton</h3>
                <p>
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d228791.7317672436!2d49.992540180581884!3d26.36304025059799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49ef85c961edaf%3A0x7b2db98f2941c78c!2sImam%20Abdulrahman%20Bin%20Faisal%20University!5e0!3m2!1sen!2ssa!4v1672229820933!5m2!1sen!2ssa"
                    width="400"
                    height="300"
                    style="border: 0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                  ></iframe>
                </p>
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
