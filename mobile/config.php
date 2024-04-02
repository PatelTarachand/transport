<?php
		//database configuration
		date_default_timezone_set("Asia/Kolkata");
			$host_name="localhost";
			$db_name="chaarqvc_shivalilogistics";
			$db_user="chaarqvc_shivalilogistics";
			$db_pwd="O&BT,FrMraVY";
		//connect databse
		$connection=mysqli_connect("$host_name","$db_user","$db_pwd","$db_name");
		if(!$connection){
			die("Failed to connect ");
		}
	
?>