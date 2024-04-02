<?php 
include("dbconnect.php");

   $inc_ex_id = $_REQUEST['inc_ex_id'];
    $amt = $_REQUEST['amt'];
 $trip_no = $_REQUEST['trip_no'];
   $category = $_REQUEST['category'];
   $loding_date = $_REQUEST['loding_date'];
   $truckid = $_REQUEST['truckid'];
     $totalamt = $cmn->getvalfield($connection,"trip_expenses","sum(amt)","trip_no=$trip_no");

  // echo "INSERT into trip_expenses set inc_ex_id='$inc_ex_id',amt='$amt',category='$category',exp_date='$loding_date',userid='$userid',truckid='$truckid',createdate='$createdate',sessionid='$sessionid',trip_no='$trip_no',compid='$compid'" ;
   mysqli_query($connection, "INSERT into trip_expenses set inc_ex_id='$inc_ex_id',amt='$amt',exp_date='$loding_date',category='$category',userid='$userid',truckid='$truckid',createdate='$createdate',sessionid='$sessionid',trip_no='$trip_no',compid='$compid'");
   $action = 1;
   $process = "insert";
   echo "1";
   ?>