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

if(isset($_GET['head_id']))
{
	$head_id = addslashes(trim($_GET['head_id']));
}

if(isset($_GET['payment_type']))
{
	$payment_type = addslashes(trim($_GET['payment_type']));
}

if(isset($_GET['truckid']))
{
	$truckid = addslashes(trim($_GET['truckid']));
}

if(isset($_GET['ownername']))
{
	$ownername = addslashes(trim($_GET['ownername']));
}

$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{

$crit .= " and payment_date between '$fromdate' and '$todate'";
}	


if($head_id !='')
{
	$crit .= " and  head_id ='$head_id' ";
	
}

if($payment_type !='')
{
	$crit .= " and  payment_type ='$payment_type' ";
	
}
if($truckid !='')
{
	$crit .= " and  truckid ='$truckid' ";
	
}

if($ownername!='')
{
	$crit .= " and  ownername ='$ownername' ";
	
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
                                        <tr><th colspan="7"><strong>BPS : ALL TRUCK INSTALLATION REPORT DETAILS</strong></th> </tr>																								
                                        <tr><th colspan="7">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="7">TRUCK INSTALLATION REPORT SUMMERY</th></tr>	                                   
                                    </tr>
								      <tr>
                                            <th>Sno</th>  
                                            <th>Head</th> 
                                            <th>Truck No </th>
                                             <th>Owner Name</th> 
                                        	<th>Amount</th>                                            
                                            <th>Payment Type</th> 
                                            <th>Payment Date</th> 
                                     </tr>
									</thead>
                                    <tbody>
                                   <?php
									
									if($usertype=='admin')
									{
									$cond="";
									}
									else
									{
									$cond=" && createdby='$userid' && sessionid='$sessionid'";	
									}
									
									$slno=1;
									$sel = "select * from truck_installation_payment $crit $cond";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row[truckid]'");
										$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'"); ?></td>
                                            <td><?php echo $truckno; ?></td>
                                            <td><?php echo $ownername;?></td>
                                            <td><?php echo $row['paid_amt'];?></td>
                                            <td><?php echo $row['payment_type'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['payment_date']); ?></td>
                                           
										</tr>
                                        <?php
										$slno++;
										$totalexp += $row['paid_amt'];
									}
									?>
										
									
                                    <tr>
                                    		<td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                        <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php echo number_format($totalexp,2); ?></strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                           
                                    </tr>									
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>