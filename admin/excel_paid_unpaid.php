<?php 
include("dbconnect.php");

$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='excel_paid_unpaid_report.php';
$modulename = "Paid Unpaid Report";
$crit=" ";


	$fromdate = $_GET['fromdate'];
	$todate =  $_GET['todate'];
	

 @$selectype=$_GET['selectype'];
if($selectype!=''){
@$selectype=$_GET['selectype'];
    if($selectype=='Paid'){
       $crit.=" and is_complete='1'";
    }else{
        $crit.=" and is_complete='0'";
    }
}
$selectype='';

if($fromdate !='' && $todate !='')
{
		$crit.=" and tokendate between '$fromdate' and '$todate' ";	
}

@$lr_no=$_GET['lr_no'];
if($lr_no!=''){
  $lr_no=$_GET['lr_no'];
  $crit.=" and lr_no='$lr_no'";
}
@$lr_no='';
 
 

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="excel_paid_unpaid.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											
                                            <th>SN</th>  
                                            <th>LR NO.</th>
                                            <?php if(@$_GET['selectype']=='Paid'){ ?>
                                            <th>Voucher No.</th>
                                            <?php } ?>
                                            <th>Consignee</th>
                                            <th>Truck No.</th>
                                         <th>Destination</th>
                      
					                      <th>Weight</th>
					                      <th>Comapny Rate</th> 
					                      
					                      <th>Final Rate</th> 
					                      <th>Commission</th>
					                       <th>Payment <p>Commission</p></th> 
					                       <th>TDS</th>
					                       <th>Diesal Adv.</th>
					                       <th>Total Adv. </th>
					                       
					                     <th>Total Aount</th>
					                      <th> Date </th>
                                            
                                            <th>Status</th>
                                                                               	 
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
									
									
									  $sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit  and compid='$compid'  order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{					
                  $lr_no = $row['lr_no'];				
								$gr_date = $row['gr_date'];
								$truckid = $row['truckid'];
								$itemid = $row['itemid'];
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
                          $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");

                          $amount=$totalweight*$final_rate;
                            $netamount=$amount-$deduct;

                                $tds=$netamount*$tds_amt/100;
                                $total=$netamount-$tds;
                           $paidamount=$total-$commission-$total_adv-$adv_diesel;
                           
                           $is_complete=$row['is_complete'];
                           $voucher_id=$row['voucher_id'];


									?>
               <tr tabindex="<?php echo $slno; ?>" class="abc">
                    <td><?php echo $slno; ?></td>
                    <td><?php echo $row['lr_no'];?></td>
                       <?php if(@$_GET['selectype']=='Paid'){ ?>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id = '$voucher_id'"));?></td>
                                            <?php } ?>
					          <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                    <td><?php echo $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");

                     ?></td>
                            <td><?php echo $toplace; ?></td>
                          
                           
                            </td>
                           <td><?php echo $totalweight;?></td>
                           <td><?php echo $freightamt;?></td>
                            <td><?php echo $final_rate; ?></td>
                             <td><?php echo $trip_commission;?></td>
                              <td><?php echo $commission;?></td> 
                              <td><?php echo round($tds);?></td> 
                              <td><?php echo $adv_diesel;?></td>                      
                              
                              <td><?php echo $total_adv;?></td>                      
                            
                             
                            <?php if($is_complete!=0){ ?>
                            	<td><?php echo number_format(round($paidamount),2);?></td>	
                              <td><?php echo $cmn->dateformatindia($row['payment_date']);?>
                              <td>Paid</td>
                            <?php }else{ ?>
                            	<td><?php echo number_format(round($paidamount),2);?></td>	
                            	<td><?php echo $cmn->dateformatindia($row['tokendate']);?>
                              <td>Unpaid</td>
                            <?php }  ?> 	
                 
            </tr>
                                        <?php
										$slno++;
								}

									?>
                                    
                                    
                                   
									</tbody>
							</table>


<script>window.close();</script>