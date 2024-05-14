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
        <?php
        require_once 'include/connection.php';

        // Mapping acronyms and full names
        $collegeAcronyms = [
            'College of Computer Science and Information Technology' => 'CCSIT',
            'College of Business Administration' => 'CBA',
            'College of Engineering' => 'COE',
            'College of Architecture' => 'ARCH',
            'College of Medicine' => 'MED'
        ];

        $collegeNames = [
            'CCSIT' => 'College of Computer Science and Information Technology',
            'CBA' => 'College of Business Administration',
            'COE' => 'College of Engineering',
            'ARCH' => 'College of Architecture',
            'MED' => 'College of Medicine'
        ];

        $eventTypeNames = [
            'ACD' => 'Academic Events',
            'ART' => 'Art Shows',
            'AWC' => 'Award Ceremonies',
            'CHE' => 'Charity Events',
            'COM' => 'Community Events',
            'CFS' => 'Conferences',
            'ENT' => 'Entertainment Events',
            'EXB' => 'Exhibitions',
            'HOL' => 'Holiday Celebrations',
            'NET' => 'Networking Events',
            'SEM' => 'Seminars',
            'SHO' => 'Showcase',
            'WRK' => 'Workshops'
        ];

        // Retrieve the selected college from the filter
        $collegeFilter = isset($_GET['college']) ? $_GET['college'] : '';

        // Translate the full college name back to the acronym
        $collegeAcronymFilter = array_search($collegeFilter, $collegeAcronyms);

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
        $sql = "SELECT events.*, organizer.organizerName, organizer.college 
                FROM events 
                INNER JOIN organizer ON events.organizerID = organizer.organizerID 
                WHERE events.date >= NOW()";

        if ($collegeAcronymFilter !== false) {
            $sql .= " AND organizer.college = '" . $conn->real_escape_string($collegeAcronymFilter) . "'";
        }

        $result = $conn->query($sql);
        $eventsCount = $result ? $result->num_rows : 0;
        ?>

        <div class="row mt-4">
            <div class="col-md-9">
                <h1 class="my-4">Events <small>(Showing <?php echo $eventsCount; ?>)</small></h1>
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
        if (!$result) {
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
                                <li><strong>Type:</strong> <?php echo htmlspecialchars($eventTypeNames[$row['eventType']], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Date:</strong> <?php echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Time:</strong> <?php echo htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Location:</strong> <?php echo htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>Organizer:</strong> <?php echo htmlspecialchars($row['organizerName'], ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><strong>College:</strong> <?php echo htmlspecialchars($collegeNames[$row['college']], ENT_QUOTES, 'UTF-8'); ?></li>
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
