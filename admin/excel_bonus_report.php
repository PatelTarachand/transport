<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'otherincome';
$tblpkey = 'otherincomeid';
$pagename  ='excel_bonus_report.php';
$modulename = "Truck Income Report";

if($_GET['fromdate']!="" && $_GET['todate']!="")
{
	$fromdate = (addslashes(trim($_GET['fromdate'])));
	$todate = (addslashes(trim($_GET['todate'])));
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

$cond = " where 1 = 1 ";
$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{
	$crit .= " and diedate between '$fromdate' and '$todate'";
	
	$cond .=" and adv_date between '$fromdate' and '$todate'";
}

if($truckid !='')
{
	$crit .= " and  truckid ='$truckid' ";	
	$cond .= " and  truckid ='$truckid' ";	
}






//echo $monthName;die;

$enddate = date("t", strtotime($fromdate));
// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin table-bordered" border="2">
									<thead>
                                    <tr>
                                        <tr><th colspan="9"><strong>BPS : ALL BONUS REPORT DETAILS</strong></th> </tr>																								
                                        <tr><th colspan="9">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="9">BONUS REPORT SUMMARY</th></tr>	                                   
                                    </tr>
								<tr>
                                               
                                            <th>Sno</th>  
                                            <th>Slip No</th> 
                                            <th>Date</th> 
                                            <th>Truck No </th>
                                        	<th>Driver Name</th>   
                                            <th>Payment Type</th>                                            
                                             <th>Average</th> 
                                            <th>Bonus Amt</th>  
                                            <th>Narration</th>
                                                                                                                                         					 								</tr>
									</thead>
                                    <tbody>
                                    
                                   <?php
									$slno=1;
									?>
                                    
                                    <?php 
									$totaluchantibonus = 0;
									$sql = "select * from truck_uchanti where paymentdate between '$fromdate' and '$todate' && truckid='$truckid' && head_id='16' order by truckuchantiid desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{										
											
											$diedate = $row['paymentdate'];
											$truckid = $row['truckid'];
											$drivername = $row['drivername'];
											$payment_type = $row['payment_type'];
											$chequeno = $row['chequeno'];
											$bankid = $row['bankid'];
											$chequedate = $row['chequedate'];											
											$bonus_amt = $row['uchantiamount'];											
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td> </td>       
                                            <td><?php echo $cmn->dateformatindia($diedate);?></td>   
                                            <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");  ?></td>
                                            <td><?php echo ucfirst($drivername);?></td>
                                            <td><?php echo strtoupper($payment_type);?></td>  
                                            <td><?php echo number_format($actual_avg,2);?></td>
                                            <td><?php echo number_format($bonus_amt,2);?></td>
                                            <td><?php echo $row['narration']; ?></td>   
										</tr>
                                       <?php
										$slno++;
										$totaluchantibonus += $bonus_amt;										
									}
									
									
									$totalexp = 0;
									$sql = "select * from diesel_demand_slip $crit and bonus_amt !=0 order by diedate desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{										
											$slipno = $row['slipno'];
											$diedate = $row['diedate'];
											$truckid = $row['truckid'];
											$drivername = $row['drivername'];
											$actual_avg = $row['actual_avg'];											
											$bonus_amt = $row['bonus_amt'];
											$payment_type = $row['payment_type'];
											$chequeno = $row['chequeno'];
											$bankid = $row['bankid'];
											$chequedate = $row['chequedate'];
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($slipno);?></td>       
                                            <td><?php echo $cmn->dateformatindia($diedate);?></td>   
                                            <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");  ?></td>
                                            <td><?php echo ucfirst($drivername);?></td>
                                            <td><?php echo strtoupper($payment_type);?></td>   
                                            <td><?php echo number_format($actual_avg,2);?></td>
                                            <td><?php echo number_format($bonus_amt,2);?></td> 
                                            <td><?php echo $row['remarks']; ?></td>  
										</tr>
                                       <?php
										$slno++;
										$totalbonus += $bonus_amt;
										
									}
									?>
          <tr>
            <td style="background-color:#00F; color:#FFF;"> </td>
            <td style="background-color:#00F; color:#FFF;"></td>
            <td style="background-color:#00F; color:#FFF;"> </td>           
            <td style="background-color:#00F; color:#FFF;"> </td>                                         
            <td style="background-color:#00F; color:#FFF;"> </td>   
            <td style="background-color:#00F; color:#FFF;"> <strong>Total</strong></td>   
            <td style="background-color:#00F; color:#FFF;"> </td>         
            <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php echo number_format($totalbonus + $totaluchantibonus,2); ?></strong></td>              <td style="background-color:#00F; color:#FFF;"> </td> 
        </tr>	
        </tbody>
							</table>
                            

                
<br />
<br />
<br />
                           
<table class="table table-hover table-nomargin table-bordered" border="2">
									<thead>
                                    <tr>
                                        <tr><th colspan="9"><strong>BPS : ALL DIESEL ADVANCE REPORT DETAILS</strong></th> </tr>																								
                                        <tr><th colspan="9">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="9">DIESEL ADVANCE REPORT SUMMARY</th></tr>	                                   
                                    </tr>
								<tr>
                                               
                                            <th>Sno</th>  
                                          <th>Bilty No.</th>
                                             <th>Truck No.</th>
                                        	<th>Bilty Date</th>
                                            <th>Consignor</th>
                                            <th>Consignee</th>                                         
                                             <th>Diesel Advance</th> 
                                            <th>Petrol Pump</th>  
                                            <th>Advance Date</th>
                                                                                                                                         					 								</tr>
									</thead>
                                    <tbody>
                                    
                                   <?php
									$slno=1;
									$tot_adv_dieselltr=0;									
									$totalexp = 0;
									$sql = "select * from bilty_entry  $cond and adv_dieselltr !=0 order by adv_date desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{										
											$truckid = $row['truckid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
									?>
        <tr>
            <td><?php echo $slno; ?></td>
            <td><?php echo ucfirst($row['billtyno']);?></td>
             <td><?php echo $truckno;?></td>
            <td><?php echo $cmn->dateformatindia($row['billtydate']);?></td>
            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?> </td>
            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?> </td>  
            <td><?php echo number_format($row['adv_dieselltr'],2);?></td>
            <td><?php echo ucwords($row['petrol_pump_type']);?></td> 
            <td><?php echo $cmn->dateformatindia($row['adv_date']); ?></td>  
        </tr>
                                       <?php
										$slno++;
								$tot_adv_dieselltr += $row['adv_dieselltr'];											
									}
									?>
          <tr>
            <td style="background-color:#00F; color:#FFF;"> </td>
            <td style="background-color:#00F; color:#FFF;"></td>
            <td style="background-color:#00F; color:#FFF;"> </td>           
            <td style="background-color:#00F; color:#FFF;"> </td>                                         
            <td style="background-color:#00F; color:#FFF;"> </td>   
            <td style="background-color:#00F; color:#FFF;"> <strong>Total</strong></td>   
            <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_adv_dieselltr,2); ?></td>         
            <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php //echo number_format($totalbonus + $totaluchantibonus,2); ?></strong></td>              <td style="background-color:#00F; color:#FFF;"> </td> 
        </tr>	
        </tbody>
							</table>                            


<script>window.close();</script>