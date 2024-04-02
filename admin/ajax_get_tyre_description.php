<?php
include("dbconnect.php"); 
$tid = $_REQUEST['tid'];

echo $cmn->getvalfield($connection,"tyre_purchase","tdescription","tid = '$tid'");
?>