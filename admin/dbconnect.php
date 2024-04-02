<?php 
session_start();
//print_r($_SESSION);
if(!isset($_SESSION['userid']) && (isset($_SESSION['usertype'])!="admin" || isset($_SESSION['usertype'])!="user"))
{
	echo "<script>location='../index.php?msg=invalid'</script>";
}

if(isset($_SESSION['sessionid'])=='') {
		echo "<script>location='../index.php?msg=invalid'</script>";
}
include("../dbinfo.php");
$userid = $_SESSION['userid'];

$usertype = $_SESSION['usertype'];
$sessionid = $_SESSION['sessionid'];
  $compid = $_SESSION['compid'];
include("../lib/getval.php");
include("../lib/dboperation.php");
$cmn = new Comman();
$user_companyid = $cmn->getvalfield($connection,"m_userlogin","consignorid","userid='$userid'");
 $gstvalid = $cmn->getvalfield($connection,"m_company","gstvalid","compid='$compid'");
$createdate = date('Y-m-d H:i:s');
$ipaddress = $cmn->get_client_ip();
$duplicate ='';


?>