<?php error_reporting(0);
include("dbconnect.php");
$truckid = $_REQUEST['truckid'];

$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
 $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
$empname = $cmn->getvalfield($connection,"m_employee","empname","truckid='$truckid' and designation='1'");
echo $ownername ."|" .$empname;
?>