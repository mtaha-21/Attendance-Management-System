<?php
session_start(); 
unset($_SESSION['stfid']);
session_destroy(); // destroy session
header("location:../index.php"); 
?>

