<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='excel_commission_report.php';
$modulename = "Commission Report";

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
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
}

if(isset($_GET['itemid']))
{
	$itemid = trim(addslashes($_GET['itemid']));
	
}

if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));
	
}

$crit =" 1=1 ";
if($ownername !='')
{
	$crit .=" and truckowner='$ownername' ";
}

if($itemid !='')
{
	$crit .=" and itemid='$itemid' ";
}

if($consignorid !='')
{
	$crit .=" and consignorid='$consignorid' ";
}


// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="biltycommission.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table border="1" >
									<thead>
										<tr>
                                           <th>Sl. No.</th>
                                           <th>BT. No.</th>
                                           <th>Date</th>
                                           <th>Veh. No.</th>
                                           <th>Ship To Desti.</th>
                                           <th>MT</th>
                                           <th>Rate</th>
                                           <th>Char/mt</th>
                                           <th>Final Rs.</th>
                                           <th>Total Amt</th>                                          
                                           <th>Final Amt</th>
                                           <th>Profit</th>                                          
                                           <th>Agent Name</th>
                                           <th>Commission</th>                                      					 																	
										</tr>
									</thead>
<tbody>
<?php
if($usertype=='admin')
{
$cond="";
}
else
{
$cond=" && createdby='$userid' && sessionid='$sessionid'";	
}	

$slno=1;
$sel = "select bilty_id,billtyno,billtydate,destinationid,truckid,wt_mt,rate_mt,newrate,adv_cash,adv_diesel,
adv_cheque,adv_date,payment_date,chequepaymentno,cashpayment,chequepayment,commission,venderid,drivername,
driverlisenceno from bilty_entry where $crit and billtydate between '$fromdate' and '$todate'  $cond order by bilty_id desc";
$res = mysqli_query($connection,$sel);
while($row = mysqli_fetch_array($res))
{
$char_amt = $row['rate_mt'] - $row['newrate'];
$tot_amt = $row['wt_mt'] * $row['newrate']; 
$final_amt = $tot_amt - $row['adv_diesel'] - $row['adv_cash'] - $row['adv_cheque'];
$profit = $char_amt * $row['wt_mt'];
$truckid = $row['truckid'];
$commission = $row['commission'];
$venderid = $row['venderid'];
$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
$vendername = $cmn->getvalfield($connection,"m_vender","vendername","venderid='$venderid'");
$ownermobileno1 = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");										
?>
<tr>
<td><?php echo $slno; ?></td>
<td><?php echo $row['billtyno']; ?></td>
<td><?php echo $cmn->dateformatindia($row['billtydate']); ?></td>
<td><?php echo strtoupper($cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"));?></td>
<td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'");?></td>
<td><?php echo $row['wt_mt']; ?></td>
<td><?php echo $row['rate_mt']; ?></td>
<td><?php echo $row['rate_mt'] - $row['newrate']; ?></td>
<td><?php echo $row['newrate']; ?></td>
<td><?php echo $row['wt_mt'] * $row['newrate']; ?></td>                                          
<td><?php echo $final_amt; ?></td>
<td><?php echo $profit; ?></td>

<td><?php echo $vendername; ?></td>
<td><?php echo $commission; ?></td>

</tr>
<?php
$slno++;
$tot_final_amt += $final_amt;
$tot_profit_amt += $profit;
$net_tot_amt += $tot_amt;	
$net_tot_comm += $commission;	
}
?>
<tr>
<td style="color:#FFF; background-color:#0E3CF3;"></td>
<td style="color:#FFF; background-color:#0E3CF3;"></td>
<td style="color:#FFF; background-color:#0E3CF3;"><strong>Total</strong></td>
<td style="color:#FFF; background-color:#0E3CF3;"></td>
<td style="color:#FFF; background-color:#0E3CF3;"></td>
<td style="color:#FFF; background-color:#0E3CF3;"></td>
<td style="color:#FFF; background-color:#0E3CF3;"></td>   
<td style="color:#FFF; background-color:#0E3CF3;"></td>  
<td style="color:#FFF; background-color:#0E3CF3;text-align:right;"><?php echo number_format($net_tot_amt,2); ?></td> ></td>
<td style="color:#FFF; background-color:#0E3CF3;text-align:right;"><?php echo number_format($tot_final_amt,2); ?></td>
<td style="color:#FFF; background-color:#0E3CF3;text-align:right;"><?php echo number_format($tot_profit_amt,2); ?></td>   
<td style="color:#FFF; background-color:#0E3CF3;"></td>
<td style="color:#FFF; background-color:#0E3CF3;"></td>
<td style="color:#FFF; background-color:#0E3CF3;text-align:right;"><?php echo number_format($net_tot_comm,2); ?></td>

</tr>

</tbody>
</table>


<script>window.close();</script>