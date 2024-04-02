<?php
include("../admin/dbconnect.php");
$id = addslashes($_REQUEST['id']);
$tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);

if($id!="" && $tblname!="")
{	
echo "update bidding_entry set is_invoice=0,invoiceid=0 where invoiceid='$id'";
	mysqli_query($connection,"update bidding_entry set is_invoice=0,invoiceid=0 where invoiceid='$id'");

		
	echo $sql_del="delete from $tblname where $tblpkey='$id'";
	echo $sql_del1="delete from  bill_details where billid='$id'";	
	$res = mysqli_query($connection,$sql_del)or die(mysqli_error()."Delete failed");
	$res1 = mysqli_query($connection,$sql_del1)or die(mysqli_error()."Delete failed");
	
}
?>