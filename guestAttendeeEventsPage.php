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

        $sql = "SELECT events.*, organizer.organizerName 
                FROM events 
                INNER JOIN organizer ON events.organizerID = organizer.organizerID";
        $result = $conn->query($sql);

        // Check if the query was successful
        if (!$result) {
            // Debugging message for query failure
            echo "<p>Query Error: " . $conn->error . "</p>";
        } else if ($result->num_rows > 0) {
            echo '<div class="row">'; // Start the first row

            $counter = 0; // Initialize a card counter
            while ($row = $result->fetch_assoc()) {
                if ($row['numberOfRegistered'] >= $row['capacity']) {
                    // Skip events where capacity is met or exceeded
                    continue;
                }

                // Process event image URL
                $firstDotPos = strpos($row['eventImage'], '.');
                if ($firstDotPos !== false) {
                    $newEventImage = substr_replace($row['eventImage'], '', $firstDotPos, 1);
                } else {
                    $newEventImage = $row['eventImage'];
                }
                ?>

                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="<?php echo htmlspecialchars($newEventImage); ?>" alt="">
                        <div class="card-body">
                            <h4 class="card-title">
                                <?php echo htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8'); ?>
                            </h4>
                            <p class="card-text" style="text-align: justify;">
                                <?php echo htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                            <ul class="list-unstyled">
                                <li><strong>Type:</strong> <?php echo htmlspecialchars($row['eventType'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Date:</strong> <?php echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Time:</strong> <?php echo htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Location:</strong> <?php echo htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Organizer:</strong> <?php echo htmlspecialchars($row['organizerName'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Registration Deadline:</strong> <?php echo htmlspecialchars($row['registrationDeadline'], ENT_QUOTES, 'UTF-8'); ?></li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <?php
                            if (isset($_SESSION['attendeeID'])) { ?>
                                <form action="functions/registerInEvent.php" method="POST">
                                    <input type="hidden" name="attendeeID" value="<?php echo $_SESSION['attendeeID'][0]; ?>">
                                    <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
                                    <button class="btn btn-primary btn-lg w-75 text-uppercase fw-bold mb-2" type="submit" value="register" id="btn">Register Me</button>
                                </form>
                            <?php } else { ?>
                                <form action="guestLoginPage.php">
                                    <button class="btn btn-primary btn-lg w-75 text-uppercase fw-bold mb-2" type="submit" value="register" id="btn">Register Me</button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php
                $counter++;
                if ($counter % 2 == 0 && $result->num_rows > $counter) {
                    echo '</div><div class="row">'; // Create a new row every two cards
                }
            }

            if ($counter % 2 != 0) {
                echo '</div>'; // Close the last row if an odd number of cards
            }
        } else {
            echo "<p>No events found.</p>";
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
