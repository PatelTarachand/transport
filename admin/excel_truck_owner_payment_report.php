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


if(isset($_GET['ownerid']))
{
	$ownerid=trim(addslashes($_GET['ownerid']));
}
else
$ownerid='';

if(isset($_GET['truckid']))
{
	$truckid=trim(addslashes($_GET['truckid']));
}
else
$truckid='';

$crit = " ";
if($fromdate!="" && $todate!="")
{

	$crit .= " and payment_date between '$fromdate' and '$todate'";
}

if($truckid !='') {
	$crit .=" and A.truckid='$truckid' ";
}

if($ownerid !='') {
	$crit .=" and B.ownerid='$ownerid' ";
	$owner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
}
else
$owner='';

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerpaymentreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);
?>


<table class="table table-hover table-nomargin table-bordered" border="2">
									
                                    <thead>
									
										<tr>
											<th colspan="13"><?php echo $cmn->getvalfield($connection,"m_company","cname","1='1'"); ?></th>  
											
											<th><?php echo $owner; ?></th>
										</tr>
										
										<tr>
											<th>Sno</th>  
                      <th>LR NO</th>
                      
                      <th>Consignee</th>
                      <th>Trcuk No.</th>
                      <th>Destination</th>
                      <th>Confirm Date</th>
                      <th>Payment Date</th>
                        <th>Vouchar No.</th>
                      <th>Weight</th>
                     <th>Comapny <p> Rate </p></th> 
                      <th>Final Rate</th> 
                      <th>Commission</th>
                       <th>Payment <p>Commission</p></th> 
                       <th>TDS</th>
                       <th>Diesal Adv.</th>
					                       <th>Total Adv. </th>
                      <th>Final Paid</th> 
                      <th>Profit Amount</th>   
                      
										</tr>
									</thead>
                                    <tbody>
                                     <?php
                  $slno=1;
                  
                $sel = "select  A.* from bidding_entry as A left join m_truck as B on A.truckid=B.truckid where A.is_complete=1 $crit and A.compid='$compid'and sessionid=$sessionid order by bid_id desc ";
              $res = mysqli_query($connection,$sel);
                  while($row = mysqli_fetch_array($res))
                  {
                    $truckid = $row['truckid'];                   
                    $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");

                     @$voucher_id = $row['voucher_id']; 
                   
              $payment_vochar = $cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id='$voucher_id'");

                        $adv_cash = $row['adv_cash'];
                        $adv_other =  $row['adv_other'];
						 $adv_consignor =  $row['adv_consignor'];
                        $adv_diesel = $row['adv_diesel'];
                        $adv_cheque = $row['adv_cheque'];
                        $cheque_no = $row['cheque_no']; 
                        $totalweight = $row['totalweight'];

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
                           $paidamount=$total-$commission-$adv_diesel-$total_adv;
                           $Profit=$totalweight*$trip_commission;


                    ?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $row['lr_no'];?></td>
                        
                            
                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                            <td><?php echo $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");

                     ?></td>
                            <td><?php echo $toplace; ?></td>
                            <td><?php echo $cmn->dateformatindia($row['confdate']);?>
                            <td><?php echo $cmn->dateformatindia($row['payment_date']);?>
                             </span>
                            </td>
                            <td><?php echo $payment_vochar;?></td>
                           <td><?php echo $totalweight;?></td>
                           <td><?php echo $freightamt;?></td>
                            <td><?php echo $final_rate; ?></td>
                             <td><?php echo $trip_commission;?></td>
                              <td><?php echo $commission;?></td> 
                              <td><?php echo round($tds);?></td>   
                              <td><?php echo $adv_diesel;?></td>                      
                              
                              <td><?php echo $total_adv;?></td>                  
                            
                             <td><?php echo number_format(round($paidamount),2);?></td>
                              <td><?php echo number_format(round($Profit),2);?></td>
                             
                            
                            
                        </tr>
                                        <?php
                    $slno++;
                }
                  ?>
							</table>
                            

                
                            
                            


<script>window.close();</script>