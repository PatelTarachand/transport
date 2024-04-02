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


if(isset($_GET['chequeno']))
{
	$chequeno = trim(addslashes($_GET['chequeno']));	
}
else
{
	$chequeno='';	
}

if(isset($_GET['bankid']))
{
	$bankid = trim(addslashes($_GET['bankid']));	
}
else
{
	$bankid='';	
}

if($chequeno !='')
{
	$crit =" and cheque_no like '%$chequeno%'";
	$cond=" and chequepaymentno like '%$chequeno%'";
}

if($bankid !='')
{
	$crit .=" and bankid='$bankid'";
	$cond .=" and paymentbankid ='$chequeno'";
}


// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bank_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin table-bordered">
									<thead>
                                    <tr>
                                    		<th colspan="13">Advance Cheque Amount</th>                                    
                                    </tr>
										<tr>
                                           <th width="4%">Sl. No.</th>
                                           <th width="6%">BT. No.</th>
                                           <th width="4%">Date</th>
                                           <th width="6%">Truck No</th>
                                           <th width="10%">Consignor Name</th> 
                                           <th width="6%">To Place</th>
                                           <th width="8%">Owner Name</th>
                                           <th width="9%">Owner Mobile</th>
                                           <th width="8%">Driver Name</th>
                                           <th width="8%">Driver Mobile</th>
                                           <th width="8%">Cheque Adv.</th>
                                           <th width="10%">Adv. Cheque No</th>
                                           <th width="9%">Adv. Cheque Date</th> 
                                             <th width="10%">Final Pay</th>
                                           <th width="10%">Bank Name</th>                 
                                                                                     					 																	
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$tot_final_pay = 0;
							$tot_check_adv = 0;
									$sel = "select bilty_id,billtyno,billtydate,consignorid,destinationid,truckowner,truckownermobile,drivername,commission,cashpayment,chequepayment,
									driver_mobile,adv_cheque,cheque_no,advchequedate,bankid,truckid from bilty_entry where advchequedate between '$fromdate' and '$todate' && adv_cheque !='0' $crit $ycond order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{										
									?>
                            <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $row['billtyno']; ?></td>
                            <td><?php echo $cmn->dateformatindia($row['billtydate']); ?></td>
                            <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"); ?></td>
                            <td><?php echo $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'"); ?></td>
                            <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'"); ?></td>
                            <td><?php echo $row['truckowner']; ?></td>
                            <td><?php echo $row['truckownermobile']; ?></td>
                            <td><?php echo $row['drivername']; ?></td>
                            <td><?php echo $row['driver_mobile']; ?></td>
                            <td><?php echo $row['adv_cheque']; ?></td>
                            <td><?php echo $row['cheque_no']; ?></td>
                            <td><?php echo $cmn->dateformatindia($row['advchequedate']); ?></td>  
                            <td><?php echo number_format($row['commission']+$row['cashpayment']+$row['chequepayment']-$row['commission'],2);?></td>
                            <td><?php  if($row['bankid'] !='0') {  echo $cmn->getvalfield($connection,"m_bank","bankname","bankid='$row[bankid]'").' / '.$cmn->getvalfield($connection,"m_bank","helpline","bankid='$row[bankid]'"); } ?></td>                                          
                            </tr>
                                        <?php
						$tot_final_pay += $row['adv_cheque'];
						$tot_check_adv += $row['commission']+$row['cashpayment']+$row['chequepayment']-$row['commission'];					
										
										$slno++;
								}
									?>
                                    
                                    
                                     <tr>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                         <td style="background-color:#00F; color:#FFF;"></td> 
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                         <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_final_pay,2);?></td> 
                          <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_check_adv,2); ?></td>
                        <td style="background-color:#00F; color:#FFF;"></td>                                          
                </tr>
									</tbody>
							</table>
                            
            
    <br />
    <br />
                
                            
 <table class="table table-hover table-nomargin table-bordered">
									<thead>
                                     <tr>
                                    		<th colspan="13">Payment Cheque Amount</th>                                    
                                    </tr>
                                    
										<tr>
                                           <th>Sl. No.</th>
                                           <th>BT. No.</th>
                                           <th>Date</th>
                                           <th>Consignor Name</th> 
                                           <th>To Place</th>
                                           <th>Owner Name</th>
                                           <th>Owner Mobile</th>
                                           <th>Driver Name</th>
                                           <th>Driver Mobile</th>             
                                           <th>Payment Cheque Amt</th>                                           
                                           <th>Payment Cheque No </th>
                                          <th>Payment Cheque Date</th>
                                            <th>Final Pay</th>
                                          <th>Bank Name</th>
                                           
                                                                                     					 																	
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$tot_final_pay = 0;
									$tot_check_adv = 0;
									
									if($usertype=='admin')
									{
									$ycond="";
									}
									else
									{
									$ycond=" && createdby='$userid' && sessionid='$sessionid'";	
									}	
									
									$sel = "select bilty_id,billtyno,billtydate,consignorid,destinationid,truckowner,commission,cashpayment,chequepayment,truckownermobile,drivername,
									driver_mobile,chequepayment,chequepaymentno,chequepaydate,paymentbankid,truckid from bilty_entry where chequepaydate between '$fromdate' and '$todate' && chequepayment !='0' $cond $ycond order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                    <td><?php echo $row['billtyno']; ?></td>
                    <td><?php echo $cmn->dateformatindia($row['billtydate']); ?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'"); ?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'"); ?></td>
                     <td><?php echo $row['truckowner']; ?></td>
                    <td><?php echo $row['truckownermobile']; ?></td>
                    <td><?php echo $row['drivername']; ?></td>
                    <td><?php echo $row['driver_mobile']; ?></td>
                    <td><?php echo $row['chequepayment']; ?></td>
                    <td><?php echo $row['chequepaymentno']; ?></td>
                    <td><?php echo $cmn->dateformatindia($row['chequepaydate']); ?></td>  
                      <td><?php echo number_format($row['commission']+$row['cashpayment']+$row['chequepayment']-$row['commission'],2);?></td>
                    <td><?php  if($row['paymentbankid'] !='0') { echo $cmn->getvalfield($connection,"m_bank","bankname","bankid='$row[paymentbankid]'").' / '.$cmn->getvalfield($connection,"m_bank","helpline","bankid='$row[paymentbankid]'"); } ?></td> 
										</tr>
                                        <?php
					$tot_final_pay += $row['chequepayment'];
					$tot_check_adv += $row['commission']+$row['cashpayment']+$row['chequepayment']-$row['commission'];					
										$slno++;
								}
									?>
                                    
                      <tr>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                         <td style="background-color:#00F; color:#FFF;"></td> 
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_final_pay,2);?></td>   
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_check_adv,2); ?></td>
                        <td style="background-color:#00F; color:#FFF;"></td>                                          
                </tr>               
                                    
									</tbody>
							</table>                           


<script>window.close();</script>