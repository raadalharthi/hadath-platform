<?php
    session_start();
    unset($_SESSION['adminID']);
    unset($_SESSION['userID']);
    header('Location: loginPage.php')
?>