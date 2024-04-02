<?php
include("../admin/dbconnect.php");
 echo $bid_id = addslashes($_REQUEST['bid_id']);
$billdetailid  = addslashes($_REQUEST['billdetailid']);
$tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);

if($bid_id!="" && $tblname!="")
{	
//echo "delete from bill_details where billdetailid='$billid'";die;
echo "update bidding_entry  set is_invoice=0, invoiceid=0 where  bid_id ='$bid_id'";

	mysqli_query($connection,"delete from bill_details where billdetailid='$billdetailid'");
	mysqli_query($connection,"update bidding_entry  set is_invoice=0, invoiceid=0 where  bid_id ='$bid_id'");

 
	
}
?>