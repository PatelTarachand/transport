<?php 
include("dbconnect.php");

$str=$_POST['ids'];
$array=explode(",",$str);
$sizeof= sizeof($array);
$status=$_POST['status'];


if($status=='1'){
    
    for($i=0; $i<$sizeof; $i++) {
   $sql="UPDATE `bidding_entry` SET `payment_status`='1' WHERE bid_id=$array[$i]"; 
   $sql = mysqli_query($connection,$sql);
    }
  
}
else if($status=='2'){
    
     for($i=0; $i<$sizeof; $i++) {
   $sql="UPDATE `bidding_entry` SET `payment_status`='2' WHERE bid_id=$array[$i]"; 
   $sql = mysqli_query($connection,$sql);
    }
    
}
else if($status=='3'){
    
     for($i=0; $i<$sizeof; $i++) {
   $sql="UPDATE `bidding_entry` SET `payment_status`='3' WHERE bid_id=$array[$i]"; 
   $sql = mysqli_query($connection,$sql);
    }
}
else if($status=='4'){
    
     for($i=0; $i<$sizeof; $i++) {
   $sql="UPDATE `bidding_entry` SET `payment_status`='4' WHERE bid_id=$array[$i]"; 
   $sql = mysqli_query($connection,$sql);
    }
}

?>