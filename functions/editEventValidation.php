<?php

// Flag to track validation status
$validationPassed = true;
$messages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include ('../include/connection.php');  // Ensure this path is correct for your database connection settings

    $eventTitle = trim($_POST['eventTitle']);
    $eventType = $_POST['eventType'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $eventLocation = trim($_POST['eventLocation']);
    $eventDescription = trim($_POST['eventDescription']);
    $eventCapacity = $_POST['eventCapacity'];

    // Patterns for validation
    $titlePattern = "/^[A-Za-z0-9 ]+$/";  // Only alphanumeric and space characters

    // Initialize variables related to file upload
    $target_dir = '../assets/uploadedImages/';
    $file_name = '';
    $target_file = '';

    if ($_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
        $target_file = $_POST['oldImage']; // Use the old image if no new image is uploaded
    } elseif ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Proceed with the file upload
        $temp = $_FILES['image']['tmp_name'];
        $uniq = time() . rand(1000, 9999);
        $info = pathinfo($_FILES['image']['name']);
        $fileType = strtolower($info['extension']);

        if ($fileType !== "jpg" && $fileType !== "png" && $fileType !== "jpeg") {
            $messages[] = 'Sorry, only JPG, PNG, and JPEG formats are allowed.';
            $validationPassed = false;
        } else {
            $file_name = "file_" . $uniq . "." . $info['extension'];
            $target_file = $target_dir . $file_name;
            move_uploaded_file($temp, $target_file);
        }
    } else {
        // Handle other errors
        $messages[] = 'There was an error uploading the image.';
        $validationPassed = false;
    }

    // Validate event title
    if (empty($eventTitle)) {
        $messages[] = "Event title is required. Please enter the event title.";
        $validationPassed = false;
    } elseif (!preg_match($titlePattern, $eventTitle)) {
        $messages[] = "Event title can only contain letters, numbers, and spaces.";
        $validationPassed = false;
    }

    // Validate event type
    if ($eventType === "Select Event Type" || empty($eventType)) {
        $messages[] = "Please select an event type.";
        $validationPassed = false;
    }

    // Validate dates and times
    $current = new DateTime();
    $eventDateObj = new DateTime($eventDate);

    if ($eventDateObj < $current) {
        $messages[] = "The event date must be in the future.";
        $validationPassed = false;
    }

    // Validate location and description
    if (empty($eventLocation)) {
        $messages[] = "Event location is required. Please enter the event location.";
        $validationPassed = false;
    }

    if (empty($eventDescription)) {
        $messages[] = "Event description is required. Please enter the event description.";
        $validationPassed = false;
    }

    // Validate capacity
    if (empty($eventCapacity)) {
        $messages[] = "Event capacity is required. Please enter the event capacity.";
        $validationPassed = false;
    } elseif (!is_numeric($eventCapacity) || $eventCapacity < 1 || $eventCapacity > 1000) {
        $messages[] = "Event capacity must be a valid number between 1 and 1000.";
        $validationPassed = false;
    }

    if (!$validationPassed) {
        // Concatenate all messages into a single alert and redirect back to the form page
        $alertMessage = implode("\\n", $messages);
        echo "<script type='text/javascript'>";
        echo "alert('$alertMessage');";
        echo "window.location.href = '../organizerEditEventPage.php';";
        echo "</script>";
    } else {
        session_start();

        $_SESSION['eventID'] = $_POST['eventID'];
        $_SESSION['image'] = $target_file;
        $_SESSION['eventTitle'] = $eventTitle;
        $_SESSION['eventType'] = $eventType;
        $_SESSION['eventDate'] = $eventDate;
        $_SESSION['eventTime'] = $eventTime;
        $_SESSION['eventLocation'] = $eventLocation;
        $_SESSION['eventDescription'] = $eventDescription;
        $_SESSION['eventCapacity'] = $eventCapacity;

        // Redirect to OTP verification page on successful validation
        echo "<script type='text/javascript'>";
        echo "window.location.href = 'editEventInDB.php';";
        echo "</script>";
    }
} else {
    // If the form is not submitted, redirect back to the event form page
    header('Location: ../organizerEditEventPage.php');
    exit;
}

?>