<?php include("../lib/smsinfo.php");

include("../dbinfo.php");
include("../lib/getval.php");
include("../lib/dboperation.php");
$cmn = new Comman();
$createdate = date('Y-m-d H:i:s');
$ipaddress = $cmn->get_client_ip();


$currdate = date('Y-m-d');
$closedate = date('Y-m-d', strtotime($currdate . ' +1 day'));




$openingbalance  =  $cmn->getcashopening($connection,$currdate);
$closingbalance = $cmn->getcashopening($connection,$closedate);

$currdate = date('Y-m-d');
$opendate = date('Y-m-d', strtotime($currdate . ' -1 day'));

$dieselopening = $cmn->getdieselopening($connection,$opendate);
$dieselclosing = $cmn->getdieselopening($connection,$currdate);



$msg = "Dear Sir, Today Opening Balance is $openingbalance and Closing Balance is $closingbalance\n From : BPS Transport";
$cmn->sendsms($username,$msg_token,$sender_id,$msg,"9893069157");
$cmn->sendsms($username,$msg_token,$sender_id,$msg,"9179432534");

$msg2="Dear Sir, Today Diesel Opening Liter is $dieselopening and Closing Liter is $dieselclosing\n From : BPS Transport";

$cmn->sendsms($username,$msg_token,$sender_id,$msg2,"9893069157");
$cmn->sendsms($username,$msg_token,$sender_id,$msg2,"9179432534");

echo "Msg senty suceessfully";





//$cmn->sendsms($username,$msg_token,$sender_id,$msg,"9179432534");
?>


<a href="dashboard.php"> Back </a> to Dashboard