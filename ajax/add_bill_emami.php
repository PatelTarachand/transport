<?php
include("../admin/dbconnect.php");
$bid_id = $_REQUEST['bid_id'];


if($bid_id!="")
{
	$sql = mysqli_query($connection,"select *,DATE_FORMAT(tokendate,'%Y-%m-%d') as tokendate from bidding_entry where bid_id = '$bid_id' ");
	$row = mysqli_fetch_assoc($sql);
	$tokendate = $row['tokendate'];
	
	//get purchase order number
	$po_no ='';
	
	$bilty_no = $row['bilty_no'];
	$di_no = $row['di_no'];
	$sesno = $row['sesno'];
	$lr_no = $row['lr_no'];
	$invoiceno = $row['invoiceno'];
	$truckid = $row['truckid'];
	$tokendate = $row['tokendate'];
	$destinationid = $row['destinationid'];
	$totalweight = $row['totalweight'];
	$recweight = $row['recweight'];
	$gatepassno = "";
	$ewayno = $row['ewayno'];
	$rate = $row['comp_rate'];
	$adv_consignor = $row['adv_consignor'];
	$amount =($rate * $recweight) ;
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid = '$truckid'");
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid = '$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid = '$ownerid'");
	$placename = $cmn->getvalfield($connection,"m_place","placename","placeid = '$destinationid'");
	
	echo $cmn->dateformatindia($tokendate)."|".$ewayno."|".$sesno."|".$gatepassno."|".$truckno."|".$placename."|".$totalweight."|".$recweight."|".$rate."|".$amount."|".$po_no."|".$lr_no."|".$invoiceno."|".$bilty_no."|".$ownername."|".$adv_consignor;
}
?>