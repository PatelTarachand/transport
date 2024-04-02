<?php error_reporting(0);
include("dbconnect.php");
$truckid = trim(addslashes($_REQUEST['truckid']));

$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");

$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
$ownermob = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");
$owneraddress = $cmn->getvalfield($connection,"m_truckowner","owneraddress","ownerid='$ownerid'");

echo $ownername.'|'.$ownermob.'|'.$owneraddress;
?>