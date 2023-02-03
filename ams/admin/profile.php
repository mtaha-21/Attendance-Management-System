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
if(isset($_POST['update']))
{
//Verifying CSRF Token
if(!empty($_POST['csrftoken'])) {
if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
    //
$adminid=intval($_SESSION['adid']);
// Getting Post Values    
$adname=$_POST['fname'];
$ademail=$_POST['adminemail'];
$sql="update  admin set FullName=:adname,AdminEmail=:ademail where id=:adminid";
$query = $dbh->prepare($sql);
$query->bindParam(':adname',$adname,PDO::PARAM_STR);
$query->bindParam(':ademail',$ademail,PDO::PARAM_STR);
$query->bindParam(':adminid',$adminid,PDO::PARAM_STR);
$query->execute();
echo '<script> alert("Record updated successfully");</script>';
unset( $_SESSION['token']); // unset session token after submiiting

}
// if record already inserted
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
    <title>Admin Profile</title>
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
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="toggle-right"></i></span></span>Update Profile</h4>
                </div>
                <!-- /Title -->

<?php 
$adminid=intval($_SESSION['adid']);
$sql="SELECT  id,FullName,AdminEmail,UserName,updationDate from admin  where id=:adminid ";
$query = $dbh -> prepare($sql);
$query->bindParam(':adminid',$adminid,PDO::PARAM_STR);
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
                     <form name="addstudent" method="post">  
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Update the info</h5>
  <!-- Input Field for CSRF Token -->                       
<input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />         
                            <div class="row">
                                <div class="col-sm">

 
<?php if($result->updationDate!=""):?>
<div class="row">
<div class="col-md-2 mt-15">Last Updation date : </div>
<div class="col-md-6 mt-15">
<?php echo htmlentities($result->updationDate);?>
</div>
</div>  
<?php endif;?> 

<div class="row">
<div class="col-md-2 mt-15"> Name : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="fname"  required="true" value="<?php echo htmlentities($result->FullName);?>">
</div>
</div>  


<div class="row">
<div class="col-md-2 mt-15">Admin Email : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="email" name="adminemail" value="<?php echo htmlentities($result->AdminEmail);?>" required="true" >
</div>
</div>  

<div class="row">
<div class="col-md-2 mt-15">Username : </div>
<div class="col-md-6 mt-10">
<input class="form-control" type="text" name="staffusername" id="staffusername" value="<?php echo htmlentities($result->UserName);?>" readonly="true" title="UserName ca't be change." style="border:solid red 1px;">

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