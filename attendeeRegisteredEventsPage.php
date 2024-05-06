<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Registered Events";
    include_once 'include/metaData.php';

    if (empty($_SESSION['attendeeID'])) {
        require_once 'include\accessDenied.php';
    } else { ?>
    </head>

    <body>
        <?php
        include_once 'include/navigationBar.php';
        ?>

        <!-- Page Content -->
        <div class="container">

            <!-- Page Heading -->
            <h1 class="my-4">Registered Events</h1>


            <?php
            require_once 'include/connection.php';

            $sqlRegistrations = "SELECT eventID FROM registrations WHERE attendeeID = {$_SESSION['attendeeID'][0]}";
            $resultRegistrations = $conn->query($sqlRegistrations);

            $sqlEvents = "SELECT * FROM events WHERE eventID IN (" . $sqlRegistrations . ")";
            $resultEvents = $conn->query($sqlEvents);

            if ($resultEvents->num_rows > 0) {
                echo '<div class="row">'; // Start the first row
        
                // Counter to track number of cards
                $counter = 0;

                // Output data of each row
                while ($row = $resultEvents->fetch_assoc()) {
                    ?>

                    <?php
                    // Assuming $row['eventImage'] contains the path like '../assets/uploadedImages/file_17150193478616.jpg'
                    $firstDotPos = strpos($row['eventImage'], '.'); // Find position of first '.'
        
                    if ($firstDotPos !== false) {
                        $newEventImage = substr_replace($row['eventImage'], '', $firstDotPos, 1); // Remove the first '.'
                    } else {
                        $newEventImage = $row['eventImage']; // If no '.', use the original path
                    }
                    ?>

                    <div class="col-6 mb-4">
                        <div class="card h-100">
                            <img class="card-img-top" src="<?php echo $newEventImage; ?>"
                                alt="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?php echo htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8'); ?>
                                </h4>
                                <p class="card-text" style="text-align: justify;">
                                    <?php echo htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8'); ?>
                                </p>
                            </div>
                            <?php
                            // Assuming $row is fetched from your database and contains 'date' and 'time' columns
                            $eventDate = $row['date'];
                            $eventTime = $row['time'];

                            // Combine the date and time into one string and convert it to a DateTime object
                            $eventDateTimeString = $eventDate . ' ' . $eventTime;
                            $eventDateTime = new DateTime($eventDateTimeString);
                            $now = new DateTime();

                            // Check if the event date and time has passed compared to the current time
                            if ($eventDateTime < $now) {
                                // Event has passed; show the form with download and rating buttons
                                ?>

                                <form action="functions/downloadCertificate.php" method="POST" id="eventForm"
                                    style="display: flex; justify-content: center; gap: 10px; padding: 0 20px;">
                                    <input type="hidden" value="<?php echo $row['eventID']; ?>" name="eventID" id="eventID" />
                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit"
                                        value="downloadCertificate" name="action"
                                        style="flex: 1; background: linear-gradient(to right, #6a11cb, #2575fc); border: none; color: white;">Download
                                        Certificate</button>
                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="button"
                                        data-bs-toggle="modal" data-bs-target="#rate"
                                        style="flex: 1; background: linear-gradient(to right, #06beb6, #48b1bf); border: none; color: white;">Rate</button>
                                </form>

                                <div class="modal fade" id="rate" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">Rating
                                                    <?php echo htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8'); ?>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="functions/ratingFunction.php" method="POST" id="ratingForm">
                                                    <div class="star-rating" style="display: flex; justify-content: center;">
                                                        <label for="ratingValue">Rate the Event:</label>
                                                        <select id="ratingValue" name="ratingValue">
                                                            <option value="1">1 out of 10</option>
                                                            <option value="2">2 out of 10</option>
                                                            <option value="3">3 out of 10</option>
                                                            <option value="4">4 out of 10</option>
                                                            <option value="5">5 out of 10</option>
                                                            <option value="6">6 out of 10</option>
                                                            <option value="7">7 out of 10</option>
                                                            <option value="8">8 out of 10</option>
                                                            <option value="9">9 out of 10</option>
                                                            <option value="10">10 out of 10</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <input type="hidden" name="attendeeID"
                                                        value="<?php echo $_SESSION['attendeeID']; ?>" />
                                                    <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>" />
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            } else {
                                // Event has not yet passed; show the disabled button
                                ?>
                                <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="button" disabled>Not
                                    attended yet</button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    $counter++; // Increment the counter
        
                    if ($counter % 2 == 0 && $resultEvents->num_rows > $counter) {
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

    <?php
    }
    ?>

</html>