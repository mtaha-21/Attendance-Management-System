<?php
session_start();
include('../includes/config.php');
// Verifying Admin login session
if(strlen($_SESSION['stfid'])==0)
    {   
header('location:logout.php');
}
else{ 

//Genrating CSRF Token
if(empty($_SESSION['token'])) {
$_SESSION['token'] = bin2hex(random_bytes(32));
}
//Submmitting attendance
if(isset($_POST['markattndence']))
{
//Verifying CSRF Token
if(!empty($_POST['csrftoken'])) {
if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
// Getting  Values    
$staffid=$_SESSION['stfid'];
$stid=$_SESSION['stdid'];
$shift=$_SESSION['shift'];
$attendnce=$_POST['attendance'];
$class=$_SESSION['clss'];
$attdate=date('Y-m-d');
$pemail=$_POST['parentemail'];
//print_r($pemail);
$value=array_combine($stid,$attendnce);
//print_r($value);
//exit();
$i=0;
foreach($value as $sid=> $sattnd){

$sql="INSERT INTO  tblattendance(studentId,attndStatus,attndShift,attndDate,attndMarkBy,studentClass) VALUES(:stid,:attendnce,:shift,:attdate,:staffid,:class)";
$query = $dbh->prepare($sql);
$query->bindParam(':stid',$sid,PDO::PARAM_STR);
$query->bindParam(':attendnce',$sattnd,PDO::PARAM_STR);
$query->bindParam(':shift',$shift,PDO::PARAM_STR);
$query->bindParam(':attdate',$attdate,PDO::PARAM_STR);
$query->bindParam(':staffid',$staffid,PDO::PARAM_STR);
$query->bindParam(':class',$class,PDO::PARAM_STR);
$query->execute();
$to=$pemail[$i];

if($sattnd=="1"){
 $attvalue="Present";   
} else {
     $attvalue="Absent"; 
}
$subject="Regarding Attendance";
$headers .= "MIME-Version: 1.0"."\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$headers .= 'From:AMS <noreply@phpgurukul.com>'."\r\n";
$ms.="<html></body><div><div>Dear Parent,</div></br></br>";
$ms.="<div style='padding-top:8px;'>Your child  on $attdate in shift  $shift was $attvalue.
</div><div</body></html>";
mail($to,$subject,$ms,$headers);
$i++;
}
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{


echo '<script> alert("Attendance marked successfully");</script>';
unset( $_SESSION['token']); // unset session token after submiiting
}
// If query not run
else
{
 echo '<script> alert("Something went wrong. please try again."");</script>';
}
}
// if record already inserted
else {
 echo '<script> alert("Attendance already marked. Please fresh browser then try");</script>';
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Mark Attendance</title>
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
                    <li class="breadcrumb-item"><a href="#">Staff</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mark Attendance</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
<h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="toggle-right"></i></span></span>Mark Attendance</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                     <form name="slectclass" method="post">  
                        <section class="hk-sec-wrapper">
        
                            <div class="row">
                                <div class="col-sm">




<div class="row">
<div class="col-md-2 mt-15">Class : </div>
<div class="col-md-6 mt-10">
<select class="form-control" name="className" required="required">
<option value=""> Select </option>
<?php 
$sql = "SELECT distinct studentClass from  tblstudents order by studentClass";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->studentClass);?>">
<?php echo htmlentities($result->studentClass);?></option>
 <?php }} ?> 
</select>
</div>
</div>


<div class="row">
<div class="col-md-2 mt-15">Shift : </div>
<div class="col-md-6 mt-10">
<select class="form-control" name="shift" required="required">
<option value="1"> Shift 1 </option>
<option value="2"> Shift 2 </option>
</select>
</div>
</div>



<div class="row">
<div class="col-md-2 mt-10">&nbsp;</div>
<div class="col-md-6 mt-10">
<button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
</div>

                            </div>
                        </div>
                    </div>
                        </section>       
 </form>




<!-- Students on the Basis Class Selectin-->
<?php
if(isset($_POST['submit'])){
$clss=$_POST['className'];
$_SESSION['clss']=$clss;
$shift=$_POST['shift'];
$_SESSION['shift']=$shift;
$attdate=date('Y-m-d');

//checking if attendance already marked
$sql="SELECT  id from tblattendance  where studentClass=:clss and attndShift=:shift and attndDate=:attdate";
$query = $dbh -> prepare($sql);
$query->bindParam(':clss',$clss,PDO::PARAM_STR);
$query->bindParam(':shift',$shift,PDO::PARAM_STR);
$query->bindParam(':attdate',$attdate,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{ ?>
  <p style="color: red;">  <?php echo htmlentities("Today's Class attendance for this shift already marked"); ?></p>
<?php } else {

$sql="SELECT  tblstudents.id,studentName,studentClass,studentRollNumber,tblparents.parentEmail as pemail from tblstudents join tblparents on tblparents.id=tblstudents.parentId where studentClass=:clss ";
$query = $dbh -> prepare($sql);
$query->bindParam(':clss',$clss,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
//Count Intializer
$cnt=1;
//creating array for student id
$stddid=array();
if($query->rowCount() > 0)
{ 

?>
   <section class="hk-sec-wrapper">
 <form name="markattndence" method="post">        
  <!-- Input Field for CSRF Token -->                       
<input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" /> 

                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap mb-20">
                                        <div class="table-responsive">
                                            <table class="table table-primary table-bordered mb-0">
                                                <thead class="thead-primary">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Name</th>
                                                        <th>Class</th>
                                                        <th>Roll Number</th>
                                                        <th>Status</th>
                                                                                                     </tr>
                                                </thead>
                                                <tbody>

<?php 
foreach($results as $result)
{
 array_push($stddid,$result->id);

$_SESSION['stdid']=$stddid;
    ?>
<input type="hidden" name="parentemail[]" value="<?php echo $result->pemail; ?>">    
<tr>
<th scope="row"><?php echo htmlentities($cnt);?></th>
<td><?php echo htmlentities($result->studentName);?></td>
<td><?php echo htmlentities($result->studentClass);?></td>
<td><?php echo htmlentities($result->studentRollNumber);?></td>
<td><input type="radio" name="attendance[<?php echo $result->id; ?>]" value="1" required="true">P &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="attendance[<?php echo $result->id; ?>]" value="0" required="true">A </td>
</tr>
      
<?php
//Count Increment
$cnt++;
 } ?>
 <tr>
 <td colspan="4"><input type="submit" name="markattndence"> </td>
</tr>
<?php } else {?>


 <tr>
    <td colspan="4">Record Not found</td>
 </tr>   
<?php } }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                     
             

            
         
                   
                                </div>
                            </div>
                        </section>

</form>  
<?php } ?>
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