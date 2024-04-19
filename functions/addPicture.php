<?php
$info = '';
$target_dir = 'assets/uploadedImages/';
$temp = $_FILES['image']['tmp_name'];
$uniq = time() . rand(1000, 9999);
$info = pathinfo($_FILES['image']['name']);

$target_file = $target_dir . basename($_FILES["image"]["name"]);
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
 
  //    Allow certain files formats
  if ($fileType !== "jpg" && $fileType !== "png" && $fileType !== "jpeg") {
    $info = '<div class="alert mt-4 alert-danger"  role="alert">Sorry only jpg, png and jpeg formats are allowed!</div>';
  }
  else {
    $file_name = "file_" . $uniq . "." . $info['extension']; //with your created name
    move_uploaded_file($temp, $target_dir . $file_name);
  }
?>