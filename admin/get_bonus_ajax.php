<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$actual_avg = trim(addslashes($_REQUEST['actual_avg']));

echo $cmn->getvalfield($connection,"m_bonus","bonus_amt","'$actual_avg' between avg_from and avg_to");
?>