<?php 
include("dbconnect.php");
$tblname = 'returnbidding_entry';
$tblpkey = 'bid_id';
$pagename  ='excel_emami_bilty_ereturn_report.php';
$modulename = "Return Billty Report";
$crit = "";
if(isset($_GET['fromdate']))
{
	$fromdate = trim(addslashes($_GET['fromdate']));
	
}
if(isset($_GET['todate']))
{
	
	$todate = trim(addslashes($_GET['todate']));
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}


 


if($fromdate !='' && $todate !='')
{
		$crit.=" and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$fromdate' and '$todate' ";	
}

if($_GET['consignorid']!=''){
 $consignorid=$_GET['consignorid'];
	$crit.=" and consignorid = '$consignorid' ";	
}
$consignorid='';

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="excel_emami_bilty_ereturn_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table border="1">
									<thead>
										<tr>
										<th width="2%" >Sn</th>
                        <th width="5%" >Truck Owner</th>
                        <th width="5%" >Vouchar No</th>
                      
                           <th width="5%" >Payment Date</th>
                           <th width="5%" >Bal Amount</th>
                 
										</tr>
									</thead>
                                    <tbody>
									<?php 

$sn=1;

 
if($ownerid=='' && $voucher_No==''){
   // echo "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.consignorid=4 && B.recweight !='0' && B.deletestatus!=1 Group by B.voucher_id,order by B.voucher_id  DESC";
	   $sel = "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 &&  B.recweight !='0'  && B.compid='$compid'  && B.sessionid='$sessionid' and B.deletestatus!=1 Group by B.voucher_id order by B.voucher_id  DESC limit 0,100";
}
else
{
	 $sel = "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.recweight !='0' && B.deletestatus!=1 && B.compid='$compid' && B.sessionid='$sessionid' Group by B.voucher_id order by B.voucher_id  DESC limit 0,100";

}
$res = mysqli_query($connection,$sel);
			while($row = mysqli_fetch_array($res))
			{
				$truckid = $row['truckid'];	
				$truckno = $row['truckno'];	
				$ownerid = $row['ownerid'];	
				$bid_id = $row['bid_id'];	
$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
 //  $vouchardate = $vocrow['createdate'];




$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
// $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
$truckowner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");


 $payment_date = $row['payment_date'];
	$voucher_id = $row['voucher_id'];
$vou_query="SELECT `payment_vochar` FROM `return_bulk_payment_vochar` WHERE `bulk_voucher_id`='$voucher_id' && compid='$compid' && sessionid= $sessionid";
		
		$voures = mysqli_query($connection,$vou_query);
			$vocrow = mysqli_fetch_array($voures);
			$voucharno= $vocrow['payment_vochar'];
			   $cuurentdate=date('Y-m-d');  

			   $voucher_amount= showBiltyVoucher1($connection,$compid,$voucher_id,$sessionid);	
			   $payamount = $cmn->getvalfield($connection,"return_bilty_payment_voucher","sum(payamount)","ownerid='$ownerid' && voucher_id='$voucher_id' && compid='$compid' && sessionid= $sessionid ");
		   
			  // $bal_amt=floatval($voucher_amount-$payamount);
			   $bal_amt = bcsub($voucher_amount, $payamount);
			  // if($bal_amt < 0){
			  //   $bal_amt=0;  
			//   }
			

?>
<tr>
<td><?php echo $sn++; ?></td>
  <td><?php echo $ownername; ?>
</td>

  <td><?php echo $voucharno; ?>
</td>
  <td><?php echo dateformatindia($payment_date); ?></td>
 <td><?php echo "Voucher Amt:" .$voucher_amount."<br>Paid :".$payamount."<br> Bal :".$bal_amt; ?>
</td>
 




 
</tr>
<?php 
}

?>
                                    
                                    
                    
							</table>


<script>window.close();</script>