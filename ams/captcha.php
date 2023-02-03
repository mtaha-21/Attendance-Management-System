<?php 
session_start(); 
$text = rand(10000,99999); 
$_SESSION["vercode"] = $text; 
$height = 25; 
$width = 55;   
$image_p = imagecreate($width, $height); 
$black = imagecolorallocate($image_p, 0, 102, 255); 
$white = imagecolorallocate($image_p, 255, 255, 255); 
$font_size = 20; 
imagestring($image_p, $font_size, 5, 5, $text, $white); 
imagejpeg($image_p, null, 100); 
?>