<?php
session_start();
include("dbinfo.php");
include("lib/getval.php");
$cmn = new Comman();

if(isset($_POST['captcha_code'] ) && $_SESSION["code"]==$_POST['captcha_code'])
{
	// Captcha verification is Correct. Final Code Execute here!		
	 $_SESSION["code"] = '';
	//username and password sent from signup form 
	$user_name=isset($_REQUEST['user_name'])?addslashes(trim($_POST['user_name'])):'';
	$password=isset($_REQUEST['password'])?addslashes(trim($_POST['password'])):'';
	$sessionid=isset($_REQUEST['sessionid'])?addslashes(trim($_POST['sessionid'])):'';
		$compid=isset($_REQUEST['compid'])?addslashes(trim($_POST['compid'])):'';
		$curr_date=date('Y-m-d');
		$expiry_date =$cmn->getvalfield($connection,"panel_expiry","expiry_date","1=1");		
		$expirydate=strtotime($expiry_date); 
		$currdate=strtotime($curr_date);
	
	
  //code for checking admin login
	$sql_check = "SELECT * FROM m_userlogin WHERE username ='$user_name' and  password='$password'";
	//echo $sql_check;
	//echo "<br>";
	$res_check = mysqli_query($connection,$sql_check);
	$count_check = mysqli_num_rows($res_check);
	//die;
   
   
	if($count_check == 1)
	{  
	  $row_check = mysqli_fetch_array($res_check);
	  //set session value 
	  $branchcode = $row_check['branchcode'];

	  $_SESSION['userid'] = $row_check['userid'];
	  $_SESSION['username'] = $row_check['username'];
	  $_SESSION['usertype'] = $row_check['usertype'];
	  $_SESSION['branchcode'] = $row_check['branchcode'];
	  $_SESSION['branchid'] =  $row_check['branchid'];
	//  $branchid =  $_SESSION['branchid'];
	//  $_SESSION['compid'] =  $compid = $cmn->getvalfield($connection,"m_branch","compid","branchid=$branchid");
	  $_SESSION['sessionid'] =  $sessionid;
	    $_SESSION['compid'] =  $compid;
	  $_SESSION['ipaddress'] = $cmn->get_client_ip();
	 // $_SESSION['lastlogin'] = $cmn->getvalfield($connection,"logs_loginreport","max(logid)","usertype='admin' and process = 'login'");
	  $cmn->insertLoginLogout($connection,'login',$_SESSION['userid'],$_SESSION['usertype'],'',$_SESSION['ipaddress'] );
	 
		  if($_SESSION['usertype']=="admin" || $_SESSION['usertype']=="user")
		  {
			echo "<script>location='admin/dashboard.php'</script>";
		  }
		  else
		  {
			  echo "<script>location='superadmin/dashboard.php'</script>";
		  }
	}
	else
	echo "<script>location='index.php?msg=wrong'</script>";
}
else
{
	$msg1="Incorrect Capcha entered !!";
		echo "<script>location='index.php?msg1=$msg1'</script>";
}
?>