<?php
session_start();
error_reporting(0);
include('../includes/config.php');
// Verifying Admin login session
if(strlen($_SESSION['adid'])==0)
    {   
header('location:logout.php');
}
else{ 
//Code for change password
if(isset($_POST['change']))
  {
$password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$admnid=$_SESSION['adid'];
  $sql ="SELECT id FROM admin WHERE id=:admnid and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':admnid', $admnid, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update admin set Password=:newpassword where id=:admnid";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':admnid', $admnid, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Your Password succesfully changed";
}
else {
$error="Your current password is wrong";  
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Admin Change Password</title>
    <link href="../vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="../vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <!-- ION CSS -->
    <link href="../vendors/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" type="text/css">
    <link href="../vendors/ion-rangeslider/css/ion.rangeSlider.skinHTML5.css" rel="stylesheet" type="text/css">
    <!-- select2 CSS -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="../dist/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://formden.com/static/cdn/formden.js"></script>

<!-- Special version of Bootstrap that is isolated to content wrapped in .bootstrap-iso -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
<script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>

   <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
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
                    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container mt-40">
                <!-- Title -->
                <div class="hk-pg-header">
<h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="toggle-right"></i></span></span>Change Password</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                  <form role="form" method="post" onSubmit="return valid();" name="chngpwd">
                        <section class="hk-sec-wrapper">

   <!--Success / Error Message    -->                      
     <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>  
        <!-- End-->
                            <div class="row">
                                <div class="col-sm">







<div class="row">
<div class="col-md-2 mt-30">Current Password : </div>
<div class="col-md-6 mt-25">
       
<input class="form-control" type="password" name="password" autocomplete="off" required  />  
</div>
</div>


<div class="row">
<div class="col-md-2 mt-30">New Password : </div>
<div class="col-md-6 mt-25">
<input class="form-control" type="password" name="newpassword" autocomplete="off" required  />
</div>
</div>


<div class="row">
<div class="col-md-2 mt-30">Confirm Password : </div>
<div class="col-md-6 mt-25">
<input class="form-control"  type="password" name="confirmpassword" autocomplete="off" required  />
</div>
</div>

<div class="row">
<div class="col-md-2 mt-10">&nbsp;</div>
<div class="col-md-6 mt-10">
<button type="submit" class="btn btn-primary" id="submit" name="change">Change</button>
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
    <!-- FeatherIcons JavaScript -->
    <script src="../dist/js/feather.min.js"></script>
    <!-- Toggles JavaScript -->
    <script src="../vendors/jquery-toggles/toggles.min.js"></script>
    <script src="../dist/js/toggle-data.js"></script>
    <!-- Init JavaScript -->
    <script src="../dist/js/init.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

</body>
</html>
<?php } ?>