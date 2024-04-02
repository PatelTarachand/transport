<?php 
 include("dbconnect.php");

 $trip_no=$_REQUEST['trip_no'];
$inc_ex_id=$_REQUEST['inc_ex_id'];
 // echo "update trip_expenses  set is_complete=1 where is_complete=0 and userid='$userid'and compid='$compid' and sessionid='$sessionid' && trip_no='trip_no'" 
  //  mysqli_query($connection, "update trip_expenses  set is_complete=1 where is_complete=0 and userid='$userid'and compid='$compid' and sessionid='$sessionid' && trip_no='$trip_no'");
	 $trip_expenses = $cmn->getvalfield($connection,"trip_expenses","sum(amt)"," trip_no='$trip_no'");
   $Selfamt = $cmn->getvalfield($connection,"trip_expenses","sum(amt)"," trip_no='$trip_no' && category='Self'");
    $Consignee = $cmn->getvalfield($connection,"trip_expenses","sum(amt)"," trip_no='$trip_no' && category='Consignee'");
    $Self=$Consignee +$Selfamt;
  echo $trip_expenses. " | ".$Self;
   ?>