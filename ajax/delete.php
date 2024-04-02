<?php
include("../admin/dbconnect.php");
$id = addslashes($_REQUEST['id']);
$tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);

if($id!="" && $tblname!="")
{

// 	echo "delete from $tblname where $tblpkey='$id'";
	$sql_del="delete from $tblname where $tblpkey='$id'";
// 	echo "delete from purchaseorderserial where purchaseid='$id'";die;
	$sql_del1="delete from purchase_trans where bill_id='$id'";
	$sql_del2="delete from purchaseorderserial where purchaseid='$id'";
	//$res=mysqli_query($connection,"Delete from $tblname where $tblpkey='$id'");
	$res = mysqli_query($connection,$sql_del)or die(mysqli_error()."Delete failed");
	$res = mysqli_query($connection,$sql_del1)or die(mysqli_error()."Delete failed");
		$res = mysqli_query($connection,$sql_del2)or die(mysqli_error()."Delete failed");
}
?>