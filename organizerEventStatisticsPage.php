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
        $sql = "SELECT numberOfRegistered FROM events WHERE eventID = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, 'i', $eventID);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $numberOfRegistered);
                mysqli_stmt_fetch($stmt);
                echo "Attendance = " . $numberOfRegistered;
            } else {
                die('Error executing the query: ' . mysqli_error($conn));
            }
            mysqli_stmt_close($stmt);
        } else {
            die('Error preparing the query: ' . mysqli_error($conn));
        }
        ?>
        <?php

        include_once 'include/footer.php';
        ?>
    </body>

    <?php
    }
    ?>

</html>