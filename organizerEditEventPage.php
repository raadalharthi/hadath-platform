<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Edit Event";
    include_once 'include/metaData.php';

    if (empty($_SESSION['organizerID'])) {
        require_once 'include\accessDenied.php';
    } else { ?>

    </head>

    <body>
        <?php
        include_once 'include/navigationBar.php';

        $eventID = $_POST['eventID'];
        $title = $_POST['title'];
        $eventType = $_POST['eventType'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $organizerID = $_POST['organizerID'];
        $capacity = $_POST['capacity'];
        $numberOfRegistered = $_POST['numberOfRegistered'];
        $registrationDeadline = $_POST['registrationDeadline'];
        $eventImage = $_POST['eventImage'];

        ?>
        <div class="container-fluid ps-md-0">
            <div class="row g-0">
                <div class="col-md-8 col-lg-6">
                    <div class="login d-flex align-items-center py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9 col-lg-8 mx-auto">
                                    <h3 class="login-heading mb-4">Edit Event</h3>

                                    <form name="editEvent" action="functions/editEventValidation.php"
                                        onsubmit="return validation()" method="POST" enctype="multipart/form-data">

                                        <input type="hidden" id="eventID" name="eventID" value="<?php echo $eventID; ?>">
                                        
                                        <!-- Image Upload Section -->
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*">
                                            <label for="image">Upload Image</label>
                                        </div>

                                        <input type="hidden" id="oldImage" name="oldImage" value="<?php echo $eventImage; ?>">

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                                placeholder="eventTitle" value="<?php echo $title; ?>">
                                            <label for="eventTitle">Event Title<span style="color: red;">
                                                    *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="eventType" name="eventType">
                                                <!-- Options with PHP condition for selected attribute -->
                                                <option value="ACD" <?php if ($eventType == 'ACD')
                                                    echo 'selected'; ?>>
                                                    Academic Events</option>
                                                <option value="ART" <?php if ($eventType == 'ART')
                                                    echo 'selected'; ?>>Art
                                                    Shows</option>
                                                <option value="AWC" <?php if ($eventType == 'AWC')
                                                    echo 'selected'; ?>>Award
                                                    Ceremonies</option>
                                                <option value="CHE" <?php if ($eventType == 'CHE')
                                                    echo 'selected'; ?>>Charity
                                                    Events</option>
                                                <option value="COM" <?php if ($eventType == 'COM')
                                                    echo 'selected'; ?>>
                                                    Community Events</option>
                                                <option value="CFS" <?php if ($eventType == 'CFS')
                                                    echo 'selected'; ?>>
                                                    Conferences</option>
                                                <option value="ENT" <?php if ($eventType == 'ENT')
                                                    echo 'selected'; ?>>
                                                    Entertainment Events</option>
                                                <option value="EXB" <?php if ($eventType == 'EXB')
                                                    echo 'selected'; ?>>
                                                    Exhibitions</option>
                                                <option value="HOL" <?php if ($eventType == 'HOL')
                                                    echo 'selected'; ?>>Holiday
                                                    Celebrations</option>
                                                <option value="NET" <?php if ($eventType == 'NET')
                                                    echo 'selected'; ?>>
                                                    Networking Events</option>
                                                <option value="SEM" <?php if ($eventType == 'SEM')
                                                    echo 'selected'; ?>>
                                                    Seminars</option>
                                                <option value="SHO" <?php if ($eventType == 'SHO')
                                                    echo 'selected'; ?>>
                                                    Showcase</option>
                                                <option value="WRK" <?php if ($eventType == 'WRK')
                                                    echo 'selected'; ?>>
                                                    Workshops</option>
                                                <!-- Add more options here if needed -->
                                            </select>
                                            <label for="eventType">Event Type<span style="color: red;"> *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="eventDate" name="eventDate"
                                                value="<?php echo $date; ?>">
                                            <label for="eventDate">Event Date<span style="color: red;"> *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="time" class="form-control" id="eventTime" name="eventTime"
                                                value="<?php echo $time; ?>">
                                            <label for="eventTime">Event Time<span style="color: red;"> *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="datetime-local" class="form-control" id="registrationDeadline"
                                                name="registrationDeadline" value="<?php echo $registrationDeadline; ?>">
                                            <label for="registrationDeadline">Registration Deadline<span
                                                    style="color: red;"> *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="eventLocation" name="eventLocation"
                                                placeholder="Building A11, Main Theater" value="<?php echo $location; ?>">
                                            <label for="eventLocation">Event Location<span style="color: red;">
                                                    *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="eventDescription" name="eventDescription"
                                                placeholder="Anything"><?php echo $description; ?></textarea>
                                            <label for="eventDescription">Event Description<span style="color: red;">
                                                    *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="eventCapacity"
                                                name="eventCapacity" placeholder="30" min="1" max="1000"
                                                value="<?php echo $capacity; ?>">
                                            <label for="eventCapacity">Event Capacity<span style="color: red;">
                                                    *</span></label>
                                        </div>

                                        <div class="d-grid">
                                            <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2"
                                                type="submit" id="btn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"
                    style="background-image: url(./assets/editEvent.webp);">
                </div>
            </div>
        </div>

        <script>
            function validation() {
                var eventTitle = document.editEvent.eventTitle.value.trim();
                var eventType = document.editEvent.eventType.value;
                var eventDate = document.editEvent.eventDate.value;
                var eventTime = document.editEvent.eventTime.value;
                var registrationDeadline = document.editEvent.registrationDeadline.value;
                var eventLocation = document.editEvent.eventLocation.value.trim();
                var eventDescription = document.editEvent.eventDescription.value.trim();
                var eventCapacity = document.editEvent.eventCapacity.value;

                // Patterns for validation
                var titlePattern = /^[A-Za-z0-9 ]+$/;  // Only alphanumeric and space characters

                // Required field validations
                if (!eventTitle) {
                    alert("Event title is required. Please enter the event title.");
                    return false;
                }

                if (!titlePattern.test(eventTitle)) {
                    alert("Event title can only contain letters, numbers, and spaces.");
                    return false;
                }

                if (eventType === "Select Event Type" || !eventType) {
                    alert("Please select an event type.");
                    return false;
                }

                if (!eventDate) {
                    alert("Event date is required. Please select the event date.");
                    return false;
                }

                if (!eventTime) {
                    alert("Event time is required. Please select the event time.");
                    return false;
                }

                if (!registrationDeadline) {
                    alert("Registration deadline is required. Please select the registration deadline.");
                    return false;
                }

                var current = new Date();
                var eventDateObj = new Date(eventDate);
                var deadlineDateObj = new Date(registrationDeadline);

                if (eventDateObj < current) {
                    alert("The event date must be in the future.");
                    return false;
                }

                if (deadlineDateObj >= eventDateObj) {
                    alert("The registration deadline must be before the event date.");
                    return false;
                }

                if (!eventLocation) {
                    alert("Event location is required. Please enter the event location.");
                    return false;
                }

                if (!eventDescription) {
                    alert("Event description is required. Please enter the event description.");
                    return false;
                }

                if (!eventCapacity) {
                    alert("Event capacity is required. Please enter the event capacity.");
                    return false;
                }

                // Capacity must be a number and make sense
                if (isNaN(eventCapacity) || eventCapacity < 1 || eventCapacity > 1000) {
                    alert("Event capacity must be a valid number between 1 and 1000.");
                    return false;
                }

                return true; // All validations passed
            }
        </script>

        <?php

        include_once 'include/footer.php';
        ?>
    </body>

    <?php
    }
    ?>

</html>