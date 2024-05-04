<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Events Page";
    include_once 'include/metaData.php';

    if (!empty($_SESSION['organizerID'])) {
        require_once 'include/accessDenied.php';
    }
    ?>
</head>

<body>
    <?php
    include_once 'include/navigationBar.php';
    ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <h1 class="my-4">Events</h1>

        <?php
        require_once 'include/connection.php';

        $sql = "SELECT * FROM events";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="row">'; // Start the first row
        
            // Counter to track number of cards
            $counter = 0;

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-6 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="<?php echo $row['eventImage']; ?>"
                            alt="">
                        <div class="card-body">
                            <h4 class="card-title">
                                <?php echo htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8'); ?>
                            </h4>
                            <p class="card-text" style="text-align: justify;">
                                <?php echo htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                        </div>
                        <?php
                        if (isset($_SESSION['attendeeID'])) { ?>
                            <form action="functions/registerInEvent.php" method="POST">
                                <input type="hidden" name="attendeeID" value="<?php echo $_SESSION['attendeeID'][0]; ?>">
                                <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
                            <?php } else { ?>
                                <form action="guestLoginPage.php">
                                <?php }
                        ?>
                                <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit"
                                    value="register" id="btn">register me</button>
                            </form>
                    </div>
                </div>
                <?php
                $counter++; // Increment the counter
        
                if ($counter % 2 == 0 && $result->num_rows > $counter) {
                    echo '</div><div class="row">'; // Close the current row and open a new one if more cards are left to display
                }
            }

            if ($counter % 2 != 0) {
                echo '</div>'; // Close the last row if an odd number of cards
            }
        } else {
            echo "0 results";
        }
        ?>

    </div>
    <!-- /.container -->

    <?php
    include_once 'include/footer.php';
    $conn->close();
    ?>

</body>

</html>