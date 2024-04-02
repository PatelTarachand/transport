<?php
include("dbconnect.php");

$tablename = $_REQUEST['tablename'];
$tableid = $_REQUEST['tableid'];
$id = $_REQUEST['id'];
// echo "update  trip_entry  set is_complete='0',bulk_vid='0' where bulk_vid='$id'";
  

$recamt = $cmn->getvalfield($connection, "voucher_pay", "amt", "pay_id='$id'");
$bulk_vid = $cmn->getvalfield($connection, "voucher_pay", "bulk_vid", "pay_id='$id'");
$totrecamt = $cmn->getvalfield($connection, "voucher_pay", "sum(amt)", "bulk_vid='$bulk_vid'");
$final= $totrecamt - $recamt;
$totamt = $cmn->getvalfield($connection, "payment_recive", "sum(final_total)", "bulk_vid='$bulk_vid'");
if($totamt > $final){
    
     // echo   "UPDATE payment_recive set is_pay='1', WHERE bulk_vid ='$bulk_vid'"; die;
     
     	mysqli_query($connection, "UPDATE trip_entry set is_paid='0' WHERE bulk_vid ='$bulk_vid'");
        mysqli_query($connection, "UPDATE payment_recive set is_pay='0' WHERE bulk_vid ='$bulk_vid'");
             mysqli_query($connection, "UPDATE voucher_entry set is_pay='0' WHERE bulk_vid ='$bulk_vid'");
}
   	$trans_id = $cmn->getvalfield($connection, "voucher_pay", "trans_id","pay_id='$id'");
    mysqli_query($connection,"delete from transaction where trans_id='$trans_id'");
// echo "delete from $tablename where $tableid=$id";
mysqli_query($connection,"delete from $tablename where $tableid=$id");
 // echo "update  trip_entry  set trip_expenses='$trip_expenses',net_amount='$net_amount' where trip_no='$trip_no'";





?>


