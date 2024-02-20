<?php
session_start();

include('include/connection.php');

$userType = $_GET['userType'];
$email = $_GET['email'];
$password = $_GET['password'];
$confirmPassword = $_GET['confirmPassword'];
$firstName = $_GET['firstName'];
$lastName = $_GET['lastName'];
$organizerName = $_GET['organizerName'];
$gender = $_GET['gender'];
$college = $_GET['college'];

//to prevent from mysqli injection  
$userType = stripcslashes($password);
$email = stripcslashes($email);
$password = stripcslashes($password);
$confirmPassword = stripcslashes($confirmPassword);
$firstName = stripcslashes($firstName);
$lastName = stripcslashes($lastName);
$organizerName = stripcslashes($organizerName);
$gender = stripcslashes($gender);
$college = stripcslashes($college);


$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

if ($userType == 'Sign Up'){
$sql = "INSERT INTO customer (email, password) VALUES ('$email', '$password');";
$result = mysqli_query($conn, $sql);
header('Location: loginpage.php');
}

else {

if ($userType == "Admin Sign in") {
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
    if ($userType == "Admin Sign in") {

        if (empty($_SESSION['organizerID'])) {
            $_SESSION['organizerID'] = array();
        }

        array_push($_SESSION['organizerID'], $id);

        header('Location: adminProductsPage.php');
    } elseif ($userType == "Sign in") {

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