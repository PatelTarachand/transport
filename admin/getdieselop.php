<?php error_reporting(0);
include("dbconnect.php");
//$currdate = date('Y-m-d');
$currdate = "2018-11-25";
$olddate = "2018-11-24";

 echo $cmn->getdieselopening($connection,$olddate);

echo "<br>";

 echo $cmn->getdieselopening($connection,$currdate);
?>