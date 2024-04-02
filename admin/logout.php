<?php error_reporting(0);
include("dbconnect.php");
	//$ipaddress = $cmn->get_client_ip();
	//$cmn->insertLoginLogout($connection,'logout',$_SESSION['userid'],$_SESSION['usertype'],'',$_SESSION['ipaddress'] );
	
	session_destroy();
	
	

	echo "<script>location='../index.php'</script>";
?>