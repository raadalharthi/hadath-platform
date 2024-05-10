<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Add Event";
    include_once 'include/metaData.php';

    if (empty($_SESSION['organizerID'])) {
        require_once 'include\accessDenied.php';
    } else { ?>

    </head>

    <body>
        <?php
        include_once 'include/navigationBar.php';
        ?>
        <div class="container-fluid ps-md-0">
            <div class="row g-0">
                <div class="col-md-8 col-lg-6">
                    <div class="login d-flex align-items-center py-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-9 col-lg-8 mx-auto">
                                    <h3 class="login-heading mb-4">Add Event</h3>

                                    <form name="addEvent" action="functions/addEventValidation.php" onsubmit="return validation()"
                                        method="POST" enctype="multipart/form-data">

                                        <!-- Image Upload Section -->
                                        <div class="form-floating mb-3">
                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*">
                                            <label for="image">Upload Image</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                                                placeholder="eventTitle">
                                            <label for="eventTitle">Event Title<span style="color: red;">
                                                    *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="eventType" name="eventType">
                                                <option selected>Select Event Type</option>
                                                <option value="ACD">Academic Events</option>
                                                <option value="ART">Art Shows</option>
                                                <option value="AWC">Award Ceremonies</option>
                                                <option value="CHE">Charity Events</option>
                                                <option value="COM">Community Events</option>
                                                <option value="CFS">Conferences</option>
                                                <option value="ENT">Entertainment Events</option>
                                                <option value="EXB">Exhibitions</option>
                                                <option value="HOL">Holiday Celebrations</option>
                                                <option value="NET">Networking Events</option>
                                                <option value="SEM">Seminars</option>
                                                <option value="SHO">Showcase</option>
                                                <option value="WRK">Workshops</option>
                                            </select>
                                            <label for="eventType">Event Type<span style="color: red;"> *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="eventDate" name="eventDate">
                                            <label for="eventDate">Event Date<span style="color: red;"> *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="time" class="form-control" id="eventTime" name="eventTime">
                                            <label for="eventTime">Event Time<span style="color: red;"> *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="datetime-local" class="form-control" id="registrationDeadline"
                                                name="registrationDeadline">
                                            <label for="registrationDeadline">Registration Deadline<span
                                                    style="color: red;"> *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="eventLocation" name="eventLocation"
                                                placeholder="Building A11, Main Theater">
                                            <label for="eventLocation">Event Location<span style="color: red;">
                                                    *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="eventDescription" name="eventDescription"
                                                placeholder="Anything"></textarea>
                                            <label for="eventDescription">Event Description<span style="color: red;">
                                                    *</span></label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="eventCapacity"
                                                name="eventCapacity" placeholder="30" min="1" max="1000">
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
                <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image" style="background-image: url(./assets/addEvent.webp);">
                </div>
            </div>
        </div>

        <script>
            function validation() {
                var eventTitle = document.addEvent.eventTitle.value.trim();
                var eventType = document.addEvent.eventType.value;
                var eventDate = document.addEvent.eventDate.value;
                var eventTime = document.addEvent.eventTime.value;
                var registrationDeadline = document.addEvent.registrationDeadline.value;
                var eventLocation = document.addEvent.eventLocation.value.trim();
                var eventDescription = document.addEvent.eventDescription.value.trim();
                var eventCapacity = document.addEvent.eventCapacity.value;

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
                    </body >

                <?php
    }
    ?>

</html >