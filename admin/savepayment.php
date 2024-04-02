<?php 
include("dbconnect.php");



	$other_deduct = $_POST['other_deduct'];
	$trip_id = $_POST['trip_id'];
	$short_deduct=$_POST['short_deduct'];
		$final_total=$_POST['final_total'];
	$tp_amount=$_POST['tp_amount'];
		$tp_id=$_POST['tp_id'];
		$payment_recive_id=$_POST['payment_recive_id'];
			$tds=$_POST['tds'];
		$tds_amt=$_POST['tds_amt'];
		
echo "INSERT INTO payment_recive SET trip_id='$trip_id',other_deduct='$other_deduct',short_deduct='$short_deduct',tp_id='$tp_id',final_total='$final_total',tp_amount='$tp_amount',recwt='$recwt',createdate='$createdate'";
if($payment_recive_id==0){
mysqli_query($connection,"INSERT INTO payment_recive SET trip_id='$trip_id',other_deduct='$other_deduct',short_deduct='$short_deduct',userid='$userid',tp_id='$tp_id',final_total='$final_total',tp_amount='$tp_amount',tds='$tds',tds_amt='$tds_amt',createdate='$createdate'");
// $action = 1;
   mysqli_query($connection,"UPDATE trip_entry set is_complete='1' where trip_id='$trip_id'");
} else {
    //  mysqli_query($connection,"UPDATE trip_entry set is_complete='1' where trip_id='$trip_id'");
     mysqli_query($connection,"UPDATE payment_recive set trip_id='$trip_id',other_deduct='$other_deduct',short_deduct='$short_deduct',userid='$userid',tp_id='$tp_id',final_total='$final_total',tp_amount='$tp_amount',tds='$tds',tds_amt='$tds_amt',updatedate='$createdate' where payment_recive_id='$payment_recive_id'");
}
			
		?>
		
	