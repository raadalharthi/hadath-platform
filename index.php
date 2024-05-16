<?php


session_start();

if (!empty($_SESSION['organizerID'])) {
  header("Location: organizerMyEventsPage.php");
}

elseif (!empty($_SESSION['attendeeID'])) {
  header("Location: guestAttendeeEventsPage.php");
}

else {
  header("Location: guestLoginPage.php");
}

?>