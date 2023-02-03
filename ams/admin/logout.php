<?php
session_start(); 
unset($_SESSION['adid']);
session_destroy(); // destroy session
header("location:../index.php"); 
?>

