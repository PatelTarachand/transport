<?php //error_reporting(0);
include("dbconnect.php");
$consignorid = trim(addslashes($_REQUEST['consignorid']));

$count = $cmn->getvalfield($connection,"bilty_entry","count(*)","consignorid='$consignorid' && sessionid='$sessionid'");

if($count==0)
{
$billtyno = $cmn->getvalfield($connection,"consignor_prefixsetting","consignor_prefix","consignorid='$consignorid' && sessionid='$sessionid'").$cmn->getcode($connection,"bilty_entry","billtyno","consignorid='$consignorid' && sessionid='$sessionid'");
}
else
{
	$billtyno = $cmn->getcode($connection,"bilty_entry","billtyno","consignorid='$consignorid' && sessionid='$sessionid'");	
}

$placeid = $cmn->getvalfield($connection,"m_consignor","placeid","consignorid='$consignorid'");

echo $billtyno.'|'.$placeid;
?>