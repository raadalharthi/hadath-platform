<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
            /* Ensuring nav doesn't overlap content */
        }

        .navbar-brand img {
            transition: transform 0.5s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.1);
            /* Logo grows on hover */
        }

        .nav-link {
            transition: color 0.2s ease-in-out;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #007bff !important;
            /* Brighter color on hover and active */
            text-decoration: underline;
        }

        .navbar {
            padding: 1rem 1rem;
            /* Increased padding */
            background-color: #fff;
            /* Light theme */
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            /* Subtle shadow for depth */
        }

        /* Adding a subtle hover effect for icons */
        .fa-solid {
            transition: transform 0.3s ease;
        }

        .fa-solid:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ebebeb">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="assets\logo.svg" alt="" width="75" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (empty($_SESSION['organizerID'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $activeGuestAttendeeEventsPage ?>"
                                href="guestAttendeeEventsPage.php">Events</a>
                        </li>

                    <?php }

                    if (empty($_SESSION['organizerID']) == false) {

                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $activeOrganizerMyEventsPage ?>" href="organizerMyEventsPage.php">My
                                Events</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $activeOrganizerAddEventPage ?>" href="organizerAddEventPage.php">Add
                                Event</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $activeAttendeeOrganizerNotificationsPage ?>"
                                href="attendeeOrganizerNotificationsPage.php">Notifications</a>
                        </li>

                        <?php

                    } else { ?>

                        <?php if (empty($_SESSION['attendeeID']) == false) {
                            ?>

                            <li class="nav-item">
                                <a class="nav-link <?= $activeAttendeeRegisteredEventsPage ?>"
                                    href="attendeeRegisteredEventsPage.php">Registered Events</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= $activeAttendeeOrganizerNotificationsPage ?>"
                                    href="attendeeOrganizerNotificationsPage.php">Notifications</a>
                            </li>


                            <?php
                        }
                    } ?>

                    <li class="nav-item">
                        <a class="nav-link <?= $activeContactUs ?>" href="allContactUsPage.php">Contact Us</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php
                    if (empty($_SESSION['organizerID']) == false || empty($_SESSION['attendeeID']) == false) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $activeAttendeeOrganizerUpdateProfilePage ?>"
                                title="Click here to see your profile" href="attendeeOrganizerUpdateProfilePage.php">
                                <span><i class="fa-solid fa-user"></i></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="functions/signOut.php" title="Click here to sign out">
                                <span><i class="fa-solid fa-right-from-bracket fa-lg"></i></i></span>
                            </a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $activeLoginPage ?>" href="guestLoginPage.php"
                                title="Click here to login">
                                <span><i class="fa-solid fa-right-to-bracket fa-lg"></i></span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>