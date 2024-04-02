<?php error_reporting(0);
include("dbconnect.php");
$itemid = $_REQUEST['itemid'];



 echo $hsncode = $cmn->getvalfield($connection,"items","hsncode","itemid='$itemid'");
 
 ?>