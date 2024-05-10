<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Event Statistics";
    include_once 'include/metaData.php';

    if (empty($_SESSION['organizerID'])) {
        require_once 'include/accessDenied.php';
    } else {
    ?>
    <style>
        /* General table styles */
        table {
            width: 60%; /* Set the width of the tables */
            margin: 20px auto; /* Center tables horizontally */
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        h3 {
            text-align: center; /* Center headings */
        }
    </style>
</head>

<body>
    <?php include_once 'include/navigationBar.php'; ?>
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
        } else {
            die('Error executing the query: ' . mysqli_error($conn));
        }
        mysqli_stmt_close($stmtCountAttendees);
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

    // Calculate age distribution
    $today = new DateTime();
    $ages = array_map(function ($date) use ($today) {
        return $today->format('Y') - (new DateTime($date))->format('Y');
    }, $birthDates);
    $ageCounts = array_count_values($ages);
    $genderCounts = array_count_values($genders);
    ?>

    <h3>Total Attendance: <?php echo $numberOfRegistered; ?></h3>
    <h3>Gender Distribution</h3>
    <table>
        <tr>
            <th>Gender</th>
            <th>Count</th>
        </tr>
        <?php
        foreach ($genderCounts as $gender => $count) {
            echo "<tr><td>$gender</td><td>$count</td></tr>";
        }
        ?>
    </table>

    <h3>Age Distribution</h3>
    <table>
        <tr>
            <th>Age</th>
            <th>Count</th>
        </tr>
        <?php
        foreach ($ageCounts as $age => $count) {
            echo "<tr><td>$age</td><td>$count</td></tr>";
        }
        ?>
    </table>

    <?php include_once 'include/footer.php'; ?>
</body>

<?php
}
?>

</html>