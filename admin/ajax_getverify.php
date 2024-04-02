<?php include("dbconnect.php");
include("../lib/smsinfo.php");

$bid_id = trim(addslashes($_REQUEST['bid_id']));

$code  = mt_rand(100000, 999999);

mysqli_query($connection,"update bidding_entry set otp='$code' where bid_id='$bid_id'");

$message = "Your 6 digit otp code is : $code \nFrom : Sarthak Logistics";

sendsmsGET("7999970685",$senderId,$routeId,$message,$serverUrl,$authKey);

?>