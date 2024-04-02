<?php
ini_set('memory_limit', '512M'); 
date_default_timezone_set("Asia/Kolkata");
if($_SERVER["SERVER_NAME"]=="localhost" || $_SERVER["SERVER_NAME"]=="ghanshyam"  || $_SERVER["SERVER_NAME"]=="trinityhome")
{
	$host_name="localhost";
	//$db_name="singh_new";
	$db_name="shrierp"; // DB change Date 1-06-2017
	$db_user="root";
	$db_pwd="";
}
else
{
		$host_name="localhost";
	$db_name="chaarlwg_trans_demo";
	$db_user="chaarlwg_trans_demo";
	$db_pwd="ZTt(jhH+t^&G";
	
}
$connection = mysqli_connect("$host_name","$db_user","$db_pwd",$db_name);

//$createdate = date('Y-m-d H:m:s');
?>