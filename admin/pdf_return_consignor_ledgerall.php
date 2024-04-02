<?php include("dbconnect.php");

include("mpdf/mpdf.php");
$pagename = 'pdf_return_consignor_ledgerall.php';
$pageheading = "Customer Transaction Detail";
$mainheading = "Customer Transaction Detail";
$cond=" ";
$cond1=" ";
if(isset($_GET['search']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
	
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-1 year',strtotime($todate)));
	
}

if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));	
}
else
$consignorid = '';

if(isset($_GET['billid']))
{
	$billid = trim(addslashes($_GET['billid']));	
}
else
$billid = '';



if($fromdate !='' && $todate !='')
{ 
		$cond.=" and billdate between '$fromdate' and '$todate' ";	
		$cond1.=" and receive_date between '$fromdate' and '$todate' ";	
}

if($consignorid !='') {
	
	$cond .=" and consignorid='$consignorid'";
	$cond1 .=" and consignorid='$consignorid'";
	
	}
	if($billid !='') {
	
	$cond .=" and billid='$billid'";
	$cond1 .=" and billid='$billid'";
	
	}
$companymob1 = $cmn->getvalfield($connection,"m_company","mobileno1","compid='$_SESSION[compid]'");
$companyname = $cmn->getvalfield($connection,"m_company","cname","compid='$_SESSION[compid]'");
 $html="

<table border='0' style='width:100%;'> 
 <tr>  
   
<th align='center' colspan='3'><span style='font-size:18px;'>$companyname</span></th>
	
	</tr>
	<tr>  
   
<th align='center' colspan='3'><span style='font-size:18px;'>$companymob1</span></th>
	
	</tr>

   <tr>  
   
	<th align='center' colspan='3'><span style='font-family:ind_hi_1_001;'>CONSIGNOR PAYMENT LEDGER</span></th>
	



	

	

</table>";

$html .="<hr>";
 						
 						$html .="<table border='0'  style='width:100%;'>
	
	</table>";
	
 $html .= "<div>
 <div width='34%'><strong>Opening Balance: <i class='fa fa-inr'></i>$prevbalance</strong>
							 </div>
 ";
  $html .= "<div style='float:left; width:100%' >";

  $html .="
					<table border='1' cellspacing='0'>
					<thead>
					<tr>
					<th colspan='10' align='center'><strong> Billing Detail</strong></th>
					</tr>
					<tr>
					<th>S No</th> 
						<th>Consignor Name</th>
					<th>Bill No.</th>                                                
					<th>Bill Date</th>
					<th>Advance Amount</th>
					<th>Bill Amount</th>
					<th>Balance Amount</th>
					
					
					 </tr>

					</thead>
					<tbody>
					
					
					</tr>";
							$slno=1;
							if($consignorid == 'all'){
								$sql_table = "SELECT * FROM `returnbill` WHERE sessionid='$sessionid' and compid='$compid' and consi_type='Consignor' ";
							 }else{
							   $sql_table = "SELECT * FROM `returnbill` WHERE sessionid='$sessionid' and compid='$compid' $cond and consi_type='Consignor'";
							 }
													
							// $sql_table = "SELECT * FROM `returnbill` WHERE sessionid='$sessionid' and compid='$compid' $cond";
											$res_table = mysqli_query($connection,$sql_table);
											while($row = mysqli_fetch_assoc($res_table))
											{
												$consignorname =  $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'");	
									$billno =  $cmn->getvalfield($connection,"returnbill","billno","billid='$row[billid]'");
									$billdate =  $cmn->getvalfield($connection,"returnbill","billdate","billid='$row[billid]'");
									$availbill =  $cmn->getvalfield($connection,"return_consignor_payment","count(billid)","billid='$row[billid]' and compid='$compid'");
 	 	//	$totamount=($bill_amount-$advamount);
 	 		
 	 			$advamount1 = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consignorid='$row[consignorid]' && invoiceid='$row[billid]' ");
 	
	 $tdsamt1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(tdsamt)","consignorid='$row[consignorid]' && billid='$row[billid]' ");
		
				 $bill_amount1= $cmn->get_total_billing_amt($connection,"$row[billid]");
	 $payamount1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(payamount)","consignorid='$row[consignorid]' && billid='$row[billid]' ");
	 $deduct_amount1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(deduct_amount)","consignorid='$row[consignorid]' && billid='$row[billid]' ");	
												
											$bal_amt1=($bill_amount1-$advamount1-$deduct_amount1-$tdsamt1)-($payamount1);
		if($bal_amt1>1){
            $bal_amt2 =number_format($bal_amt1,2);
 	 			$netbilty += $bal_amt1;	
	$html.= "



	<tr>
				<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'>$slno</td>
					<td align='left'><span style='font-family:ind_hi_1_001;font-size:12px;'>$consignorname</td>
				<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'> $billno</td>
				<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'> $billdate</td>
				<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'> $advamount1</td>
				<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'> $bill_amount1</td>
				<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'><i class='fa fa-inr'>$bal_amt2</i>   </td>
				

	</tr>

	";
$slno++;

$netbilty1 += $bal_amt1;
									}	}
	
	$nettotal = number_format($netamt,2);	
	$html.= "
	<tr>
	<td align='left'><span style='font-size:10px;'><span></td>
	<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'><strong></strong></span></td>
	<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'><strong></strong></span></td>
	<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'><strong></strong></span></td>
	<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'><strong></strong></span></td>
	<td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'><strong>Total</strong></span></td>
    <td align='right'><span style='font-family:ind_hi_1_001;font-size:12px;'>$netbilty1</span></td>
	</tr>
	";
	$html .="
	</table>";	
	$html .="
	</div>";


 
//==============================================================
$mpdf=new mPDF('utf-8','A4');

$mpdf->AddPage('P','','','','','4','4','4','4');
$mpdf->WriteHTML($html);
$mpdf->SetTitle('pdf_return_consignor_ledgerall');

$mpdf->Output();
?>
            	
<?php
mysqli_close($db_link);
?>
<span style="font-size:9px">