<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ebebeb">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="assets\logo.svg" alt="" width="75" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">



            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (empty($_SESSION['organizerID'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="guestAttendeeEventsPage.php">Events</a>
                    </li>

                <?php }

                if (empty($_SESSION['organizerID']) == false) {

                    ?>
                    <li class="nav-item">
                        <a class="nav-link " href="organizerMyEventsPage.php">My
                            Events</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="organizerAddEventPage.php">Add
                            Event</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="attendeeOrganizerNotificationsPage.php">Notifications</a>
                    </li>

                    <?php

                } else { ?>

                    <?php if (empty($_SESSION['attendeeID']) == false) {
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="attendeeRegisteredEventsPage.php">Registered Events</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="attendeeOrganizerNotificationsPage.php">Notifications</a>
                        </li>


                        <?php
                    }
                } ?>

                <li class="nav-item">
                    <a class="nav-link" href="allContactUsPage.php">Contact Us</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <?php
                if (empty($_SESSION['organizerID']) == false || empty($_SESSION['attendeeID']) == false) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" title="Click here to see your profile"
                            href="attendeeOrganizerUpdateProfilePage.php">
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
                        <a class="nav-link" href="guestLoginPage.php" title="Click here to login">
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