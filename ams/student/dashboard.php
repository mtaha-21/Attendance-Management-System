<?php
session_start();
error_reporting(0);
include('../includes/config.php');
// Verifying Admin login session
if(strlen($_SESSION['stdid'])==0)
    {   
header('location:logout.php');
}
else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>

	
	<!-- vector map CSS -->
    <link href="../vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />

    <!-- Toggles CSS -->
    <link href="../vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="../vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
	
	<!-- Toastr CSS -->
    <link href="../vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">

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
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
            
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hk-row">
							<div class="col-sm-12">
								<div class="card-group hk-dash-type-2">
									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Shift 1</span>
												</div>
											
											</div>
											<div>

<?php
$stdname=$_SESSION['stdid'];
//checking if attendance already marked
$sql="SELECT attndStatus from tblattendance
where  studentId=:stdname and attndShift=1 and attndStatus=1 and attndDate>= DATE(NOW()) - INTERVAL 30 DAY";
$query = $dbh -> prepare($sql);
$query->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$counts1=$query->rowCount();
?>
<span class="d-block display-4 text-success mb-5"><?php echo htmlentities($counts1);?> Day Present</span>
												<small class="d-block">In Last 30 Days</small>
											</div>
										</div>
									</div>
								
	<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Shift 1</span>
												</div>
											
											</div>
											<div>

<?php
$stdname=$_SESSION['stdid'];
//checking if attendance already marked
$sql="SELECT attndStatus from tblattendance
where  studentId=:stdname and attndShift=1 and attndStatus=2 and attndDate>= DATE(NOW()) - INTERVAL 30 DAY";
$query = $dbh -> prepare($sql);
$query->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$counts1=$query->rowCount();
?>
<span class="d-block display-4  mb-5" style="color: blue"><?php echo htmlentities($counts1);?> Day Late</span>
												<small class="d-block">In Last 30 Days</small>
											</div>
										</div>
									</div>

									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Shift 1</span>
												</div>
											
											</div>
											<div>

<?php
$stdname=$_SESSION['stdid'];
//checking if attendance already marked
$sql1="SELECT attndStatus from tblattendance
where  studentId=:stdname and attndShift=1 and attndStatus=0 and attndDate>= DATE(NOW()) - INTERVAL 30 DAY";
$query1 = $dbh -> prepare($sql1);
$query1->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
$counts1absent=$query1->rowCount();
?>	
<span class="d-block display-4 text-danger mb-5">
<?php echo htmlentities($counts1absent);?> Day Absent</span>
												<small class="d-block">In Last 30 Days</small>
											</div>
										</div>
									</div>
								
									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Shift 2</span>
												</div>
											</div>
											<div>
<?php
$stdname=$_SESSION['stdid'];
//checking if attendance already marked
$sql="SELECT attndStatus from tblattendance
where  studentId=:stdname and attndShift=2 and attndStatus=1 and attndDate>= DATE(NOW()) - INTERVAL 30 DAY";
$query = $dbh -> prepare($sql);
$query->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$counts2=$query->rowCount();
?>
	
    <span class="d-block display-4 text-success mb-5"><?php echo htmlentities($counts2);?> Day Present </span>
												<small class="d-block">In Last 30 Days</small>
											</div>
										</div>
									</div>
								


			<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Shift 2</span>
												</div>
											</div>
											<div>
<?php
$stdname=$_SESSION['stdid'];
//checking if attendance already marked
$sql="SELECT attndStatus from tblattendance
where  studentId=:stdname and attndShift=2 and attndStatus=2 and attndDate>= DATE(NOW()) - INTERVAL 30 DAY";
$query = $dbh -> prepare($sql);
$query->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$counts2=$query->rowCount();
?>
	
    <span class="d-block display-4 mb-5" style="color:blue"><?php echo htmlentities($counts2);?> Day Late </span>
												<small class="d-block">In Last 30 Days</small>
											</div>
										</div>
									</div>




									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Shift 2</span>
												</div>
												
											</div>
											<div>

<?php
$stdname=$_SESSION['stdid'];
//checking if attendance already marked
$sql1="SELECT attndStatus from tblattendance
where  studentId=:stdname and attndShift=2 and attndStatus=0 and attndDate>= DATE(NOW()) - INTERVAL 30 DAY";
$query1 = $dbh -> prepare($sql1);
$query1->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
$counts2absent=$query1->rowCount();
?>

<span class="d-block display-4 text-danger mb-5"><?php echo htmlentities($counts2absent);?> Day Absent</span>
												<small class="d-block">In Last 30 Dayss</small>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>
						
							
							
									</div>
								</div>



<?php

$stdname=$_SESSION['stdid'];
//checking if attendance already marked
$sql="SELECT tblattendance.attndDate,
max(case when  studentId=:stdname and attndShift=2 and attndDate >= DATE(NOW()) - INTERVAL 10 DAY   then tblattendance.attndStatus end) as s2,
max(case when  studentId=:stdname and attndShift=1 and attndDate>= DATE(NOW()) - INTERVAL 10 DAY then tblattendance.attndStatus end) as s1
from tblattendance GROUP by attndDate";
$query = $dbh -> prepare($sql);
$query->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{

?>
   <section class="hk-sec-wrapper">
<p class="lead" align="center" style="font-size:22px;">Your Last 10  attendance
                                    </p>
                                    <hr/>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap mb-20">
                                        <div class="table-responsive">
                                            <table class="table table-primary table-bordered mb-0">
                                                <thead class="thead-primary">
                                                    <tr align="center">
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th  >shift 1</th>
                                                        <th>Shift 2</th>
                                                      </tr>
                                                 
                                                </thead>
                                                <tbody>

<?php 
foreach($results as $result)
{
    $a=$result->s1;
    $b=$result->s2;
    ?>
<tr align="center">
<th scope="row"><?php echo htmlentities($cnt);?></th>
<td><?php echo htmlentities($result->attndDate);?></td>
<td>
<?php if($a==1){?>
<span style="color:green">Present</span>
<?php } else if($a=='0') { ?>
<span style="color:red">Absent</span>

<?php } elseif(is_null($a)) { ?>
<span style="color:red">Not Marked</span>
<?php } else if ($a=="2") { ?>
    <span style="color:blue">Late</span>
<?php } ?>
</td>
<td>
<?php if($b==1){?>
<span style="color:green">Present</span>
<?php } else if($b=='0') { ?>
<span style="color:red">Absent</span>

<?php } elseif(is_null($b)) { ?>
<span style="color:red">Not Marked</span>
<?php }  else if($b=="2") { ?>
    <span style="color:blue">Late</span>
<?php } ?>
</td>

</tr>
      
<?php
$cnt++;
 }   } else {?>


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
						</div>
					</div>
             
           
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Slimscroll JavaScript -->
    <script src="../dist/js/jquery.slimscroll.js"></script>

    <!-- Fancy Dropdown JS -->
    <script src="../dist/js/dropdown-bootstrap-extended.js"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="../dist/js/feather.min.js"></script>

    <!-- Toggles JavaScript -->
    <script src="../vendors/jquery-toggles/toggles.min.js"></script>
    <script src="../dist/js/toggle-data.js"></script>
	
	<!-- Counter Animation JavaScript -->
	<script src="../vendors/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="../vendors/jquery.counterup/jquery.counterup.min.js"></script>
	
	<!-- EChartJS JavaScript -->
    <script src="../vendors/echarts/dist/echarts-en.min.js"></script>
    
	<!-- Sparkline JavaScript -->
    <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
	
	<!-- Vector Maps JavaScript -->
    <script src="../vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../dist/js/vectormap-data.js"></script>

	<!-- Owl JavaScript -->
    <script src="../vendors/owl.carousel/dist/owl.carousel.min.js"></script>
	
	<!-- Toastr JS -->
    <script src="../vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    
    <!-- Init JavaScript -->
    <script src="../dist/js/init.js"></script>
	<script src="../dist/js/dashboard-data.js"></script>
	
</body>
</html>
<?php } ?>