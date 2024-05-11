/**
* Adds an event to the database and sends a notification to all attendees.
*
* This function retrieves event data from the session, inserts the event into the
* `events` table, and then inserts a notification about the new event into the
* `notification` table. It also inserts a record for each attendee in the
* `attendeenotifications` table to associate the notification with the attendees.
*
* @return void
*/
<?php
// Start session and include the database connection
session_start();
require_once '../include/connection.php';

// Retrieve event data from session
$image = $_SESSION['image'];
$eventTitle = $_SESSION['eventTitle'];
$eventType = $_SESSION['eventType'];
$eventDate = $_SESSION['eventDate'];
$eventTime = $_SESSION['eventTime'];
$registrationDeadline = $_SESSION['registrationDeadline'];
$eventLocation = $_SESSION['eventLocation'];
$eventDescription = $_SESSION['eventDescription'];
$eventCapacity = $_SESSION['eventCapacity'];
$organizerID = $_SESSION['organizerID'][0]; // Retrieve organizer ID from session

// Event type names array
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

// Replace eventType acronym with full name
$eventType = $eventTypeNames[$eventType] ?? 'Undefined Event Type';

// Check if session variables are set
if (empty($eventTitle) || empty($eventType)) {
    die("Required session variables are not set.");
}

// Insert the event data into the database
$eventInsertSQL = "INSERT INTO events (title, eventType, date, time, location, description, organizerID, capacity, registrationDeadline, eventImage) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$eventInsertStmt = mysqli_prepare($conn, $eventInsertSQL);

if ($eventInsertStmt) {
    mysqli_stmt_bind_param($eventInsertStmt, "ssssssiiis", $eventTitle, $eventType, $eventDate, $eventTime, $eventLocation, $eventDescription, $organizerID, $eventCapacity, $registrationDeadline, $image);
    $executeResult = mysqli_stmt_execute($eventInsertStmt);

    if (!$executeResult) {
        die("Error inserting event: " . mysqli_error($conn));
    }
} else {
    die("Error preparing event insertion statement: " . mysqli_error($conn));
}

// Fetch organizer's name
$organizerNameSQL = "SELECT organizerName FROM organizer WHERE organizerID = ?";
$organizerNameStmt = mysqli_prepare($conn, $organizerNameSQL);

if ($organizerNameStmt) {
    mysqli_stmt_bind_param($organizerNameStmt, "i", $organizerID);
    mysqli_stmt_execute($organizerNameStmt);
    mysqli_stmt_bind_result($organizerNameStmt, $organizerName);
    mysqli_stmt_fetch($organizerNameStmt);
    mysqli_stmt_close($organizerNameStmt);
} else {
    die("Error preparing statement: " . mysqli_error($conn));
}

// Insert the general notification about the new event
$notificationInsertSQL = "INSERT INTO notification (notificationType, message)
                          VALUES ('New Event', CONCAT('New ', ?, ' event named ', ?, ', offered by ', ?, ' will be held on ', ?));";
$notificationInsertStmt = mysqli_prepare($conn, $notificationInsertSQL);

if ($notificationInsertStmt) {
    mysqli_stmt_bind_param($notificationInsertStmt, "ssss", $eventType, $eventTitle, $organizerName, $eventTime);
    if (mysqli_stmt_execute($notificationInsertStmt)) {
        $notificationID = mysqli_insert_id($conn);

        // Retrieve all attendees
        $attendeeSelectSQL = "SELECT attendeeID FROM attendee";
        $attendeesResult = mysqli_query($conn, $attendeeSelectSQL);
        if ($attendeesResult) {
            $attendeeNotificationInsertSQL = "INSERT INTO attendeenotifications (attendeeID, notificationID) VALUES (?, ?)";
            $attendeeNotificationInsertStmt = mysqli_prepare($conn, $attendeeNotificationInsertSQL);
            if ($attendeeNotificationInsertStmt) {
                while ($row = mysqli_fetch_assoc($attendeesResult)) {
                    $attendeeID = $row['attendeeID'];
                    mysqli_stmt_bind_param($attendeeNotificationInsertStmt, "ii", $attendeeID, $notificationID);
                    mysqli_stmt_execute($attendeeNotificationInsertStmt);
                }
                mysqli_stmt_close($attendeeNotificationInsertStmt);
            } else {
                die("Error preparing attendee notification insertion statement: " . mysqli_error($conn));
            }
        } else {
            die("Error retrieving attendees: " . mysqli_error($conn));
        }
        header('Location: ../organizerMyEventsPage.php');
    } else {
        die("Error adding notification: " . mysqli_error($conn));
    }
} else {
    die("Error preparing notification insertion statement: " . mysqli_error($conn));
}

// Close all open statement handles and the connection
mysqli_stmt_close($eventInsertStmt);
mysqli_stmt_close($notificationInsertStmt);
mysqli_close($conn);
?>