<?php  
include("dbconnect.php");
if($_GET['fromdate']!="" && $_GET['todate']!="")
{
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['truckid']))
{
	$truckid = addslashes(trim($_GET['truckid']));
}
else
{
	$truckid='';	
}
//
//if(isset($_GET['payment_type']))
//{
//	$payment_type = addslashes(trim($_GET['payment_type']));
//}

$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{

	$crit .= " and diesel_demand_slip.diedate between '$fromdate' and '$todate'";
}	

if($truckid !='')
{
	$crit .= " and  truckid ='$truckid' ";
	
}
//
//if($payment_type !='')
//{
//	$crit .= " and  payment_type ='$payment_type' ";
//	
//}


// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin table-bordered" border="2">
									<thead>
                                    <tr>
                                        <tr><th colspan="10"><strong>BPS : ALL DIESEL DEMAND SLIP DETAILS</strong></th> </tr>																								
                                        <tr><th colspan="10">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="10">DIESEL DEMAND SLIP</th></tr>	                                   
                                    </tr>
								      <tr>
                                            <th>Sno</th>  
                                            <th>Slip No.</th>
                                            <th>Date</th>
                                            <th>Truck No.</th>
                                            <th>Driver</th>
                                            <th>Prev. Reading</th>
                                            <th>Meter Reading</th>
                                            <th>Total KM</th>
                                           <th>Average</th> 
                                            <th>Total Amount</th>                                          
                                           	
										</tr>
									</thead>
                                    <tbody>
                                   <?php
									$slno=1;
									//echo "select * from diesel_demand_slip $crit  order by diedate desc";die;
									$totalexp = 0;
									$sel = "select * from diesel_demand_slip $crit order by diedate desc";
									$res = mysqli_query($connection,$sel);
									$total_challan_adv = 0;
									$total_challan_weight = 0;
									while($row = mysqli_fetch_array($res))
									{
										$total = 0;									
										$total = $row['total'];

										$dieslipid = $row['dieslipid'];
										$truckid = $row['truckid'];
										$tot = $cmn->getvalfield($connection,"diesel_demand_detail","sum(qty * rate)","dieslipid = '$row[dieslipid]'");
										$tot_qty = $cmn->getvalfield($connection,"diesel_demand_detail","sum(qty)","dieslipid = '$row[dieslipid]'");
									$openningkm = $cmn->getvalfield($connection,"m_truck","openningkm","truckid='$truckid'");
									$total = $cmn->getdiesel($connection,$dieslipid);
									$sql_prev = mysqli_query($connection,"Select metread from diesel_demand_slip where dieslipid = (select max(dieslipid) from diesel_demand_slip where truckid = '$truckid' && dieslipid < '$dieslipid')");
									if($sql_prev)
									{
									while($row_prev = mysqli_fetch_assoc($sql_prev))
									{
									$metread = $row_prev['metread'];
									}
									}
									
									if($metread == "")
									{
									$metread += $openningkm;
									
									if($metread == "")
									{	
									$metread = 0;
									}									
									}
									
	
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['slipno'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['diedate']);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid ='$row[truckid]'"); ?></td>
                                            <td><?php echo $row['drivername']; ?></td>
                                            <td><?php echo number_format($metread,2); ?></td>
                                            <td><?php echo $row['metread']; ?></td>                                            
                                            <td><?php echo $row['totalkm']; ?></td>
                                            <td>
											<?php											
											echo number_format($row['totalkm']/$tot_qty,2);											
											?>
                                            </td>
                                           <td><?php echo round($total); ?></td>
										</tr>
                                        <?php
										$slno++;
										$totalexp += $total;
									}
									?>
									
                                    <tr>
                                    		<td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF; "></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php echo number_format($totalexp,2); ?></strong> </td>
                                            
                                    </tr>					
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>