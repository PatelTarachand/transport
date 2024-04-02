<?php
include("../admin/dbconnect.php");
$id = addslashes($_REQUEST['id']);
$tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);

if($id!="" && $tblname!="")
{
    $itemid =  $cmn->getvalfield($connection, "$tblname", "itemid", "$tblpkey='$id'");
    $purchaseid =  $cmn->getvalfield($connection, "$tblname", "purchaseid", "$tblpkey='$id'");
// echo "delete from purchaseorderserial where itemid='$itemid' and purchaseid='$purchaseid'";die;
	echo "delete from $tblname where $tblpkey='$id'";
	$sql_del="delete from $tblname where $tblpkey='$id'";
    $sql_del1="delete from purchaseorderserial where itemid='$itemid' and purchaseid='$purchaseid'";
	//$res=mysqli_query($connection,"Delete from $tblname where $tblpkey='$id'");
	$res = mysqli_query($connection,$sql_del)or die(mysqli_error()."Delete failed");
	$res1 = mysqli_query($connection,$sql_del1)or die(mysqli_error()."Delete failed");
	
}
?>