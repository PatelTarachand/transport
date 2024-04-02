<?php
include("../admin/dbconnect.php");
$billid = addslashes($_REQUEST['billid']);
$tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);

 

if($billid!="" && $tblname!="")
{	

//echo $bid_id = $cmn->getvalfield($connection, "returnbill_details","bid_id" , "billid = '$billid'");
//echo "update bidding_entry  set is_invoice=0, invoiceid=0 where  bid_id ='$bid_id'";die;

      mysqli_query($connection,"delete from returnbill where billid ='$billid'");
	  mysqli_query($connection,"delete from returnbill_details where billid='$billid'");

echo "update returnbidding_entry  set is_invoice=0, invoiceid=0 where  invoiceid  in (select bid_id from returnbidding_entry where invoiceid='$billid')";die;
mysqli_query($connection,"update returnbidding_entry  set is_invoice=0, invoiceid=0 where  invoiceid  in (select bid_id from returnbidding_entry where invoiceid='$billid')");
	


	
	
}
?>