<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='excel_tds_emami_report.php';
$modulename = "TDS  Report";
$crit = "";
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
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}


 

if($fromdate !='' && $todate !='')
{
		$crit.=" and payment_date between '$fromdate' and '$todate' ";	
}
 

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bilty_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
	<table border=1>
									<thead>
										<tr>
                                            <th>SN</th>  
                                            <th>LR No</th>
                                            <th>Bilty Date</th>
                                        	 
                      										    
                                              <th>Destination</th>
                                              <th>Truck Owner</th>
                                              <th>Truck No</th>
                                            
                      						<th>Pan Card</th>
                                          <th>Frieght Amount</th>
                                          	<th>Paid Amount</th>

                                            <th>TDS Amount</th>
                                          
                                            
                                                                           	 
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										//$cond="where createdby='$userid' ";
										$cond="where 1=1 ";		
									}
									
									
									 $sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit && tds_amt!=0  && is_complete='1'  and compid='$compid'  order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{									
								
								$truckid = $row['truckid'];
								
								$consigneeid = $row['consigneeid'];
								$destinationid = $row['destinationid'];
								$supplier_id = $row['supplier_id'];
								$brand_id = $row['brand_id'];
								$s = $row['bilty_date'];
								$dt = new DateTime($s);								
								$date = $dt->format('d-m-Y');
								$time = $dt->format('H:i:s');	
								$adv_cash = $row['adv_cash'];
                      $adv_other =  $row['adv_other'];
					    $adv_consignor =  $row['adv_consignor'];
                        $adv_diesel = $row['adv_diesel'];
                        $adv_cheque = $row['adv_cheque'];
                        $cheque_no = $row['cheque_no']; 
                        $totalweight = $row['totalweight'];
                        $recweight = $row['recweight'];

                        $total_adv=$adv_cash+$adv_other+$adv_consignor;
                        $freightamt=$row['freightamt'];
                         $final_rate= $row['freightamt']-$row['trip_commission'];
                         $trip_commission=$row['trip_commission'];
                         $commission=$row['commission'];
                          $deduct=$row['deduct'];
                           $tds_amt=$row['tds_amt'];
                              $destinationid = $row['destinationid'];

                           $amount=$recweight*$final_rate;
                             $netamount=$amount-$deduct;

                           $tds=$netamount*$tds_amt/100;
                                $total=$netamount-$tds;
                           $paidamount=$total-$commission-$total_adv-$adv_diesel;


									?>
            <tr tabindex="<?php echo $slno; ?>" class="abc">
                    <td><?php echo $slno; ?></td>
					<td><?php echo $row['lr_no'];?></td>
                    <td><?php echo $row['tokendate'];?></td>
				
                   <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");?></td>
					 <td> <?php  $m_owner= $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'"); 
          echo $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$m_owner'");
          ?></td>
<td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");?></td>
         
          <td><?php   

            echo $cmn->getvalfield($connection,"m_truckowner","pan","ownerid='$m_owner'");
           ?></td>
                    <td><?php echo number_format(round($netamount),2);?></td>
					<td><?php echo number_format(round($paidamount),2);?></td>
					<td><?php echo  number_format(round($tds),2); ?></td>
							
                    
                 
            </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>


<script>window.close();</script>