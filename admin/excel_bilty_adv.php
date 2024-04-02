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

	$crit .= " and adv_date between '$fromdate' and '$todate'";
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);
?>


<table class="table table-hover table-nomargin table-bordered" border="2">
									<thead>
                                    <tr>
                                        <tr><th colspan="10"><strong>BPS : ALL BILTY ADVANCE REPORT DETAILS</strong></th> </tr>																								
                                        <tr><th colspan="10">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="10">BILTY ADVANCE REPORT SUMMERY</th></tr>	                                   
                                    </tr>
								      <tr>
                                              <th>Sno</th>  
                                            <th>Bilty No.</th>
                                             <th>Truck No.</th>
                                        	<th>Bilty Date</th>
                                            <th>Consignor</th>
                                            <th>Consignee</th>
                                            <th>Advance Cash</th>
                                            <th>Advance Diesel</th>
                                            <th>Advance Cheque</th>
                                            <th>Truck Owner</th>
                                            
                                     </tr>
									</thead>
                                    <tbody>
                                   <?php
									$slno=1;
									$totalexp = 0;
									//echo "select * from bilty_entry where billtydate='$fromdate' order by bilty_id desc";die;
									$sel = "select * from bilty_entry where adv_date='$fromdate' order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$adv_cash = 0;
									    $adv_cash = $row['adv_cash'];
										$truckid = $row['truckid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										//$balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque;
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['billtyno']);?></td>
                                             <td><?php echo $truckno;?></td>
                                            <td><?php echo $cmn->dateformatindia($row['billtydate']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                                            <td><?php echo ucfirst($row['adv_cash']);?>  
                                            <span style="color:#FFF;"><?php echo $row['drivername']; ?></span></td>
                                            <td><?php echo ucfirst($row['adv_diesel']);?>
                                            <span style="color:#FFF;"><?php echo $truckno; ?></span>
                                            </td>
                                            <td><?php echo ucfirst($row['adv_cheque']);?></td>
                                            <td><?php echo ucfirst($row['truckowner']);?></td>
										</tr>
                                          <?php
										$slno++;
										$totalexp += $adv_cash;
									}
									?>
									
                                    <tr>
                                    		<td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                             <td style="background-color:#00F; color:#FFF;"></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php echo number_format($totalexp,2); ?></strong> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                             <td style="background-color:#00F; color:#FFF;"></td>
                                    </tr>								
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>