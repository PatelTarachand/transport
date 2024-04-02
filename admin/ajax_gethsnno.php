<?php error_reporting(0);
include("dbconnect.php");
$itemid = $_REQUEST['itemid'];



  $hsncode = $cmn->getvalfield($connection,"items","hsncode","itemid='$itemid'");
 $itemcatid = $cmn->getvalfield($connection,"items","itemcatid","itemid='$itemid'");
 echo $hsncode ."|" .$itemcatid;

 ?>