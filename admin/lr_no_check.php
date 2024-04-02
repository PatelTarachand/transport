<?php
include("dbconnect.php");
$lr_no=$_POST['lr_no'];
  $query="SELECT * FROM `bidding_entry` WHERE lr_no='$lr_no'";
 $done=mysqli_query($connection,$query);
$count=mysqli_num_rows($done);

 if($count==1){
		echo "LR no. already available";
 }


 ?>

