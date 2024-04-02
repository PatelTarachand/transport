<?php
 
 include("dbconnect.php");
 
   $id=$_GET['id'];
  $que="UPDATE `bidding_entry` SET `deletestatus`='0' WHERE voucher_id='$id'";
  $del_que=mysqli_query($connection,$que);

 if($del_que){
     
     header("Location: bulk_bilty_payment_emami_trash.php");
 }


?>