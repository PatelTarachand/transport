<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$drivername = trim(addslashes($_REQUEST['drivername']));

if($drivername !='')
{
$chkcnt = $cmn->getvalfield($connection,"bilty_entry","count(*)","drivername='$drivername'");
if($chkcnt !='0')
{
	echo "1";
}	
else
{
	echo "0";
}
}
?>