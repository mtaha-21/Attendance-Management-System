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

//Genrating CSRF Token
if(empty($_SESSION['token'])) {
$_SESSION['token'] = bin2hex(random_bytes(32));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Class Wise Report</title>
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
                    <li class="breadcrumb-item"><a href="#">Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Classwise Report</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container mt-40">
                <!-- Title -->
 <?php $fdate=$_SESSION['fromdate'];
 $tdate=$_SESSION['todate'];
  $claname=$_SESSION['claname'];

  ?>

                <div class="hk-pg-header">
<h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="toggle-right"></i></span></span>Attendance Report of <?php echo htmlentities($claname)?> class From <?php echo htmlentities($fdate);?> To <?php echo htmlentities($tdate);?></h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
     




<?php


//checking if attendance already marked
$sql="SELECT  distinct attndDate,COUNT(IF((attndStatus=1 and attndShift=1) ,0, NULL))  as shft1present,COUNT(IF((attndStatus=2 and attndShift=1) ,0, NULL))  as shft1late,COUNT(IF((attndStatus=0 and attndShift=1) ,0, NULL))  as shft1absent,COUNT(IF((attndStatus=1 and attndShift=2) ,0, NULL))  as shft2present,COUNT(IF((attndStatus=0 and attndShift=2) ,0, NULL))  as shft2absent,COUNT(IF((attndStatus=2 and attndShift=2) ,0, NULL))  as shft2late from tblattendance where studentClass=:clss and attndDate between :fdate and :tdate group by attndDate";
$query = $dbh -> prepare($sql);
$query->bindParam(':clss',$claname,PDO::PARAM_STR);
$query->bindParam(':fdate',$fdate,PDO::PARAM_STR);
$query->bindParam(':tdate',$tdate,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{

?>
   <section class="hk-sec-wrapper">

                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap mb-20">
                                        <div class="table-responsive">
                                            <table class="table table-primary table-bordered mb-0">
                                                <thead class="thead-primary">
                                                    <tr align="center">
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th colspan="3" >shift 1</th>
                                                        <th colspan="3">Shift 2</th>
                                                      </tr>
                                                      <tr align="center">
                                                        <th></th>
                                                        <th></th>
                                                        <th>Present</th>
                                                         <th>Late</th>
                                                        <th>Absent</th>
                                                         <th>Present</th>
                                                          <th>Late</th>
                                                        <th>Absent</th>
                                                      </tr>
                                                </thead>
                                                <tbody>

<?php 
foreach($results as $result)
{
    ?>
<tr align="center">
<th scope="row"><?php echo htmlentities($cnt);?></th>
<td><?php echo htmlentities($result->attndDate);?></td>
<td><?php echo htmlentities($s1p=$result->shft1present);?></td>
<td><?php echo htmlentities($s1l=$result->shft1late);?></td>
<td><?php echo htmlentities($s1a=$result->shft1absent);?></td>
<td><?php echo htmlentities($s2p=$result->shft2present);?></td>
<td><?php echo htmlentities($s2l=$result->shft2late);?></td>
<td><?php echo htmlentities($s2a=$result->shft2absent);?></td>
</tr>
      
<?php
$ts1p+=$s1p;
$ts1l+=$s1l;
$ts1a+=$s1a;
$ts2p+=$s2p;
$ts2l+=$s2l;
$ts2a+=$s2a;
$cnt++;
 }  ?>
 <tr align="center">
  <td colspan="2" style="font-weight:bold">Total</td>   
  <td><?php echo htmlentities($ts1p);?></td>
    <td><?php echo htmlentities($ts1l);?></td>
  <td><?php echo htmlentities($ts1a);?></td>
  <td><?php echo htmlentities($ts2p);?></td>
   <td><?php echo htmlentities($ts2l);?></td>
  <td><?php echo htmlentities($ts2a);?></td>
 </tr>

 <?php } else {?>


 <tr>
    <td colspan="4">Record Not Found</td>
 </tr>   
<?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                     
             

            
         
                   
                                </div>
                            </div>
                        </section>


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

</body>
</html>
<?php } ?>