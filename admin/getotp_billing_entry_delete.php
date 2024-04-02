<?php include("dbconnect.php");
// $billid = trim(addslashes($_REQUEST['billid']));
$otp = mt_rand(1000,9999);
echo "update get_otp set otpcode='$otp' where id='1'";
mysqli_query($connection,"update get_otp set otpcode='$otp' ");
$message = "Dear Sir, You 4 digit Code is $otp";
 echo $otp;
?> 