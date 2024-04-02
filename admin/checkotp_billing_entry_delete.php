<?php include("dbconnect.php");
$paymentid = trim(addslashes($_REQUEST['ref_id']));
$otpcode = trim(addslashes($_REQUEST['otp']));
$otp = $cmn->getvalfield($connection,"get_otp","otpcode","id='1'");
if($otp==$otpcode) {
		echo "1";
	}
	else
	echo "0";

?>