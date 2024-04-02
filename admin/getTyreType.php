<?php include("dbconnect.php");

$truckid= $_REQUEST['truckid']; 
$typeid= $cmn->getvalfield($connection,"m_truck","typeid","truckid='$truckid'");
echo $truvktype= $cmn->getvalfield($connection,"m_trucktype","noofwheels","typeid='$typeid'")
?>