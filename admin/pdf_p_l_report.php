<?php
include("dbconnect.php");
   include("mpdf/mpdf.php");
   $tblname = "bidding_entry";
$tblpkey = "bid_id";
$pagename = "bulk_bilty_payment_emami_report.php";
$modulename = " Profit And Loss  Report";
include("../lib/smsinfo.php");
if (isset($_GET['month'])) {
	$month = trim(addslashes($_GET['month']));
} else {
	$month = date('m');
}


if (isset($_GET['year'])) {
	$year = trim(addslashes($_GET['year']));
} else
	$year = '2024';

if ($month != '') {
	$fromdate = date("$year-$month-01");
	$todate = date("Y-m-t", strtotime($fromdate));
}

if ($fromdate != '' && $todate != '') {
	$crit .= "tokendate BETWEEN  '$fromdate' and  '$todate' ";
	$crit1 .= "service_date BETWEEN  '$fromdate' and  '$todate' ";
	$crit2 .= "maint_date BETWEEN  '$fromdate' and  '$todate' ";
	$crit3 .= "pay_date BETWEEN  '$fromdate' and  '$todate' ";
	$crit4 .= "billdate BETWEEN  '$fromdate' and  '$todate' ";
	$crit6 .= "payment_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if (isset($_GET['truckid'])) {
	$truckid = trim(addslashes($_GET['truckid']));
} else {
	$truckid = '';
}


if ($truckid != '') {

	$crit .= "and truckid='$truckid'  ";
	$crit1 .= "and truckid='$truckid'  ";
	$crit2 .= "and truckid='$truckid'  ";
	$crit3 .= "and truckid='$truckid'  ";
	$crit5 .= "and truckid='$truckid'  ";
	$crit6 .= "and truckid='$truckid'  ";
}
$fromdate1=dateformatindia($fromdate);
$todate1=dateformatindia($todate);
 
   $companymob1 = $cmn->getvalfield($connection,"m_company","mobileno1","compid='$_SESSION[compid]'");
   $email_id = $cmn->getvalfield($connection,"m_company","email_id","compid='$_SESSION[compid]'");
   $companyname = $cmn->getvalfield($connection,"m_company","cname","compid='$_SESSION[compid]'");
   $consignorname =  $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'");
   // $cust_name = $cmn->getvalfield($connection, "customer_master", "cust_name", "customer_id='$customer_id'");
   $com_name = $cmn->getvalfield($connection, "company_master", "com_name", "company_id=$company_id");
  
   
   // echo "select * from employee_payment $crit3 and is_complete=1 order by emppay_id desc";die;
   $html = "
   <div style=' border: 1px solid;width:100%;height:100%;'>
   <table border='0' style='border-collapse:collapse;width:100%;'> 
   <tr>  
      
   <th align='center' colspan='3'><span style='font-size:18px;  font-family: Times !important;'>$companyname</span></th>
   	</tr>
   	<tr>
   
   
   	</tr>
   	<tr>
   
   	<th align='center' colspan='3'><span style='font-size:14px;  font-family: Times, I, !important;'>$add1</span></th>
   	</tr>
      <tr>  
   
      
   	<th align='center' colspan='3'><span style='font-size:14px;  font-family: Times, I, !important;'>Profit and Loss</span></th>
   	</tr>
   	<tr>
   
   <td><span style='font-size:11px'><strong>From Date :- $fromdate1</strong></span></td>
   
   <td></td>
   	<td  align='right'><span style='font-size:11px'><strong>MOBILE NO. :- $companymob1</strong></span></td>
   
   	</tr>
   	<tr><td><span style='font-size:11px'><strong>To Date :- $todate1</strong></span></td>
   <td></td>
   
   		<td align='right'><span style='font-size:11px'><strong>EMAIL ID :- $email_id</strong></span></td></tr>
   
   
   	
   	
   
   </table>";
   
   $html .= "<hr style='margin-bottom:0px;'>";
   

   
   $html .= "<div style='width:100%';>";
   $html .= "<div style='float:left;width:30.99%;text-align:center;'>";
   
   $html .= "
   <div style='border-right:1px solid #000;height:32px;padding-top:10px;'><span><strong>Trip Expense</strong></span>
   </div><hr style='margin:0px;'>
   <table border='1' style='border-collapse:collapse;width:100%;'>
   <tr>
   <th align='center'><span style='font-size:10px;'>S.N</span></th>
   <th align='center'><span style='font-size:10px;'>LR No.<span style='font-size:10px;'></th>
   
   
 
   <th align='center'><span style='font-size:10px;'>Date <span style='font-size:10px;'></th>
   <th align='center'><span style='font-size:10px;'>Type  <span style='font-size:10px;'></th>

   <th align='center'><span style='font-size:10px;'>Net Amount <span style='font-size:10px;'></th>
   
      
   </tr>";
   
   $slno = 1;
   // echo "	SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type FROM bidding_entry WHERE $crit 
   // UNION SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type FROM returnbidding_entry WHERE $crit";
   $sel = "SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type,comp_rate,totalweight FROM bidding_entry WHERE $crit 
UNION SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type,comp_rate,totalweight FROM returnbidding_entry WHERE $crit";
   // 			"	SELECT lr_no,bilty_no,inv_date,freightamt,adv_cash,adv_consignor FROM bidding_entry WHERE $crit 
   // UNION SELECT lr_no,bilty_no,inv_date,freightamt,adv_cash,adv_consignor FROM returnbidding_entry WHERE $crit"

   $res = mysqli_query($connection, $sel);
   while ($row = mysqli_fetch_array($res)) {

       $truck_no = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row[truckid]'");
       //echo $doc_expiry_date = date("d-m-Y", strtotime(date("Y-m-d", strtotime($row['expiry'])) . "-5 day"));
       $currentdate;
       $freightamt = $row['comp_rate'] * $row['totalweight'];

       $netamt = $freightamt - $row['adv_consignor'];
    //   $adv_consignor=  $row['adv_consignor'];
       $lr_no=$row['lr_no'];
       $bilty_no=$row['bilty_no'];
       $tokendate=dateformatindia($row['tokendate']);
       $entry_type=$row['entry_type'];
       $adv_cash=$row['adv_cash'];
       $netGrandAmount += $netamt;
       $html .= "
   	<tr>
   	<td align='left'><span style='font-size:10px;'>$slno<span></td>
   
   		<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$lr_no</span></td>
  
   
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$tokendate</span></td>
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$entry_type</span></td>
           <td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$netamt</span></td>
   	
   		
   	</tr>
   	";
       $slno++;
   }
   
   
   $html .= "
   	<tr>
   
   	
   	<td></td>
   	<td></td>	<td></td>
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'><strong>Total</strong></span></td>
   	
   
   	
   
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'> $netGrandAmount</span></td>
   	</tr>
   	";
   $html .= "
   	</table>";
   $html .= "
   	</div>";
   $html .= "<div style='float:left; width:20%;text-align:center;'>";
   $html .= "
   
    <div style='border-right:1px solid #000;height:32px;padding-top:10px;'><span><strong>Truck Expenses</strong></span>
   </div><hr style='margin:0px;'>
     
   <table border='1' style='border-collapse:collapse;width:100%;'>
   <tr>
   
   <th align='left'  width='40px;'><span style='font-size:10px;'> Particular<span style='font-size:10px;'></th>
   
   <th align='left'><span style='font-size:10px;'>Date  <span style='font-size:10px;'></th>
   <th align='right'><span style='font-size:10px;'>Amount.<span style='font-size:10px;'></th>

   
    
   </tr>";
   $slno = 1;

									$sel = "SELECT headid,service_date,amount FROM service_entry WHERE $crit1 
			UNION SELECT headid,maint_date,amount FROM maintenance_entry WHERE $crit2";


									$res = mysqli_query($connection, $sel);
									while ($row = mysqli_fetch_array($res)) {

										$truck_no = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row[truckid]'");
										$maintenance = $cmn->getvalfield($connection, "head_master", "headname", "headid='$row[headid]'");
                                        $service_date=dateformatindia($row['service_date']);
                                        $amount1=$row['amount'];
       $netkharidiAmount += $amount1;
                                  

       $html .= "
   	<tr>

 
   	<td align='left'><span style='font-family:ind_hi_1_001;font-size:10px;'>$maintenance</span></td>
   
   	<td align='left'><span style='font-family:ind_hi_1_001;font-size:10px;'>$service_date</span></td>
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$amount1</span></td>

   
   	
   	</tr>
   
   	";
       $slno++;
   }
   $html .= "
   	<tr>
   
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'><strong></strong></span></td>
   		<td align='left'><span style='font-size:10px;'><strong>Total</strong></span></td>
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'><strong>$netkharidiAmount</strong></span></td>
   	</tr>
   	";
   
   $html .= "
   	</table>";
   
   $html .= "
   
   	</div>";
   	$html .= "<div style='float:left; width:20%;text-align:center;'>";
   $html .= "
    <div style='border-right:1px solid #000;height:32px;padding-top:10px;'><span><strong>Employee Payment</strong></span>
   </div><hr style='margin:0px;'>
   
   <table border='1' style='border-collapse:collapse;width:100%;'>
   <tr>
   
   <th align='center'><span style='font-size:10px;'> Payment Date<span style='font-size:10px;'></th>
   
   <th align='center'><span style='font-size:10px;'>Driver Name<span style='font-size:10px;'></th>

    <th align='center'><span style='font-size:10px;'>Pay Amount<span style='font-size:10px;'></th>

     
   </tr>";
   $slno = 1;
   // echo "	SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type FROM bidding_entry WHERE $crit 
   // UNION SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type FROM returnbidding_entry WHERE $crit";

   $sel = "SELECT * FROM emp_payment WHERE $crit3";

   $res = mysqli_query($connection, $sel);
   while ($row = mysqli_fetch_array($res)) {
       $empname = $cmn->getvalfield($connection, "m_employee", "empname", "empid='$row[empid]' ");
       $pay_date=dateformatindia($row['pay_date']);
       $empname=$row['empname'];
       $payment_type=$row['payment_type'];
       $amount=$row['amount'];
       $netexpenses_amt += $amount;

       $html .= "
   	<tr>
   	<td align='left'><span style='font-size:10px;'>$pay_date<span></td>
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$empname</span></td>

   
   	<td align='left'><span style='font-family:ind_hi_1_001;font-size:10px;'>$amount</span></td>

   	</tr>
   
   	";
       $sln++;
   }
   $html .= "
   	<tr>
   
   
	<td align='left'><span style='font-size:10px;'><span></td>	
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'><strong>Total</strong></span></td>
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'><strong>$netexpenses_amt</strong></span></td>
   	</tr>
   	";
   
   $html .= "
   	</table>";
   
   $html .= "
    
   	
   
   	</div>";
   $html .= "<div style='float:left;width:29%;text-align:center;'>";
   $html .= "
   <div style='border-right:1px solid #000;height:32px;padding-top:10px;'><span><strong>Payment Receive Details </strong></span>
   </div><hr style='margin:0px;'>
     
   <table border='1' style='border-collapse:collapse;width:100%;'>
   <tr>
   
   <th align='center' width='20%'><span style='font-size:10px;'> Lr No<span style='font-size:10px;'></th>
   
   <th align='center' width='30%'><span style='font-size:10px;'>Date<span style='font-size:10px;'></th>
   <th align='center'width='30%'><span style='font-size:10px;'>Type<span style='font-size:10px;'></th>
   <th align='center'width='20%'><span style='font-size:10px;'>Amount<span style='font-size:10px;'></th>
   
     
   </tr>";
       $slno = 1;
       $sel = "SELECT * FROM returnbill where $crit4";
       $res = mysqli_query($connection, $sel);
       while ($row = mysqli_fetch_array($res)) {
           $billno = $row['billno'];
           $billid = $row['billid'];

           $sel1 = "SELECT * FROM returnbill_details where billid='$billid'";
           $res1 = mysqli_query($connection, $sel1);
           while ($row1 = mysqli_fetch_array($res1)) {
               $ulamt = $row1['ulamt'];
               $bid_id = $row1['bid_id'];

               $sel2 = "SELECT * FROM returnbidding_entry where bid_id='$bid_id' $crit5 ";
               $res2 = mysqli_query($connection, $sel2);
               while ($row2 = mysqli_fetch_array($res2)) {
                   $adv_consignor = $row2['adv_consignor'];

                   $truck_no = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row2[truckid]'");
                   $currentdate;
                   $freightamt = $row['comp_rate'] * $row['totalweight'];
                   $lr_no = $row2['lr_no'];
                   $cgst_percent = $row['cgst_percent'];
                   $sgst_percent = $row['sgst_percent'];
                   $netamt = $freightamt - $row2['adv_cash'];
                   $totalweight   = $row2['totalweight'];
                   $entry_type   = $row2['entry_type'];
                   $recweight = $row2['recweight'];
                   $rate = $row2['comp_rate'];
                   $billno = $row2['billno'];
                   $billdate = dateformatindia($row['billdate']);
                   if ($totalweight <= $recweight)
                       $total = ($rate * $recweight);
                   else
                       $total =  ($rate * $recweight);

                   if ($totalweight <= $recweight) {
                       $qty = $totalweight;
                       $shortagetype = '';
                   } else {
                       $qty = $totalweight;
                       $shortagetype = $row['shortagetype'];
                   }

                   $cgstamt = $cgst_percent *  $total / 100;
                   $sgstamt = $sgst_percent *  $total / 100;
                   $net =     $total + $cgstamt + $sgstamt + $ulamt - $adv_consignor;
       $netamt1 += $net;
       

$html .= "
<tr>

<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$lr_no</span></td>

<td align='left'><span style='font-family:ind_hi_1_001;font-size:10px;'>$billdate</span></td>

<td align='left'><span style='font-family:ind_hi_1_001;font-size:10px;'>$entry_type</span></td>

<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$net</span></td>

</tr>

";
       $sln++;
   }}}

   $slno++;

								$sel3 = "SELECT * FROM bidding_entry where  $crit6 ";
								$res3 = mysqli_query($connection, $sel3);
								while ($row3 = mysqli_fetch_array($res3)) {
									$adv_consignor = $row2['adv_consignor'];
									$payment_vochar = $cmn->getvalfield($connection, "bulk_payment_vochar", "payment_vochar", "bid_id='$row3[bid_id]'");

									$newrate = $row3['newrate'];
									$recweight = $row3['recweight'];
									$commission = $row3['commission'];
									$adv_diesel = $row3['adv_diesel'];
									$adv_cash = $row3['adv_cash'];
									$adv_other =  $row3['adv_other'];
									$adv_consignor =  $row3['adv_consignor'];
									$adv_cheque = $row3['adv_cheque'];
									$sortamount = $row3['sortamount'];
									$entry_type   = $row3['entry_type'];
									$lr_no   = $row3['lr_no'];
									$payment_date   = dateformatindia($row3['payment_date']);

									$tot_adv = $adv_cash  + $adv_cheque + $adv_other + $adv_consignor;
									$netamount = $newrate * $recweight;
									$tds_amount = $netamount * $row3['tds_amt'] / 100;
									
									$total_paid = $netamount - $commission - $adv_diesel - $tot_adv - $tds_amount - $sortamount;
                                    $netamt2  +=$total_paid;
                                  $grandtotal1= $netamt1+$netamt2;
                                   
$html .= "
<tr>

<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$lr_no</span></td>

<td align='left'><span style='font-family:ind_hi_1_001;font-size:10px;'>$payment_date</span></td>

<td align='left'><span style='font-family:ind_hi_1_001;font-size:10px;'>$entry_type</span></td>

<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'>$total_paid</span></td>

</tr>

";
   $sln++;
}

   $html .= "
   	<tr>
   
   
  
   	<td align='left'><span style='font-size:10px;'><span></td>	<td align='left'><span style='font-size:10px;'><span></td>	
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'><strong>Total</strong></span></td>
   	<td align='right'><span style='font-family:ind_hi_1_001;font-size:10px;'><strong>$netamt1</strong></span></td>
   	</tr>
   	";
   
   $html .= "
   	</table>";
   
   $html .= "
   	</div>
      	</div> </div>
";
   $balamt = number_format(round($old - $netkharidiAmount + $netPaidAmount - $netGrandAmount -$netexpenses_amt), 2);
   // $totalbalance=number_format(round($balamt - $totdiscount),2);
   $html .= "
   
   <div style=' position: fixed;
  bottom: 0;
  right: 0;
  width: 300px;
  border: 3px solid'> 
 
   </br><table  style='border-collapse:collapse;text-align:center;float:left;'>
   	<tr>
   
   	<td align='left'><span style='font-size:10px; '><strong>Opening Balance </td>    <td  align='left'>: $old</strong><span></td>
   	</tr>
   	<tr>
   	<td align='left'><span style='font-size:10px;'><strong>Total Trip Expense Amt     </td>    <td  align='left'>: $netGrandAmount</strong> <span></td>
   	</tr>
   	<tr>
   	<td align='left'><span style='font-size:10px;'><strong>Total Driver Expense Amt&nbsp; </td>    <td  align='left'>:  $netkharidiAmount</strong> <span></td>
   	</tr>
   	<tr>
   	<td align='left'><span style='font-size:10px;'><strong>Total Maintenance Expense Amt </td>    <td  align='left'>:  $netexpenses_amt</strong> <span></td>
   	</tr>
   	<tr>
   		<td align='left'><span style='font-size:10px;'><strong>Total Payment Amt   </td>    <td  align='left'>: $netPaidAmount<span> </strong>  </td></tr>
   	<tr>
   	<td align='left'><span style='font-size:10px;'><strong>Balance Amount       </td>    <td  align='left'>: $balamt</strong><span></td>
   	</tr>
   	</table>
   
   	</div>";
   if ($_REQUEST['html']) //{ //echo $html; exit; }
       if ($_REQUEST['source']) {
           $file = __FILE__;
           header("Content-Type: text/plain");
           header("Content-Length: " . filesize($file));
           header("Content-Disposition: attachment; filename='" . $file . "'");
           readfile($file);
           exit;
       }
   //==============================================================
   $mpdf = new mPDF('utf-8', 'A4');
   
   $mpdf->AddPage('L', '', '', '', '', '4', '4', '4', '4');
   $mpdf->WriteHTML($html);
   $mpdf->SetTitle('Profit and Loss');
   
   $mpdf->Output();
   ?>
<?php
   mysqli_close($db_link);
   ?>
<span style="font-size:9px">