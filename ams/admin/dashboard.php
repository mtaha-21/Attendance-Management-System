<?php
session_start();
//error_reporting(0);
include('../includes/config.php');
// Verifying Admin login session
if(strlen($_SESSION['adid'])==0)
    {   
header('location:logout.php');
}
else{ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>

    
    <!-- vector map CSS -->
 <link href="../vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />
    <!-- Toggles CSS -->
 <link href="../vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
 <link href="../vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
<!-- Toastr CSS -->
 <link href="../vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
<!-- Custom CSS -->
<link href="../dist/css/style.css" rel="stylesheet" type="text/css">

    <script src="includes/jquery.min.js"></script> 
     <script type="text/javascript" src="highcharts.js"></script>

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
                                                    <span class="d-block font-15 text-dark font-weight-500">Total Registered Students</span>
                                                </div>
                                            
                                            </div>
                                            <div>

<?php
// Query for total Registred Students
$sql="SELECT id from tblstudents";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalregstudents=$query->rowCount();
?>
<span class="d-block display-4 text-success mb-5"><?php echo htmlentities($totalregstudents);?> </span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                


                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-5">
                                                <div>
                                                    <span class="d-block font-15 text-dark font-weight-500">Total Registered Parent</span>
                                                </div>
                                            
                                            </div>
                                            <div>

<?php
// Query for total Registred parents
$sql1="SELECT id from tblparents";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
$totalregparents=$query1->rowCount();
?>  
<span class="d-block display-4 text-danger mb-5">
<?php echo htmlentities($totalregparents);?> </span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-5">
                                                <div>
                                                    <span class="d-block font-15 text-dark font-weight-500">Total Registered Staffs</span>
                                                </div>
                                            </div>
                                            <div>
<?php
// Query for total Registred staffs
$sql="SELECT id from tblstaff";
$query = $dbh -> prepare($sql);
$query->bindParam(':stdname',$stdname,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$totalregstaff=$query->rowCount();
?>
    
    <span class="d-block display-4 text-warning mb-5"><?php echo htmlentities($totalregstaff);?>  </span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-5">
                                                <div>
                                                    <span class="d-block font-15 text-dark font-weight-500">Total Listed Class</span>
                                                </div>
                                                
                                            </div>
                                            <div>

<?php
// Query for total Registred class
$sql1="SELECT id from tblclasses";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
$tlistedclasses=$query1->rowCount();
?>

<span class="d-block display-4 text-danger mb-5"><?php echo htmlentities($tlistedclasses);?></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        
                            
                            
                                    </div>
                                </div>



   <section class="hk-sec-wrapper">
                      <div class="row">
                                  <div class="col-xl-12">
               
                            <script type="text/javascript">
                                var studentcount = [];
                                var myCat =[];
                                </script>
                                <?php
                                $totaldays = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); 
                                
                                $month_array=array();
                                for($i=1; $i<=$totaldays; $i++)
                                {
                                    if(!array_key_exists($i,$month_array))
                                    {
                                        $key = '';
                                        if($i<10)
                                        {
                                            $key = '0'.$i;
                                            $month_array[$key] = 0;
                                        }
                                        else
                                        {
                                            $month_array[$i] = 0;
                                        }
                                        ?>
                                        <script type="text/javascript">
                                        var myKey = "Day " + '<?php echo htmlentities($i); ?>';
                                        
                                        myCat.push(myKey);
                                        </script>
                                        <?php
                                        
                                    }
                                    
                                    
                                }
                                //print_r($month_array);
 $sql ="SELECT attndDate from tblattendance where attndShift=1 ";
$query= $dbh -> prepare($sql);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($results as $row)
{
$user_date =$row->attndDate;
$dateArray = explode('-',$user_date);
$year = $dateArray[0];
$monthName = date("M", mktime(0, 0, 0, $dateArray[1], 10));
$currentMonth = date('m',mktime(0, 0, 0, $dateArray[1], 10));
                                     
if($year == date("Y") && $currentMonth == date("m"))
                                            {
                                                
                                                if(array_key_exists($dateArray[2],$month_array))
                                                {
                                                    $month_array[$dateArray[2]] = $month_array[$dateArray[2]] + 1;
                                                }
                                            }                                           
                                        }
                                    }
                                    //print_r($month_array);
                                    foreach($month_array as $key=>$value)
                                    {
                                    ?>
                                    <script type="text/javascript">
                                    studentcount.push(<?php echo htmlentities($value);?>);
                                    </script>
                                    <?php                                   
                                    }
                                    ?>
                                <script type="text/javascript">
                                var d = new Date();
                                var month = new Array();
                                month[0] = "January";
                                month[1] = "February";
                                month[2] = "March";
                                month[3] = "April";
                                month[4] = "May";
                                month[5] = "June";
                                month[6] = "July";
                                month[7] = "August";
                                month[8] = "September";
                                month[9] = "October";
                                month[10] = "November";
                                month[11] = "December";
                                var n = month[d.getMonth()];
var nnnn = d.getFullYear();
                                $(function () {
                                $('#container').highcharts({
                                    title: {
                                        text: 'Daily Shift 1 Attendance  Count  Chart of '+n+' '+nnnn,
                                        x: -20 //center
                                    },
                                    subtitle: {
                                        text: '',
                                        x: -20
                                    },
                                    xAxis: {
                                        categories: myCat
                                    },
                                    yAxis: {
                                        min:0,
                                        title: {
                                            text: 'Students Count'
                                        },
                                        plotLines: [{
                                            value: 0,
                                            width: 1,
                                            color: '#808080'
                                        }]
                                    },
                                    tooltip: {
                                        valueSuffix: ' Students Presents'
                                    },
                                    legend: {
                                        layout: 'vertical',
                                        align: 'right',
                                        verticalAlign: 'middle',
                                        borderWidth: 0
                                    },
                                    series: [{
                                        name: 'Attendance Count',
                                        data: studentcount
                                    }]
                                });
                            });
                                </script>
  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                
                    </div>
              </div>

                        </section>






  <section class="hk-sec-wrapper">
                      <div class="row">
                                  <div class="col-xl-12">
               
                            <script type="text/javascript">
                                var studentcount1 = [];
                                var myCat =[];
                                </script>
                                <?php
                                $totaldays = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); 
                                
                                $month_array=array();
                                for($i=1; $i<=$totaldays; $i++)
                                {
                                    if(!array_key_exists($i,$month_array))
                                    {
                                        $key = '';
                                        if($i<10)
                                        {
                                            $key = '0'.$i;
                                            $month_array[$key] = 0;
                                        }
                                        else
                                        {
                                            $month_array[$i] = 0;
                                        }
                                        ?>
                                        <script type="text/javascript">
                                        var myKey = "Day " + '<?php echo htmlentities($i); ?>';
                                        
                                        myCat.push(myKey);
                                        </script>
                                        <?php
                                        
                                    }
                                    
                                    
                                }
                                //print_r($month_array);
 $sql ="SELECT attndDate from tblattendance where attndShift=2 ";
$query= $dbh -> prepare($sql);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($results as $row)
{
$user_date =$row->attndDate;
$dateArray = explode('-',$user_date);
$year = $dateArray[0];
$monthName = date("M", mktime(0, 0, 0, $dateArray[1], 10));
$currentMonth = date('m',mktime(0, 0, 0, $dateArray[1], 10));
                                     
if($year == date("Y") && $currentMonth == date("m"))
                                            {
                                                
                                                if(array_key_exists($dateArray[2],$month_array))
                                                {
                                                    $month_array[$dateArray[2]] = $month_array[$dateArray[2]] + 1;
                                                }
                                            }                                           
                                        }
                                    }
                                    //print_r($month_array);
                                    foreach($month_array as $key=>$value)
                                    {
                                    ?>
                                    <script type="text/javascript">
                                    studentcount1.push(<?php echo htmlentities($value);?>);
                                    </script>
                                    <?php                                   
                                    }
                                    ?>
                                <script type="text/javascript">
                                var d = new Date();
                                var month = new Array();
                                month[0] = "January";
                                month[1] = "February";
                                month[2] = "March";
                                month[3] = "April";
                                month[4] = "May";
                                month[5] = "June";
                                month[6] = "July";
                                month[7] = "August";
                                month[8] = "September";
                                month[9] = "October";
                                month[10] = "November";
                                month[11] = "December";
                                var n = month[d.getMonth()];
var nnnn = d.getFullYear();
                                $(function () {
                                $('#container2').highcharts({
                                    title: {
                                        text: 'Daily Shift 2 Attendance  Count  Chart of '+n+' '+nnnn,
                                        x: -20 //center
                                    },
                                    subtitle: {
                                        text: '',
                                        x: -20
                                    },
                                    xAxis: {
                                        categories: myCat
                                    },
                                    yAxis: {
                                        min:0,
                                        title: {
                                            text: 'Students Count'
                                        },
                                        plotLines: [{
                                            value: 0,
                                            width: 1,
                                            color: '#808080'
                                        }]
                                    },
                                    tooltip: {
                                        valueSuffix: ' Students Presents'
                                    },
                                    legend: {
                                        layout: 'vertical',
                                        align: 'right',
                                        verticalAlign: 'middle',
                                        borderWidth: 0
                                    },
                                    series: [{
                                        name: 'Attendance Count',
                                        data: studentcount1
                                    }]
                                });
                            });
                                </script>
  <div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                
                    </div>
              </div>

                        </section>








                            </div>
                        </div>
                    </div>
             
           
    <!-- /HK Wrapper -->
    <!-- jQuery -->
  
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