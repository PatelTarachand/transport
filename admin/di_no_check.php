<?php
include("dbconnect.php");
$gr_no=$_POST['gr_no'];
  $query="SELECT * FROM `bidding_entry` WHERE gr_no='$gr_no'";
 $done=mysqli_query($connection,$query);
$count=mysqli_num_rows($done);

 if($count==1){
		echo "DI no. already available";
 }


 ?>

