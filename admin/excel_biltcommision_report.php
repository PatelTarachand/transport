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

if(isset($_GET['consigneeid']))
{
	$consigneeid = trim(addslashes($_GET['consigneeid']));
}
else
$consigneeid='';

if(isset($_GET['truckid']))
{
	$truckid = trim(addslashes($_GET['truckid']));
	
}
else
$truckid='';



$crit =" 1=1 ";

if($truckid !='')
{
	$crit .=" and truckid='$truckid' ";
}



if($consigneeid)
{
	$crit .=" and consigneeid='$consigneeid' ";
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
                                           	<th>Sno</th>  
											<th>DI No.</th>
											<th>Di Date</th>
											<th>GR NO</th>
											<th>Invoice No </th>
											<th>Truck No.</th>											
											<th>Consignee</th>
											<th>Payment Date</th>											
											<th>Destination</th>
											<th>Tot. Weight</th>
											<th>Qty</th>
											<th>Bilty Commission</th> 
											<th>Final Pay</th>                                 					 																	
										</tr>
									</thead>
<tbody>
<?php
if($usertype=='admin')
									{
									$cond=" && sessionid='$sessionid'";
									}
									else
									{
									$cond=" && sessionid='$sessionid'";	
									}	
									$tot_commission=0;									
									$slno=1;
									$sel = "select  *,DATE_FORMAT(tokendate,'%d-%m-%Y') as didate  from bidding_entry where $crit and payment_date between '$fromdate' and '$todate'  $cond && commission !=0 order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];
										$didate = $row['didate'];
										$destinationid = $row['destinationid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");															
?>
<tr>
<td><?php echo $slno; ?></td>
					<td><?php echo $row['di_no'];?></td>
					<td><?php echo $didate; ?></td>
					<td><?php echo $row['gr_no'];?></td>
					<td><?php echo $row['invoiceno'];?></td>
					<td><?php echo $truckno;?></td>
					
					
					<td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
					<td><?php echo $cmn->dateformatindia($row['payment_date']);?>
					<span style="color:#FFF;"> <?php echo $truckno; ?> </span>
					</td>
					
					
					<td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'"); ?></td>
					<td><?php echo $row['totalweight']; ?></td>
					<td><?php echo $row['noofqty']; ?></td>
					
					<td style="text-align:right;"><?php echo $row['commission'];?></td>                         
					
					<td style="text-align:right;"><?php echo number_format($row['cashpayment']+$row['chequepayment']+$row['neftpayment'],2);?></td>

</tr>
<?php
$slno++;
$tot_commission += $row['commission'];	
}
?>
<tr>
<td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
											<td></td>
                                            <td></td>
                                            <td></td>
											<td></td>
                                            <td></td>
											<td></td>
                                            <td style="text-align:right;"><strong><?php echo number_format($tot_commission,2); ?></strong></td>                                            
                                           <td></td> 
</tr>

</tbody>
</table>


<script>window.close();</script>