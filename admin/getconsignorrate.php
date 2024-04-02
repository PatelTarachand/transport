<?php error_reporting(0);
include("dbconnect.php");
$consignorid = trim(addslashes($_REQUEST['consignorid']));
$destinationid = trim(addslashes($_REQUEST['destinationid']));
$curdate = date('Y-m-d');


echo $cmn->getvalfield($connection,"consignor_ratesetting","rate","consignorid='$consignorid' && placeid='$destinationid' && setdate <='$curdate' order by rateid desc limit 1");


?>