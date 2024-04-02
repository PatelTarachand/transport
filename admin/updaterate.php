<?php error_reporting(0);
include("dbconnect.php");
$newrate = trim(addslashes($_REQUEST['newrate']));
$bilty_id = trim(addslashes($_REQUEST['bilty_id']));
$rate_mt = trim(addslashes($_REQUEST['rate_mt']));

	mysqli_query($connection,"update bilty_entry set newrate='$newrate',rate_mt='$rate_mt' where bilty_id='$bilty_id'");
	
	echo 1;
?>