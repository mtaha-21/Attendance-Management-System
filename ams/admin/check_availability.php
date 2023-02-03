<?php 
require_once("includes/config.php");
// code for parent username availablity
if(!empty($_POST["username"])) {
$pusername= $_POST["username"];
$sql ="SELECT parentUsername FROM tblparents WHERE parentUsername=:pusername";
$query= $dbh -> prepare($sql);
$query-> bindParam(':pusername', $pusername, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Username already associated with another account .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> Username available for Registration .</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}


// code for student username availablity
if(!empty($_POST["stdusername"])) {
$suname= $_POST["stdusername"];
$sql ="SELECT studentUsername FROM  tblstudents WHERE studentUsername=:suname";
$query= $dbh -> prepare($sql);
$query-> bindParam(':suname', $suname, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Username already associated with another account .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> Username available for Registration .</span>";
 //echo "<script>$('#submit').prop('disabled',false);</script>";
}
}

// code for student roll number  availablity
if(!empty($_POST["crdata"])) {
 $id= $_POST['crdata'];
 $dta=explode("$",$id);
$clss=$dta[0];
$rlnumber=$dta[1];
$sql ="SELECT studentUsername FROM  tblstudents WHERE studentRollNumber=:rlnumber and studentClass=:clss";
$query= $dbh -> prepare($sql);
$query-> bindParam(':clss', $clss, PDO::PARAM_STR);
$query-> bindParam(':rlnumber', $rlnumber, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Roll Number already alloted to other student in this class .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{	
echo "<script>$('#submit').prop('disabled',false);</script>";
}
}


// code for staff username availablity
if(!empty($_POST["staffusername"])) {
$stfusername= $_POST["staffusername"];
$sql ="SELECT staffUsername FROM tblstaff WHERE staffUsername=:stfusername";
$query= $dbh -> prepare($sql);
$query-> bindParam(':stfusername', $stfusername, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Username already associated with another account .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> Username available for Registration .</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}


?>
