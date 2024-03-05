<?php

session_start();


echo $_SESSION['userType'];
"\\n";
echo $_SESSION['imageBase64'];
"\\n";
echo $_SESSION['firstName'];
"\\n";
echo $_SESSION['lastName'];
"\\n";
echo $_SESSION['gender'];
"\\n";
echo $_SESSION['birthDate'];
"\\n";
echo $_SESSION['college'];
"\\n";
echo $_SESSION['email'];
"\\n";
echo $_SESSION['password'];

session_destroy();

?>