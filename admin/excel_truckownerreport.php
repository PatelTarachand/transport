<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Billty Report";

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
}

if($ownerid !='')
{
	$crit = " and truckowner='$ownerid'";
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin table-bordered">
									<thead>
                                    <tr>
                                    		<th colspan="15">Truck Owner Report</th>                                    
                                    </tr>
								<tr>
                                        <th>Sl. No.</th>
                                        <th>BT. No.</th>
                                        <th>Date</th>
                                        <th>Consignor</th>
                                        <th>Consignee</th>
                                        <th>From Place</th>
                                        <th>To Place</th>
                                        <th>Truck No</th>
                                        <th>Truck Owner</th>
                                        <th>Mobile</th>
                                        
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                        <th>Weight</th>
                                        <th>Comp. Rate/MT</th>
                                        <th>Freight</th>
                                        <th>Final Rate/MT</th>
                                        
                                        <th>Total Bilty Amt</th>
                                        <th>Total Adv</th>   
                                        <th>Commission</th>	                                                                                					 										<th>Total Paid</th>	
                                        <th>Remaing Amt</th>                                                                            					 								</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
								    $totalqty = 0;
                                    $totalwt_mt = 0;
                                    $totalrate_mt = 0;
                                    $totalnewrate = 0;
                                    $totaltot_amt = 0;
                                    $totaltot_adv = 0;
                                    $totalcommission = 0;
                                    $totaltot_paid = 0;
                                    $nettotal = 0;
                                
									if($usertype=='admin')
									{
									$cond="";
									}
									else
									{
									$cond=" && createdby='$userid' && sessionid='$sessionid'";	
									}
									
									$sel = "select bilty_id,billtyno,billtydate,destinationid,truckid,consignorid,consigneeid,placeid,destinationid,truckowner,truckownermobile,adv_cash,adv_diesel,
						adv_cheque,commission,chequepayment,cashpayment,wt_mt,newrate,itemid,qty,rate_mt,freight
						from bilty_entry where billtydate between '$fromdate' and '$todate' $crit $cond order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$tot_adv = $row['adv_cash']+$row['adv_diesel']+$row['adv_cheque'];
										$commission = $row['commission'];
										$tot_paid = $row['chequepayment']+$row['cashpayment'];
										$tot_amt = $row['wt_mt'] * $row['newrate']; 								
									?>
                <tr>
                     <td><?php echo $slno; ?></td>
                                <td><?php echo $row['billtyno']; ?></td>
                                <td><?php echo $cmn->dateformatindia($row['billtydate']); ?></td>
                                <td><?php echo $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'"); ?></td>
                                <td><?php echo $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$row[consigneeid]'"); ?></td>
                                <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[placeid]'"); ?></td>
                                <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'"); ?></td>
                                <td><?php echo strtoupper($cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"));?></td>
                                <td><?php echo $row['truckowner'];?></td>
                                <td><?php echo $row['truckownermobile']; ?></td>
                                
                                <td><?php echo $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$row[itemid]'"); ?></td>
                                <td><?php echo $row['qty'];?></td>
                                <td><?php echo $row['wt_mt'];?></td>
                                <td><?php echo $row['rate_mt'];?></td>
                                <td><?php echo $row['freight'];?></td>
                                <td><?php echo $row['newrate'];?></td>
                                
                                <td><?php echo $tot_amt; ?></td>
                                <td><?php echo $tot_adv; ?></td>
                                <td><?php echo $commission; ?></td>
                                <td><?php echo $tot_paid; ?></td>
                                <td><?php echo $tot_amt - $tot_paid - $commission - $tot_adv; ?></td>                                          
                </tr>
                                        <?php
												$slno++;
												$totalqty += $row['qty'];
												$totalwt_mt += $row['wt_mt'];
												$totalrate_mt += $row['rate_mt'];
												$totalnewrate += $row['newrate'];
												$totaltot_amt += $tot_amt;                                    
												$totaltot_adv += $tot_adv;
												$totalcommission += $commission;
												$totaltot_paid += $tot_paid;
												$nettotal += $tot_amt - $tot_paid - $commission - $tot_adv;

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
                                <td><strong>Total</strong></td>
                                <td><strong><?php echo number_format($totalqty,2);?></strong></td>
                                <td><strong><?php echo number_format($totalwt_mt,2);?></strong></td>
                                <td><strong><?php echo number_format($totalrate_mt,2);?></strong></td>
                                <td></td>
                                <td><strong><?php echo number_format($totalnewrate,2);?></strong></td>                                
                                <td><strong><?php echo number_format($totaltot_amt,2); ?></strong></td>
                                <td><strong><?php echo number_format($totaltot_adv,2); ?></strong></td>
                                <td><strong><?php echo number_format($totalcommission,2); ?></strong></td>
                                <td><strong><?php echo number_format($totaltot_paid,2); ?></strong></td>
                                <td><strong><?php echo number_format($nettotal,2); ?></strong></td>                                          
                </tr>
                                    
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>