<?php 
include("dbconnect.php");
$qty = trim(addslashes($_REQUEST['qty']));
 $purchaseid =$_REQUEST['purchaseid'];

$itemid = trim(addslashes($_REQUEST['itemid']));
  $purdetail_id = trim(addslashes($_REQUEST['purdetail_id']));
  $pos_id = $_REQUEST['pos_id'];
 $serial_no = trim(addslashes($_REQUEST['serial_no']));
    $i = trim(addslashes($_REQUEST['i']));

// $totdata = $cmn->getvalfield($connection,"purchaseorderserial","count(pos_id)","serial_no='$serial_no' and purdetail_id=$purdetail_id");
  $totdata= $cmn->getvalfield($connection,"purchaseorderserial","count(pos_id)","itemid='$itemid' and loop_i='$i'and purchaseid='0'");
//  $totdata;

if( $purdetail_id==0  && $totdata==0){
	echo "insert into purchaseorderserial set serial_no='$serial_no',purdetail_id='$purdetail_id',purchaseid='$purchaseid',itemid='$itemid',loop_i='$i'";
mysqli_query($connection,"insert into purchaseorderserial set serial_no='$serial_no',purdetail_id='$purdetail_id',purchaseid='$purchaseid',itemid='$itemid',loop_i='$i'");
}else{
	echo "update purchaseorderserial set serial_no='$serial_no',purdetail_id='$purdetail_id' where  itemid='$itemid' and loop_i='$i'and purchaseid='$purchaseid'";
	mysqli_query($connection,"update purchaseorderserial set serial_no='$serial_no',purdetail_id='$purdetail_id',purchaseid='$purchaseid',itemid='$itemid' where  itemid='$itemid' and loop_i='$i'and purchaseid='$purchaseid'");
}


?>
