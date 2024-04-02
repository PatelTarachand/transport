<?php
 
 include("dbconnect.php");
 
  $id=$_GET['id'];
  $que="UPDATE `returnbidding_entry` SET `deletestatus`='1',is_complete=0,payment_date='0000-00-00' WHERE voucher_id='$id'";
  $del_que=mysqli_query($connection,$que);

 


?>