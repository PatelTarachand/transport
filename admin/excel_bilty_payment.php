<?php  error_reporting(0);
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

$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{

	$crit .= " and cashbook_date between '$fromdate' and '$todate'";
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="finalpayment.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);
?>


<table class="table table-hover table-nomargin table-bordered" border="2">
									<thead>
                                    <tr>
                                        <tr><th colspan="10"><strong>BPS : ALL BILTY PAYMENT REPORT DETAILS</strong></th> </tr>																								
                                        <tr><th colspan="10">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="10">BILTY PAYMENT REPORT SUMMERY</th></tr>	                                   
                                    </tr>
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
                                           <th>Final Cash Amt</th>
                                           <th>Commission</th> 
                                              
                                     </tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$totalexp = 0;
									if($usertype=='admin')
									{
									$crit="";
									}
									else
									{
									$crit=" && createdby='$userid'";	
									}	
									
									$sel = "select * from bilty_entry where payment_date='$fromdate' && cashpayment !='0' order by bilty_id desc";
									 
						      	$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									
									{
										$char_amt = $row['rate_mt'] - $row['newrate'];
										$tot_amt = $row['wt_mt'] * $row['newrate']; 
										$final_amt =  $row['cashpayment'];
										
										$truckid = $row['truckid'];
										$commission = $row['commission'];
										
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
                                            <td><?php echo $commission; ?></td>
                        </tr>
                                        <?php
										$slno++;
										$tot_final_amt += $final_amt;
										$net_tot_amt += $tot_amt;	
										$net_tot_comm += $commission;
								}
									
									?>
									
                                    <tr>
                                    		 <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                             <td style="background-color:#00F; color:#FFF;"></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                             <td style="background-color:#00F; color:#FFF; text-align:right;"><?php echo number_format($net_tot_amt,2); ?></td>
                                            <td style="background-color:#00F; color:#FFF; text-align:right;"><?php echo number_format($tot_final_amt,2); ?></td>
                                            <td style="background-color:#00F; color:#FFF; text-align:right;"><?php echo number_format($tot_profit_amt,2); ?></td>
                                           <td style="background-color:#00F; color:#FFF; text-align:right;"><?php echo number_format($net_tot_comm,2); ?></td>
                                            
                                    </tr>								
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>