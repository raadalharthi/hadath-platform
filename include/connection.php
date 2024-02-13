<?php
    // store the database connection variables in php variables
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "hadathplatformdb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
?>