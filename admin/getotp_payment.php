<?php  include("dbconnect.php");

$bid_id = trim(addslashes($_REQUEST['bid_id']));
$otpcode = mt_rand(1000,9999);

mysqli_query($connection,"update get_otp set otpcode='$otpcode' ");

$message = "Dear Sir, You 4 digit Code is $otpcode";

 
 echo $otpcode;
?> 

