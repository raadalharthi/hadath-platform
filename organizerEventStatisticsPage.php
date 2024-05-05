<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Event Statistics";
    include_once 'include/metaData.php';

    if (empty($_SESSION['organizerID'])) {
        require_once 'include\accessDenied.php';
    } else { ?>
    </head>

    <body>
        <?php
        include_once 'include/navigationBar.php';
        ?>
        <?php
        if (!isset($_POST['eventID'][0])) {
            die('Event ID is missing or incorrect.');
        }

        $eventID = $_POST['eventID'][0];
        include_once 'include/connection.php';

        // Count the number of registered attendees
        $queryCountAttendees = "SELECT numberOfRegistered FROM events WHERE eventID = ?";
        if ($stmtCountAttendees = mysqli_prepare($conn, $queryCountAttendees)) {
            mysqli_stmt_bind_param($stmtCountAttendees, 'i', $eventID);
            if (mysqli_stmt_execute($stmtCountAttendees)) {
                mysqli_stmt_bind_result($stmtCountAttendees, $numberOfRegistered);
                mysqli_stmt_fetch($stmtCountAttendees);
                echo "Attendance = " . $numberOfRegistered;
            } else {
                die('Error executing the query: ' . mysqli_error($conn));
            }
            mysqli_stmt_close($stmtCountAttendees);
        } else {
            die('Error preparing the query: ' . mysqli_error($conn));
        }

        echo "<br>";

        // List all attendee IDs
        $queryListAttendeeIDs = "SELECT attendeeID FROM registrations WHERE eventID = ?";
        if ($stmtListAttendeeIDs = mysqli_prepare($conn, $queryListAttendeeIDs)) {
            mysqli_stmt_bind_param($stmtListAttendeeIDs, 'i', $eventID);
            if (mysqli_stmt_execute($stmtListAttendeeIDs)) {
                mysqli_stmt_bind_result($stmtListAttendeeIDs, $attendeeID);
                echo "List of Attendee IDs: ";
                while (mysqli_stmt_fetch($stmtListAttendeeIDs)) {
                    echo $attendeeID . ", ";
                }
            } else {
                die('Error executing the query: ' . mysqli_error($conn));
            }
            mysqli_stmt_close($stmtListAttendeeIDs);
        } else {
            die('Error preparing the query: ' . mysqli_error($conn));
        }

        // Fetch gender and birth date of attendees
        $queryAttendeeDetails = "SELECT gender, birthDate FROM attendee WHERE attendeeID IN (SELECT attendeeID FROM registrations WHERE eventID = ?)";
        if ($stmtAttendeeDetails = mysqli_prepare($conn, $queryAttendeeDetails)) {
            mysqli_stmt_bind_param($stmtAttendeeDetails, 'i', $eventID);
            mysqli_stmt_execute($stmtAttendeeDetails);
            mysqli_stmt_bind_result($stmtAttendeeDetails, $gender, $birthDate);

            $genders = [];
            $birthDates = [];
            while (mysqli_stmt_fetch($stmtAttendeeDetails)) {
                $genders[] = $gender;
                $birthDates[] = $birthDate;
            }
            mysqli_stmt_close($stmtAttendeeDetails);
        } else {
            die('Error preparing the query: ' . mysqli_error($conn));
        }

        ?>

        <br>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var genders = <?php echo json_encode($genders); ?>;
                var birthDates = <?php echo json_encode($birthDates); ?>;

                var genderCounts = genders.reduce(function (acc, gender) {
                    acc[gender] = (acc[gender] || 0) + 1;
                    return acc;
                }, {});

                var today = new Date();
                var ages = birthDates.map(function (date) {
                    return today.getFullYear() - new Date(date).getFullYear();
                });

                var ageCounts = ages.reduce(function (acc, age) {
                    acc[age] = (acc[age] || 0) + 1;
                    return acc;
                }, {});

                // Create Pie Chart for Gender Distribution
                var ctxGender = document.getElementById('genderChart').getContext('2d');
                var genderChart = new Chart(ctxGender, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(genderCounts),
                        datasets: [{
                            label: 'Gender Distribution',
                            data: Object.values(genderCounts),
                            backgroundColor: ['red', 'blue'],
                            hoverOffset: 4
                        }]
                    }
                });

                // Create Bar Chart for Age Distribution
                var ctxAge = document.getElementById('ageChart').getContext('2d');
                var ageChart = new Chart(ctxAge, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(ageCounts),
                        datasets: [{
                            label: 'Age Distribution',
                            data: Object.values(ageCounts),
                            backgroundColor: 'green',
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>

        <canvas id="genderChart" width="100" height="100"></canvas>
        <canvas id="ageChart" width="100" height="100"></canvas>

        <?php

        include_once 'include/footer.php';
        ?>
    </body>

    <?php
    }
    ?>

</html>