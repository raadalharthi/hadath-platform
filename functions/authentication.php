<?php
session_start();

include('include/connection.php');
$type = $_POST['type'];
$email = $_POST['email'];
$password = $_POST['password'];

//to prevent from mysqli injection  
$email = stripcslashes($email);
$password = stripcslashes($password);
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

if ($type == 'Sign Up'){
$sql = "INSERT INTO customer (email, password) VALUES ('$email', '$password');";
$result = mysqli_query($conn, $sql);
header('Location: loginpage.php');
}

else {

if ($type == "Admin Sign in") {
    $table = "admin";
} else {
    $table = "customer";
}


$sql = "select * from $table where email = '$email' and password = '$password'";


$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

$id = $row['ID'];

if ($count == 1) {
    if ($type == "Admin Sign in") {

        if (empty($_SESSION['organizerID'])) {
            $_SESSION['organizerID'] = array();
        }

        array_push($_SESSION['organizerID'], $id);

        header('Location: adminProductsPage.php');
    } elseif ($type == "Sign in") {

        if (empty($_SESSION['attendeeID'])) {
            $_SESSION['attendeeID'] = array();
        }

        array_push($_SESSION['attendeeID'], $id);

        header('Location: index.php');
    }
} else {
    header('Location: loginpage.php');
}
}