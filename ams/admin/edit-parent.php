<?php
session_start();
include('includes/config.php');
// Verifying Admin login session
if(strlen($_SESSION['adid'])==0)
    {   
header('location:logout.php');
}
else{ 

//Genrating CSRF Token
if(empty($_SESSION['token'])) {
$_SESSION['token'] = bin2hex(random_bytes(32));
}
if(isset($_POST['submit']))
{
//Verifying CSRF Token
if(!empty($_POST['csrftoken'])) {
if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
 // Getting Parent id   
 $parentid=intval($_GET['pid']);   
// Getting Post Values    
$pname=$_POST['parentname'];
$paddress=$_POST['parentaddress'];
$prelstd=$_POST['relationwithstd'];
$pcontact=$_POST['parentcontact'];
$poccupation=$_POST['parentoccupation'];
$pjob=$_POST['parentjob'];
$peml=$_POST['pemail'];
$sql="update tblparents set parentName=:pname,parentAddress=:paddress,parentRelStudent=:prelstd,parentContact=:pcontact,parentOccupation=:poccupation,parentJob=:pjob,parentEmail=:peml where id=:parentid";
$query = $dbh->prepare($sql);
$query->bindParam(':pname',$pname,PDO::PARAM_STR);
$query->bindParam(':paddress',$paddress,PDO::PARAM_STR);
$query->bindParam(':prelstd',$prelstd,PDO::PARAM_STR);
$query->bindParam(':pcontact',$pcontact,PDO::PARAM_STR);
$query->bindParam(':poccupation',$poccupation,PDO::PARAM_STR);
$query->bindParam(':pjob',$pjob,PDO::PARAM_STR);
$query->bindParam(':parentid',$parentid,PDO::PARAM_STR);
$query->bindParam(':peml',$peml,PDO::PARAM_STR);
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
    <title>Parent Registration</title>
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
<!-- Javascript for checking username -->
<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'username='+$("#username").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
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
                    <li class="breadcrumb-item"><a href="#">Parent</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="toggle-right"></i></span></span>Add a Parent</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                     <form name="addparent" method="post">  
 <!-- Input Field for CSRF Token -->                       
<input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />

                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Fill the info</h5>
  <?php 
$parentid=intval($_GET['pid']);
$sql="SELECT  id,parentName,parentAddress,parentRelStudent,parentContact,parentOccupation,parentJob,parentUsername,regDate,parentEmail from tblparents where id=:pid ";
$query = $dbh -> prepare($sql);
$query->bindParam(':pid',$parentid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{ 
foreach($results as $result)
{?>   


                            <div class="row">
                                <div class="col-sm">
<div class="row">
<div class="col-md-2 mt-15">Parent Name : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="parentname" value="<?php echo htmlentities($result->parentName)?>" required="true" autofocus>
</div>
</div>  

<div class="row">
<div class="col-md-2 mt-25">Parent Address : </div>
<div class="col-md-6  mt-15">
<textarea name="parentaddress"  class="form-control"  required="true" placeholder="Enter parent address" autofocus><?php echo htmlentities($result->parentAddress)?></textarea> 
</div>
</div>

<div class="row">
<div class="col-md-2 mt-15">Relation with Student : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="relationwithstd" placeholder="Parent relation with student" required="true" value="<?php echo htmlentities($result->parentRelStudent)?>" autofocus>
</div>
</div>  

<div class="row">
<div class="col-md-2 mt-15">Parent Contact : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="parentcontact" placeholder="Parent Contact" pattern="[0-9]{10}" title="10 numeric characters only" value="<?php echo htmlentities($result->parentContact)?>" maxlength="10" required="true" autofocus>
</div>
</div>  


<div class="row">
<div class="col-md-2 mt-15">Parent Emailid : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="pemail"  value="<?php echo htmlentities($result->parentEmail)?>"  required="true" autofocus>
</div>
</div> 

<div class="row">
<div class="col-md-2 mt-15">Parent Occupation : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="parentoccupation" placeholder="Parent Occupation" required="true" value="<?php echo htmlentities($result->parentOccupation)?>" autofocus>
</div>
</div>  


<div class="row">
<div class="col-md-2 mt-15">Job : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" value="<?php echo htmlentities($result->parentJob)?>" name="parentjob" placeholder="job" required="true" autofocus>
</div>
</div>  


<div class="row">
<div class="col-md-2 mt-15">Username : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" value="<?php echo htmlentities($result->parentUsername)?>" name="username" id="username" readonly="true"  >
</div>
</div>  

<?php }} ?>


<div class="row">
<div class="col-md-2 mt-10">&nbsp;</div>
<div class="col-md-6 mt-10">
<button type="submit" name="submit" class="btn btn-primary" id="update">Update</button>
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
    <script src="dist/js/inputspinner-data.js"></script>
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