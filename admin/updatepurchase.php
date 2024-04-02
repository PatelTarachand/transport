<?php 
include("dbconnect.php");

  
   $supplier_id=$_REQUEST['supplier_id'];
   
   echo "update purchase_entry  set is_complete=0  where is_complete=1 and purchase_id='$purchase_id";
   mysqli_query($connection, "update purchase_entry  set is_complete=0  where is_complete=1 and purchase_id='$purchase_id");

?>