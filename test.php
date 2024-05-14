<?php
session_start();

// Retrieve event data from session
$image = $_SESSION['image'];
$eventTitle = $_SESSION['eventTitle'];
$eventType = $_SESSION['eventType'];
$eventDate = $_SESSION['eventDate'];
$eventTime = $_SESSION['eventTime'];
$registrationDeadline = str_replace('T', ' ', $_SESSION['registrationDeadline']) . ':00';
$eventLocation = $_SESSION['eventLocation'];
$eventDescription = $_SESSION['eventDescription'];
$eventCapacity = $_SESSION['eventCapacity'];
$organizerID = $_SESSION['organizerID'][0]; // Retrieve organizer ID from session

echo $image;
echo nl2br("\r\n");
echo $eventTitle;
echo nl2br("\r\n");
echo $eventType;
echo nl2br("\r\n");
echo $eventDate;
echo nl2br("\r\n");
echo $eventTime;
echo nl2br("\r\n");
echo $registrationDeadline;
echo nl2br("\r\n");
echo $eventLocation;
echo nl2br("\r\n");
echo $eventDescription;
echo nl2br("\r\n");
echo $eventCapacity;
echo nl2br("\r\n");
echo $organizerID;

 ?>