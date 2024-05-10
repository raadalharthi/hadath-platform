<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "My Events";
    include_once 'include/metaData.php';

    if (empty($_SESSION['organizerID'])) {
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
            <h1 class="my-4">My Events</h1>

            <?php
            require_once 'include/connection.php';

            $sql = "SELECT * FROM events WHERE organizerID = {$_SESSION['organizerID'][0]}";
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
                            <?php
                            // Assuming $row['eventImage'] contains the path like '../assets/uploadedImages/file_17150193478616.jpg'
                            $firstDotPos = strpos($row['eventImage'], '.'); // Find position of first '.'
                
                            if ($firstDotPos !== false) {
                                $newEventImage = substr_replace($row['eventImage'], '', $firstDotPos, 1); // Remove the first '.'
                            } else {
                                $newEventImage = $row['eventImage']; // If no '.', use the original path
                            }
                            ?>
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

                            $attendanceRosterEndDateTime = clone $eventDateTime;
                            $attendanceRosterEndDateTime->modify('+1 day');

                            // Check if the event date and time has passed compared to the current time
                            if ($eventDateTime > $now) {
                                // Event has passed; show the form with download and rating buttons
                                ?>

                                <form action="organizerEditEventPage.php" method="POST" id="eventForm"
                                    style="display: flex; justify-content: center; gap: 10px; padding: 0 20px;">

                                    <input type="hidden" value="<?php echo $row['eventID']; ?>" name="eventID" id="eventID" />
                                    <input type="hidden" value="<?php echo $row['title']; ?>" name="title" id="title" />
                                    <input type="hidden" value="<?php echo $row['eventType']; ?>" name="eventType" id="eventType" />
                                    <input type="hidden" value="<?php echo $row['date']; ?>" name="date" id="date" />
                                    <input type="hidden" value="<?php echo $row['time']; ?>" name="time" id="time" />
                                    <input type="hidden" value="<?php echo $row['location']; ?>" name="location" id="location" />
                                    <input type="hidden" value="<?php echo $row['description']; ?>" name="description"
                                        id="description" />
                                    <input type="hidden" value="<?php echo $row['organizerID']; ?>" name="organizerID"
                                        id="organizerID" />
                                    <input type="hidden" value="<?php echo $row['capacity']; ?>" name="capacity" id="capacity" />
                                    <input type="hidden" value="<?php echo $row['numberOfRegistered']; ?>" name="numberOfRegistered"
                                        id="numberOfRegistered" />
                                    <input type="hidden" value="<?php echo $row['registrationDeadline']; ?>" name="registrationDeadline"
                                        id="registrationDeadline" />
                                    <input type="hidden" value="<?php echo $row['eventImage']; ?>" name="eventImage" id="eventImage" />

                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit"
                                        value="editEvent" name="action"
                                        style="flex: 1; background: linear-gradient(to right, #6a11cb, #2575fc); border: none; color: white;">Edit
                                        Event</button>

                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="button"
                                        data-bs-toggle="modal" data-bs-target="#deleteEvent"
                                        style="flex: 1; background: linear-gradient(to right, #06beb6, #48b1bf); border: none; color: white;">Delete
                                        Event</button>
                                </form>

                                <div class="modal fade" id="deleteEvent" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">Delete
                                                    "<?php echo htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8'); ?>"</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 style="text-align: center;">Are you sure you want to delete this event?</h5>
                                                <br>
                                                <form action="functions/deleteEvent.php" method="POST" id="deleteEvent">
                                                    <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>" />
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Delete Event</button>
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
                                <form action="organizerEventStatisticsPage.php" method="POST" id="eventForm"
                                    style="display: flex; justify-content: center; gap: 10px; padding: 0 20px;">

                                    <input type="hidden" value="<?php echo $row['eventID']; ?>" name="eventID" id="eventID" />

                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit"
                                        value="eventStatistics" name="action"
                                        style="flex: 1; background: linear-gradient(to right, #6a11cb, #2575fc); border: none; color: white;">Event
                                        Statistics</button>

                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="button"
                                        data-bs-toggle="modal" data-bs-target="#attendanceRoster"
                                        style="flex: 1; background: linear-gradient(to right, #06beb6, #48b1bf); border: none; color: white;"
                                        <?php if ($now < $attendanceRosterEndDateTime) {
                                            echo "disabled";
                                        } ?>>Attendance
                                        Roster</button>
                                </form>

                                <div class="modal fade" id="attendanceRoster" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">Attendance roster for
                                                    "<?php echo htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8'); ?>"</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="functions/attendanceRoster.php" method="POST" id="attendanceRoster">
                                                    <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>" />
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
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

    <?php
    }
    ?>

</html>