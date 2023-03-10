<?php
session_start();
include('includes/config.php');
// Verifying Admin login session
if(strlen($_SESSION['adid'])==0)
    {   
header('location:logout.php');
}
else{ 
  // Code for staff deletion  
 if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from tblclasses  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$_SESSION['delmsg']="Record  deleted ";
header('location:manage-class.php');

}   
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Staff</title>
    <!-- Bootstrap table CSS -->
    <link href="../vendors/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Toggles CSS -->
    <link href="../vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="../vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
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
                    <li class="breadcrumb-item"><a href="#">Class</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="archive"></i></span></span>Manage Class Data</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Class Details</h5>

                        <section class="hk-sec-wrapper">
           
<!-- Printing Delete Message -->
<?php if($_SESSION['delmsg']!="")
    {?>
<p style="color:red">
<?php echo htmlentities($_SESSION['delmsg']); ?>
<?php echo htmlentities($_SESSION['delmsg']="");?> </p>
<?php } ?>

                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap mb-20">
                                        <div class="table-responsive">
                                            <table class="table table-primary table-bordered mb-0">
                                                <thead class="thead-primary">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Class</th>
                                                    
                                                        <th>Posting Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

<?php 
$sql="SELECT  id,className,postingDate from tblclasses ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
//Count Intializer
$cnt=1;
if($query->rowCount() > 0)
{ 
foreach($results as $result)
{?>
<tr>
<th scope="row"><?php echo htmlentities($cnt);?></th>
<td><?php echo htmlentities($result->className);?></td>
<td><?php echo htmlentities($result->postingDate);?></td>
<td>
<a href="edit-class.php?clid=<?php echo htmlentities($result->id);?>" title="Edit details">  <i class="icon-pencil"></i> </a>
<a href="manage-class.php?del=<?php echo htmlentities($result->id); ?>" title="Delete data" onClick="return confirm('Do you really want to delete');"><i class="icon-trash txt-danger"></i> </a></td>
</tr>
      
<?php
//Count Increment
$cnt++;
 }} ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                     
             

            
         
                   
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- /Row -->

            </div>
            <!-- /Container -->

   

        </div>
        <!-- /Main Content -->

    </div>
    <!-- HK Wrapper -->

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Slimscroll JavaScript -->
    <script src="../dist/js/jquery.slimscroll.js"></script>
    <!-- FeatherIcons JavaScript -->
    <script src="../dist/js/feather.min.js"></script>
    <!-- Fancy Dropdown JS -->
    <script src="../dist/js/dropdown-bootstrap-extended.js"></script>
    <!-- Bootstrap-table JavaScript -->
    <script src="../vendors/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script src="../dist/js/bootstrap-table-data.js"></script>
    <!-- Peity JavaScript -->
    <script src="../vendors/peity/jquery.peity.min.js"></script>
    <script src="../dist/js/peity-data.js"></script>
    <!-- Toggles JavaScript -->
    <script src="../vendors/jquery-toggles/toggles.min.js"></script>
    <script src="../dist/js/toggle-data.js"></script>
    <!-- Init JavaScript -->
    <script src="../dist/js/init.js"></script>
</body>
</html>
<?php } ?>