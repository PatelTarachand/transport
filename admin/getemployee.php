<?php 
include("dbconnect.php");
$empid = trim(addslashes($_REQUEST['empid']));
$lisenceno = $cmn->getvalfield($connection,"m_employee","lisenceno","empid='$empid'");
$mob1 = $cmn->getvalfield($connection,"m_employee","mob1","empid='$empid'");

echo $lisenceno."|".$mob1;
?>