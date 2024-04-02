<?php 
error_reporting(0); 
include("dbconnect.php");

	if($usertype=='admin')
	{
	$crit=" where is_complete=0";
	}
	else
	{
	$crit=" where is_complete=0";	
	}	


 $bid_id = $_POST['bid_id'];
 $payNoIncre = $_POST['payNoIncre'];
 $payinvoice = $_POST['payinvoice'];
 $paidto = $_POST['paidto'];
 $remark = $_POST['remark'];
	 $rate_mt = trim(addslashes($_POST['rate_mt']));
	$othrcharrate = trim(addslashes($_POST['othrcharrate']));
	
	$newrate = trim(addslashes($_POST['newrate']));	  
	  $commission = trim(addslashes($_POST['commission']));
	  $tds_amt = trim(addslashes($_POST['tds_amt']));
	  $sortamount = trim(addslashes($_POST['sortamount']));
	
	$payment_date = $cmn->dateformatusa(trim(addslashes($_POST['payment_date'])));
		
	
	
		
	
  	
	
  if(($rate_mt !='' || $rate_mt !='0') )
	{
			
  $sql_update = "update bidding_entry set newrate='$newrate',trip_commission='$othrcharrate',freightamt='$rate_mt',payment_date='$payment_date',paidto='$paidto',remark='$remark',commission='$commission',tds_amt='$tds_amt',sortamount='$sortamount',is_complete='1',lastupdated=now(),voucher_id='$payNoIncre',
	ipaddress = '$ipaddress' where bid_id='$bid_id'"; 


			mysqli_query($connection,$sql_update);
			
				$que="UPDATE `bidding_entry` SET `deletestatus`='0' WHERE bid_id='$bid_id'";
  $del_que=mysqli_query($connection,$que);
			

			$vou_query="SELECT * FROM `bulk_payment_vochar` WHERE `bid_id`='$bid_id'"; $voures = mysqli_query($connection,$vou_query);
                      $vocrow = mysqli_fetch_array($voures);
                   if($vocrow==''){
					
			$paysql_update = "insert bulk_payment_vochar set payment_vochar='$payinvoice',bid_id='$bid_id',sessionid='$sessionid',compid='$compid',bulk_voucher_id='$payNoIncre'"; 

			mysqli_query($connection,$paysql_update);
			}
		//	echo "";
				
	}

?>