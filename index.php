<!DOCTYPE html>

  <html lang="en">
    <head>
      <!-- Tab Title-->
      <?php
        $title = "Home Page";
        include_once 'include/metaData.php';
      ?>
    </head>
    
  <body>
    <?php

      //Page Navigation Bar
      include_once 'include/navigationBar.php';

      if (empty($_SESSION['adminID']) == false){

        ?>
        <div style="text-align: center; margin-top:25%;">
        <h1>You not allowed to reach home page as admin please sign out first</h1>
        <br>
        <form action="signout.php" method="POST"><button class="btn btn-outline-success" type="submit">Sign out</button></form>
      </div>
    
      <?php
    } else {

      // Database Connection
      require 'include/connection.php';

      // Retrieve Data From Product Table
      $sql = "SELECT * FROM product";
      $result = mysqli_query($conn, $sql);

      if (isset($_SESSION['statusIndex'])) {
        ?><script>window.alert("<?php echo $_SESSION['statusIndex'];?>");</script><?php
          unset ($_SESSION['statusIndex']);
        }
      ?>

      <?php
      // Show Products in Home Page through while statement
      while ($row = mysqli_fetch_assoc($result)) {

        // Store Data php variables
        $id = $row['ID'];
        $name = $row['name'];
        $picture = $row['picture'];
        $price = $row['price'];
        $category = $row['category'];


        ?>
        
        <!-- Product Card -->
        <div class="container py-5">
          <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">

              <!-- Product ID -->
              <div class="card" style="border-radius: 15px" id="<?php echo $id; ?>">

                <!-- Product Picture -->
                <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
                  <img
                    src="assets/usersPicture/<?php echo $picture; ?>"
                    style="border-top-left-radius: 15px; border-top-right-radius: 15px;"
                    class="img-fluid"
                    alt="Picture of <?php echo $name; ?>"
                  />
                </div>

                <!-- Product Name & Category -->
                <div class="card-body pb-0">
                  <div class="d-flex justify-content-between">
                    <p class="cardPhoneName"><?php echo $name; ?></p>
                    <p class="cardCategory"><?php echo $category; ?></p>
                  </div>
                </div>

                <hr class="my-0" />

                <!-- Product Price -->
                <div class="card-body pb-0">
                  <p class="price">$<?php echo $price; ?></p>
                </div>

                <hr class="my-0" />


                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center pb-2 mb-1">

                    <!-- More Details Button -->
                    <form action="productDetails.php" method="POST">
                      <!-- Retrieve ID to send it to productDetails.php -->
                      <input type="hidden" name= "id" value="<?php echo $id; ?>">

                      <button class="btn btn-outline-success" type="submit">More Details</button>
                    </form>

                    <form  method="post" action="addCart.php">

                      <!-- Retrieve ID to send it to addCart.php -->
                      <input type="hidden" id="ID" name="ID" value="<?php echo $id ?>">
                      <input type="hidden" id="quantity" name="quantity" value="1">
                      <button class="btn btn-outline-success" type="submit">Add to cart</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php
        // End of while statement
      }
      ?>

    <?php
    }
      // Page footer
      include_once 'include/footer.php';
    ?>
  </body>
</html>