<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Registered Events";
    include_once 'include/metaData.php';

    if (empty($_SESSION['attendeeID'])) {
        require_once 'include/accessDenied.php';
    } else { ?>
</head>

<body>
    <?php
    include_once 'include/navigationBar.php';
    ?>

    <!-- Page Content -->
    <div class="container">
        <!-- Page Heading -->
        <?php
        require_once 'include/connection.php';

        // Mapping college acronyms to full names
        $collegeNames = [
            'CCSIT' => 'College of Computer Science and Information Technology',
            'CBA' => 'College of Business Administration',
            'COE' => 'College of Engineering',
            'ARCH' => 'College of Architecture',
            'MED' => 'College of Medicine'
        ];

        // Retrieve the selected college from the filter
        $collegeFilter = isset($_GET['college']) ? $_GET['college'] : '';

        // Translate the full college name back to the acronym
        $collegeAcronymFilter = array_search($collegeFilter, $collegeNames);

        // Get the college filter options
        $sqlColleges = "SELECT DISTINCT organizer.college
                        FROM organizer
                        INNER JOIN events ON organizer.organizerID = events.organizerID
                        WHERE events.date >= NOW()";
        $resultColleges = $conn->query($sqlColleges);
        $colleges = [];

        if ($resultColleges) {
            while ($rowCollege = $resultColleges->fetch_assoc()) {
                $colleges[] = $rowCollege['college'];
            }
        }

        // SQL Query for events
        $sqlRegistrations = "SELECT eventID FROM registrations WHERE attendeeID = {$_SESSION['attendeeID'][0]}";
        $sqlEvents = "SELECT events.*, organizer.organizerName, organizer.college
                      FROM events
                      INNER JOIN organizer ON events.organizerID = organizer.organizerID
                      WHERE eventID IN (" . $sqlRegistrations . ")";

        if ($collegeAcronymFilter !== false) {
            $sqlEvents .= " AND organizer.college = '" . $conn->real_escape_string($collegeAcronymFilter) . "'";
        }

        $resultEvents = $conn->query($sqlEvents);
        $eventsCount = $resultEvents ? $resultEvents->num_rows : 0;

        ?>

        <div class="row mt-4">
            <div class="col-md-9">
                <h1 class="my-4">Registered Events <small>(Showing <?php echo $eventsCount; ?>)</small></h1>
            </div>
            <div class="col-md-3 text-right">
                <form method="GET" action="">
                    <label for="collegeFilter">College Filter:</label>
                    <select id="collegeFilter" name="college" class="form-control" onchange="this.form.submit()">
                        <option value="">Select College</option>
                        <?php
                        foreach ($colleges as $collegeAcronym) {
                            $fullName = $collegeNames[$collegeAcronym];
                            $selected = ($fullName === $collegeFilter) ? 'selected' : '';
                            echo "<option value='{$fullName}' {$selected}>{$fullName}</option>";
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>

        <?php
        // Check if the query was successful
        if (!$resultEvents) {
            echo "<p>Query Error: " . $conn->error . "</p>";
        } else if ($resultEvents->num_rows > 0) {
            echo '<div class="row">'; // Start the first row

            $counter = 0; // Initialize a card counter

            // Output data of each row
            while ($row = $resultEvents->fetch_assoc()) {
                // Assuming $row['eventImage'] contains the path like '../assets/uploadedImages/file_17150193478616.jpg'
                $firstDotPos = strpos($row['eventImage'], '.'); // Find position of first '.'

                if ($firstDotPos !== false) {
                    $newEventImage = substr_replace($row['eventImage'], '', $firstDotPos, 1); // Remove the first '.'
                } else {
                    $newEventImage = $row['eventImage']; // If no '.', use the original path
                }

                // Determine attendance status
                $eventDate = $row['date'];
                $eventTime = $row['time'];
                $eventDateTimeString = $eventDate . ' ' . $eventTime;
                $eventDateTime = new DateTime($eventDateTimeString);
                $now = new DateTime();

                $attendanceStatus = ($eventDateTime < $now) ? 'Attended' : 'Absent';

                ?>

                <div class="col-6 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="<?php echo htmlspecialchars($newEventImage); ?>"
                             alt="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>">
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
                                <li><strong>College:</strong> <?php echo htmlspecialchars($collegeNames[$row['college']], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Registration Deadline:</strong> <?php echo htmlspecialchars($row['registrationDeadline'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Attendance Status:</strong> <?php echo $attendanceStatus; ?></li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <?php if ($attendanceStatus === 'Absent') { ?>
                                <form action="functions/unregister.php" method="POST" id="eventForm"
                                      style="display: flex; justify-content: center; gap: 10px; padding: 0 20px;">
                                    <input type="hidden" value="<?php echo $row['eventID']; ?>" name="eventID" id="eventID"/>
                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit"
                                            value="unroll" name="action"
                                            style="flex: 1; background: linear-gradient(to right, #ff416c, #ff4b2b); border: none; color: white;">Unroll from Event
                                    </button>
                                </form>
                            <?php } else { ?>
                                <form action="functions/downloadCertificate.php" method="POST" id="eventForm"
                                      style="display: flex; justify-content: center; gap: 10px; padding: 0 20px;">
                                    <input type="hidden" value="<?php echo $row['eventID']; ?>" name="eventID" id="eventID"/>
                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit"
                                            value="downloadCertificate" name="action"
                                            style="flex: 1; background: linear-gradient(to right, #6a11cb, #2575fc); border: none; color: white;">Download Certificate
                                    </button>
                                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="button"
                                            data-bs-toggle="modal" data-bs-target="#rate"
                                            style="flex: 1; background: linear-gradient(to right, #06beb6, #48b1bf); border: none; color: white;">Rate
                                    </button>
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
                            <?php } ?>
                        </div>
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
