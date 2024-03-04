<?php

session_start();

echo $_SESSION['userType'];
echo $_SESSION['imageBase64'];
echo $_SESSION['organizerName'];
echo $_SESSION['college'];
echo $_SESSION['email'];
echo $_SESSION['password'];

session_destroy();

?>