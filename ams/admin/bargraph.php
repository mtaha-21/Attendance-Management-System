<?php
session_start();
    //Connect to database
    $dbc = mysqli_connect("localhost", "root","", "ams") or die("error connecting to database");

    //Create query to fetch the records

     $fdate=$_SESSION['fromdate'];
     $tdate=$_SESSION['todate'];
      $cname=$_SESSION['claname'];
      $asts= $_SESSION['atdstatus'];

if($asts=="present"){
    $query = "SELECT COUNT( * ) as visits , date(postingDate) as postingDate FROM  `tblattendance` where (attndStatus=1) and (date(postingDate) between '$fdate' and '$tdate') and (studentClass='$cname') GROUP BY date(postingDate)";
} 
else if($asts=="late"){
    $query = "SELECT COUNT( * ) as visits , date(postingDate) as postingDate FROM  `tblattendance` where (attndStatus=2) and (date(postingDate) between '$fdate' and '$tdate') and (studentClass='$cname') GROUP BY date(postingDate)";
} 


else {
$query = "SELECT COUNT( * ) as visits , date(postingDate) as postingDate FROM  `tblattendance` where (attndStatus=0) and (date(postingDate) between '$fdate' and '$tdate') and (studentClass='$cname') GROUP BY date(postingDate)";

}

    //Execute the query
    $visitors = mysqli_query($dbc, $query) or die("error executing the query");

    //Create an array to hold the records
    $records = array();

    //Retrive the records and add it to the array
    while($row  = mysqli_fetch_assoc($visitors)){
        $records[] = $row;
    }

    print(json_encode($records));

    //Clean up
    mysqli_free_result($visitors);

    //Close connection
    mysqli_close($dbc);
    
?>