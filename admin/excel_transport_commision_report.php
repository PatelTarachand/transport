<?php 
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_commision_report.php';
$modulename = "Transporting Commission Report";

if(isset($_GET['search']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
	$consigneeid = trim(addslashes($_GET['consigneeid']));	
	$truckid = trim(addslashes($_GET['truckid']));
	
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
	$consigneeid='';
	$truckid='';
}

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
	$filename ="bilty_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);

?>


<table border="1" >
	<thead>
										<tr>
                                           	<th>Sno</th>  
											<th>LR No.</th>
											<th>Bilty Date</th>
										
											<th>Truck No.</th>											
											<th>Consignee</th>
											<th>Destination</th>
											<th>Tot. Weight</th>
											<th>Rec. Weight</th>
											
											<th>Payment Date</th>
											<th>Transport Commission</th> 
											<th>Final Commission</th> 
                                                                                     					 																	
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
									$sel = "select  *,DATE_FORMAT(tokendate,'%d-%m-%Y') as didate  from bidding_entry where $crit and compid='$compid' and payment_date between '$fromdate' and '$todate'  $cond and sessionid= $sessionid order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");	
										$didate = $row['didate'];
										$destinationid = $row['destinationid'];
										
										$rate_mt = $row['freightamt'];
										$newrate = $row['newrate'];	
										
										if($rate_mt - $newrate !=0) {							
									?>
										<tr>
					<td><?php echo $slno; ?></td>
					<td><?php echo $row['lr_no'];?></td>
					<td><?php echo $didate; ?></td>
				
				
					<td><?php echo $truckno;?></td>	
					<td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
					<td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'"); ?></td>
					<td><?php echo $row['totalweight']; ?></td>
					<td><?php echo $row['recweight']; ?></td>
					<td><?php echo $cmn->dateformatindia($row['payment_date']);?>
					<span style="color:#FFF;"> <?php echo $truckno; ?> </span>
					</td>
					
					<td style="text-align:right;"><?php echo $rate_mt-$newrate;?></td>                         
					
					<td style="text-align:right;"><?php echo number_format(($rate_mt - $newrate) * $row['recweight'],2);?></td>
					
										</tr>
                                        <?php
										$slno++;
										
										$tot_commission += ($rate_mt - $newrate) * $row['totalweight'];
										
										}
										
								}
									?>
                                    
                                     <tr style="color:#FFF; background-color:#0E3CF3;">
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
											<td></td> 
                                            <td style="text-align:right;"><strong><?php echo number_format($tot_commission,2); ?></strong></td>                                            
                                           
                                    </tr>
                                    
									</tbody>
							</table>


<script>window.close();</script>