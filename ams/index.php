<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if(isset($_POST['login']))
{
  //code for captach verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    } 
        else {
//Getting Post values
$uname=$_POST['Username'];
//Encrypting password in to md5
$password=md5($_POST['password']);
$urole=$_POST['userrole'];

//for staff login
if($urole==1){
$sql ="SELECT staffName,id FROM  tblstaff WHERE staffUsername=:uname and staffPassword=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
 foreach ($results as $result) {
// creating session for staff id  
$_SESSION['stfid']=$result->id;
}
echo "<script type='text/javascript'> document.location ='staff/mark-attendance.php'; </script>";
}else{
echo "<script>alert('Invalid Details');</script>";
}
}
//for user/student login
if($urole==2){
$sql ="SELECT id,studentName FROM  tblstudents WHERE studentUsername=:uname and studentPassword=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
 foreach ($results as $result) {
// creating session for user/student id  
$_SESSION['stdid']=$result->id;
$_SESSION['stdname']=$result->studentName;
}
echo "<script type='text/javascript'> document.location ='student/dashboard.php'; </script>";
}else{
echo "<script>alert('Invalid Details');</script>";
}
}

//for parent login
if($urole==3){
$sql ="SELECT id,parentName FROM  tblparents WHERE parentUsername=:uname and parentPassword=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
 foreach ($results as $result) {
// creating session for parent id  
$_SESSION['prntid']=$result->id;
$_SESSION['parentName']=$result->parentName;
}
echo "<script type='text/javascript'> document.location ='parents/change-password.php'; </script>";
}else{
echo "<script>alert('Invalid Details');</script>";
}
}

//for admin login
if($urole==4){

$sql ="SELECT UserName,Password,id FROM admin WHERE UserName=:uname and Password=:password";

$query= $dbh -> prepare($sql);
$query-> bindParam(':uname', $uname, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)

{
foreach ($results as $result) {
// creating session for admin id  
$_SESSION['adid']=$result->id;

}

echo "<script type='text/javascript'> document.location ='admin/parent-reg.php'; </script>";

}else{

echo "<script>alert('Invalid Details');</script>";

}


}

}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>Attendance Monitoring System</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->
   
    <!-- HK Wrapper -->
    <div class="hk-wrapper">

        <!-- Main Content -->
        <div class="hk-pg-wrapper hk-auth-wrapper">
            <header class="d-flex justify-content-between align-items-center">
                <a class="d-flex auth-brand" href="#" style="font-size:32px; color:#000d1a">AMS (Attendance Monitoring System)
                 <!--   <img class="brand-img" src="dist/img/logo-dark.png" alt="brand" /> -->
                </a>
            </header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-5 pa-0">
                        <div id="owl_demo_1" class="owl-carousel dots-on-item owl-theme">
                         
                            <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url(dist/img/O70K6L0.jpg);">
                             
                                <div class="bg-overlay bg-trans-dark-50"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 pa-0">
                        <div class="auth-form-wrap py-xl-0 py-50">
                            <div class="auth-form w-xxl-55 w-xl-75 w-sm-90 w-xs-100">
                                <form method="post" name="login">
                                    <h1 class="display-4 mb-10">Welcome Back :)</h1>
                                    <p class="mb-30">Sign in to your account .</p>
<div class="form-group">
<input class="form-control" type="text" name="Username" placeholder="Username" required="true" autofocus>
</div>
                                    

<div class="form-group">
<div class="input-group">
<input class="form-control" placeholder="Password" name="password" type="password" required="true" autofocus>
<div class="input-group-append">
<span class="input-group-text"><span class="feather-icon"><i data-feather="eye-off"></i></span></span>
</div>
</div>
</div>
  
<div class="form-group">
<div class="input-group">
<select class="form-control"  name="userrole" required="true" >
<option value="">Select user</option>
<option value="1">Staff</option>
<option value="2">Sudent</option>
<option value="3"> Parent</option>
<option value="4"> Admin</option>
</select>    
</div>
</div>

<div class="row">
<div class="col-md-6 mt-15">
<input type="text" class="form-control" placeholder="Captcha"  name="vercode" maxlength="5" autocomplete="off"> </div>
<div class="col-md-6 mt-15">

<img src="captcha.php"  style="width:30%; border-radius: .25rem;font-size: 1rem; ">
</div> 
</div>
<button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
                
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Slimscroll JavaScript -->
    <script src="dist/js/jquery.slimscroll.js"></script>
    <!-- Fancy Dropdown JS -->
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <!-- Owl JavaScript -->
    <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <!-- FeatherIcons JavaScript -->
    <script src="dist/js/feather.min.js"></script>
    <!-- Init JavaScript -->
    <script src="dist/js/init.js"></script>
    <script src="dist/js/login-data.js"></script>
</body>

</html>