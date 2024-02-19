<?php
    session_start();
    unset($_SESSION['organizerID']);
    unset($_SESSION['attendeeID']);
    header('Location: loginPage.php')
?>