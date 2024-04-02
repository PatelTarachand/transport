<?php 

include("dbconnect.php");
 
  $id=$_REQUEST['id'];
 
   $que="DELETE FROM `bidding_entry` WHERE voucher_id='$id'";
 
  $del_que=mysqli_query($connection,$que);

 
 
?>