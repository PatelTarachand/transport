<?php
	session_start();
	include("dbinfo.php");
	include("lib/getval.php");
	
	
	$cmn = new Comman();
	$cmn->insertLoginLogout($connection,'logout',$_SESSION['userid'],$_SESSION['usertype'], $_SESSION['branchid'],$_SESSION['ipaddress'] );
	session_destroy();
	header("Location:index.php");
?>