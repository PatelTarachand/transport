<?php 
include("dbconnect.php");

   $remark = $_REQUEST['remark'];
    $pay_date = $_REQUEST['pay_date'];
 $paid_to = $_REQUEST['paid_to'];
$partyid = $_REQUEST['partyid'];
$bulk_vid=$_REQUEST['bulk_vid'];

 $voucher_no= $cmn->getcode($connection,"voucher_entry","voucher_no","1=1");
 if($bulk_vid==0){
   mysqli_query($connection, "INSERT into  voucher_entry set remark='$remark',voucher_no='$voucher_no',pay_date='$pay_date',paid_to='$paid_to',userid='$userid',partyid='$partyid',createdate='$createdate'");
   $lastid = $connection->insert_id;
   mysqli_query($connection,"UPDATE payment_recive set  bulk_vid='$lastid' WHERE bulk_vid ='0'" );
   mysqli_query($connection,"UPDATE trip_entry set  bulk_vid='$lastid' WHERE bulk_vid ='0' && is_complete=1" );
 }
 else {
     
       mysqli_query($connection,"UPDATE voucher_entry set remark='$remark',pay_date='$pay_date',paid_to='$paid_to',userid='$userid',updatedate='$createdate' WHERE bulk_vid ='$bulk_vid'" );
     
 }
   ?>