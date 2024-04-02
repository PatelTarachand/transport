<?php  
include("dbconnect.php");
$otp_bid_id = trim(addslashes($_REQUEST['otp_bid_id']));
$enterotp = trim(addslashes($_REQUEST['otp']));
$otp = $cmn->getvalfield($connection,"get_otp","otpcode","id='1'");
if($otp==$enterotp) {
        echo "1";
    }
    else
    echo "0";

?>