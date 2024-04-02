<?php
include("../admin/dbconnect.php");
$bid_id = $_REQUEST['bid_id'];

if($bid_id!="")
{
	$recweight = $cmn->getvalfield($connection,"returnbidding_entry","recweight"," bid_id = '$bid_id' && sessionid='$sessionid'");
	$sesno = "";
	$sortagr = $cmn->getvalfield($connection,"returnbidding_entry","sortagr"," bid_id = '$bid_id' && sessionid='$sessionid'");	
	
	
	if($recweight == '0')
	echo 1; 
	else if($sortagr != '0')
	echo 3;
	else if($recweight != '0') 
	echo 4;
	
}
?>