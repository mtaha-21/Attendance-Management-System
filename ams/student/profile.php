<?php
session_start();
include('../includes/config.php');
// Verifying Admin login session
if(strlen($_SESSION['stdid'])==0)
    {   
header('location:logout.php');
}
else{ 

//Genrating CSRF Token
if(empty($_SESSION['token'])) {
$_SESSION['token'] = bin2hex(random_bytes(32));
}
if(isset($_POST['update']))
{
//Verifying CSRF Token
if(!empty($_POST['csrftoken'])) {
if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
// Getting Student id    
$stdid=intval($_SESSION['stdid']);
// Getting Post Values    
$parentid=$_POST['parent'];
$stdname=$_POST['stdname'];
$stdaddress=$_POST['stdaddress'];
$stdcontact=$_POST['stdcontact'];
$stddob=$_POST['dob'];
$jdate=$_POST['joindate'];
$clname=$_POST['classname'];
$rollno=$_POST['rollno'];
$sql="update tblstudents set parentId=:parentid,studentName=:stdname,studentAdress=:stdaddress,studentContact=:stdcontact,studentDob=:stddob,studentJoinDate=:jdate,studentRollNumber=:rollno,studentClass=:clname where id=:stdid";
$query = $dbh->prepare($sql);
$query->bindParam(':parentid',$parentid,PDO::PARAM_STR);
$query->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query->bindParam(':stdaddress',$stdaddress,PDO::PARAM_STR);
$query->bindParam(':stdcontact',$stdcontact,PDO::PARAM_STR);
$query->bindParam(':stddob',$stddob,PDO::PARAM_STR);
$query->bindParam(':jdate',$jdate,PDO::PARAM_STR);
$query->bindParam(':rollno',$rollno,PDO::PARAM_STR);
$query->bindParam(':clname',$clname,PDO::PARAM_STR);
$query->bindParam(':stdid',$stdid,PDO::PARAM_STR);
$query->execute();

echo '<script> alert("Record updated successfully");</script>';
unset( $_SESSION['token']); // unset session token after submiiting

}
// if record already updated
else {
    echo '<script> alert("Record already updated. Please fresh browser then try");</script>';
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title> Student update profile</title>
    <link href="../vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="../vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <!-- ION CSS -->
    <link href="../vendors/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" type="text/css">
    <link href="../vendors/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css" rel="stylesheet" type="text/css">
    <!-- select2 CSS -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Pickr CSS -->
    <link href="../vendors/pickr-widget/dist/pickr.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterangepicker CSS -->
    <link href="../vendors/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="../dist/css/style.css" rel="stylesheet" type="text/css">
    <script>
function checkRollnoAvailability(cls,rln) {
var cls=$(".stdcls").val();
var rln=$(".rollno").val();
var clsrln=cls+'$'+rln;
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'crdata='+clsrln,
type: "POST",
success:function(data){
$("#user-rollnoavailability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}



</script> 
</head>
<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->
<!-- HK Wrapper -->
<div class="hk-wrapper hk-vertical-nav">
<!-- Top Navbar -->
<?php include_once("includes/header.php");?>
 <!-- /Top Navbar -->
<!-- Sidebar -->
<?php include_once("includes/sidebar.php");?>        
<!-- /Sidebar -->
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="#">Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="toggle-right"></i></span></span>Edit profile</h4>
                </div>
                <!-- /Title -->

<?php 
$stdid=intval($_SESSION['stdid']);
$sql="SELECT  tblparents.id as pid,tblparents.parentName as pname,tblstudents.id as stdid,parentId,studentName,studentAdress,studentContact,studentDob,studentJoinDate,studentRollNumber,studentClass,studentUsername,tblstudents.regDate,lastUpdationDate from tblstudents left join tblparents on tblparents.id=tblstudents.parentId where tblstudents.id=:sid";
$query = $dbh -> prepare($sql);
$query->bindParam(':sid',$stdid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
//Count Intializer
$cnt=1;
if($query->rowCount() > 0)
{ 
foreach($results as $result)
{?>
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                     <form name="editstudent" method="post">  
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Update the info</h5>
  <!-- Input Field for CSRF Token -->                       
<input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />         
                            <div class="row">
      <div class="col-sm">
 <?php if($result->lastUpdationDate!=""){?>                            
<div class="row">
<div class="col-md-2 mt-15">Last Updation Date : </div>
<div class="col-md-6 mt-15">
<?php echo htmlentities($result->lastUpdationDate);?>
</div>
</div>
<?php } ?>

<div class="row">
<div class="col-md-2 mt-15">Reg Date : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" value="<?php echo htmlentities($result->regDate);?>"  name="regdate" id="regdate"   readonly="true" >

</div>
</div>
<div class="row">
<div class="col-md-2 mt-15">Parent : </div>
<div class="col-md-6 mt-10">
<select class="form-control" name="parent" required="required" readonly>
<option value="<?php echo htmlentities($result->pid);?>"> <?php echo htmlentities($result->pname);?> </option>

</select>
</div>
</div>


<div class="row">
<div class="col-md-2 mt-15">Student Name : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="stdname" value="<?php echo htmlentities($result->studentName);?>" placeholder="Student Name" required="true" autofocus>
</div>
</div>  

<div class="row">
<div class="col-md-2 mt-25">Student Address : </div>
<div class="col-md-6  mt-15">
<textarea name="stdaddress"  class="form-control"  required="true" placeholder="Enter parent address" autofocus><?php echo htmlentities($result->studentAdress);?></textarea> 
</div>
</div>

 

<div class="row">
<div class="col-md-2 mt-15">Student Contact : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="stdcontact" placeholder="Student Contact" pattern="[0-9]{10}" value="<?php echo htmlentities($result->studentContact);?>"  title="10 numeric characters only" maxlength="10" required="true" autofocus>
</div>
</div>  


<div class="row">
<div class="col-md-2 mt-15">Date of Birth(DOB) : </div>
<div class="col-md-6 mt-10">
<input type="text" name="dob" required="true" autofocus data-mask="9999-99-99" class="form-control" value="<?php echo htmlentities($result->studentDob);?>" >
<span class="form-text text-muted">yyyy-mm-dd</span>
</div>
</div>  





<div class="row">
<div class="col-md-2 mt-15">Join Date: </div>
<div class="col-md-6 mt-10">
<input type="text" name="joindate" required="true" autofocus data-mask="9999-99-99" class="form-control" value="<?php echo htmlentities($result->studentJoinDate);?>" >
<span class="form-text text-muted">yyyy-mm-dd</span>
</div>
</div>

<div class="row">
<div class="col-md-2 mt-15">Class : </div>
<div class="col-md-6 mt-10">
<select class="form-control stdcls" name="classname" required="required">
<option value="<?php echo htmlentities($result->studentClass);?>"> <?php echo htmlentities($result->studentClass);?> </option>
<?php 
$sql = "SELECT id,className from  tblclasses order by className";
$query = $dbh -> prepare($sql);
$query->execute();
$ret=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($ret as $row)
{               ?>  
<option value="<?php echo htmlentities($row->className);?>"><?php echo htmlentities($row->className);?></option>
 <?php }} ?> 
</select>
</div>
</div>


<div class="row">
<div class="col-md-2 mt-15">Roll Numner : </div>
<div class="col-md-6 mt-10">
<input class="form-control rollno" type="text" onBlur="checkRollnoAvailability()" name="rollno" placeholder="Roll Number" required="true" value="<?php echo htmlentities($result->studentRollNumber);?>"  autofocus>
<span id="user-rollnoavailability-status" style="font-size:12px;"></span> 
</div>
</div>


<div class="row">
<div class="col-md-2 mt-15">Username : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" value="<?php echo htmlentities($result->studentUsername);?>"  name="stdusername" id="stdusername" title="Username can't be change" readonly="true" style="border:solid 1px red;  readonly="true" >

</div>
</div> 


  

<?php }} ?>


<div class="row">
<div class="col-md-2 mt-10">&nbsp;</div>
<div class="col-md-6 mt-10">
<button type="submit" class="btn btn-primary" id="submit" name="update">Update</button>
</div>

                            </div>
                        </div>
                    </div>
                        </section>

 </form>

</div>
<!-- /Container -->
</div>
</div>
</div>
<!-- /Main Content -->
</div>



    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Jasny-bootstrap  JavaScript -->
    <script src="../vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <!-- Slimscroll JavaScript -->
    <script src="../dist/js/jquery.slimscroll.js"></script>
    <!-- Fancy Dropdown JS -->
    <script src="../dist/js/dropdown-bootstrap-extended.js"></script>
    <!-- Ion JavaScript -->
    <script src="../vendors/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="../dist/js/rangeslider-data.js"></script>
    <!-- Toggles JavaScript -->
    <script src="../vendors/jquery-toggles/toggles.min.js"></script>
    <script src="../dist/js/toggle-data.js"></script>
    <!-- Select2 JavaScript -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="../dist/js/select2-data.js"></script>
    <!-- Bootstrap Tagsinput JavaScript -->
    <script src="../vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <!-- Bootstrap Input spinner JavaScript -->
    <script src="../vendors/bootstrap-input-spinner/src/bootstrap-input-spinner.js"></script>
    <script src="../dist/js/inputspinner-data.js"></script>
    <!-- Pickr JavaScript -->
    <script src="../vendors/pickr-widget/dist/pickr.min.js"></script>
    <script src="../dist/js/pickr-data.js"></script>
    <!-- Daterangepicker JavaScript -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/daterangepicker/daterangepicker.js"></script>
    <script src="../dist/js/daterangepicker-data.js"></script>
    <!-- FeatherIcons JavaScript -->
    <script src="../dist/js/feather.min.js"></script>
    <!-- Toggles JavaScript -->
    <script src="../vendors/jquery-toggles/toggles.min.js"></script>
    <script src="../dist/js/toggle-data.js"></script>
    <!-- Init JavaScript -->
    <script src="../dist/js/init.js"></script>
</body>
</html>
<?php } ?>