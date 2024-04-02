<?php
session_start();
include("config.php");
		include("lib/dboperation.php");
		include("lib/getval.php");
		$cmn = new Comman();



$mobile=trim(addslashes($_REQUEST['mobile'])); 
$otp=trim(addslashes($_REQUEST['otp'])); 



$loginsessionid = $cmn->getvalfield($connection,"adduser","id","mobile='$mobile'");
echo $tot = $cmn->getvalfield($connection,"adduser","count(id)","mobile='$mobile' && checkotp='$otp'");
if($tot==1){
$_SESSION['loginid']=$loginsessionid;

}
