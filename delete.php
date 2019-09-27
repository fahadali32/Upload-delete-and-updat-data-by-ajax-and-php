<?php
include 'db.php';

$id = mysqli_real_escape_string($con,$_POST['id']);

$query = "DELETE FROM `uploading` WHERE id = '$id'";

mysqli_query($con,$query);
?>