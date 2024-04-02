<?php
include("../admin/dbconnect.php");
echo $id = addslashes($_REQUEST['id']);
echo $tblname  = addslashes($_REQUEST['tblname']);
$tblpkey  = addslashes($_REQUEST['tblpkey']);
$pagename  = addslashes($_REQUEST['pagename']);
$modulename  = addslashes($_REQUEST['modulename']);
echo "update bidding_entry set isreceive=0,recbag=0,recweight=0,is_complete=0,recdate='0000-00-00' where bid_id='$id'";
	mysqli_query($connection,"update bidding_entry set isreceive=0,recbag=0,recweight=0,is_complete=0,recdate='0000-00-00' where bid_id='$id'");
?>