<?php include("dbconnect.php");
$bid_id = trim(addslashes($_REQUEST['bid_id']));
$otp = trim(addslashes($_REQUEST['otp']));

$otpcode = $cmn->getvalfield($connection,"bidding_entry","otp","bid_id='$bid_id'");

if($otp==$otpcode)
{
	echo 1;
}
else
{
	echo "0";
}
?>