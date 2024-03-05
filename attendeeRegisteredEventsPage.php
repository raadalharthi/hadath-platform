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

        <h1>attendeeRegisteredEventsPage.php</h1>

        <?php

        include_once 'include/footer.php';
        ?>
    </body>

    <?php
    }
    ?>

</html>