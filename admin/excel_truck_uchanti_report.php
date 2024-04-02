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
if(isset($_GET['ownerid']))
{
	$ownerid = addslashes(trim($_GET['ownerid']));
}
else
{
	$ownerid='';	
}
if(isset($_GET['head_id']))
{
	$head_id = addslashes(trim($_GET['head_id']));
}
else
{
	$head_id='';	
}
if(isset($_GET['drivername']))
{
	$drivername = addslashes(trim($_GET['drivername']));
}
else
{
	$drivername='';	
}

if(isset($_GET['payment_type']))
{
	$payment_type = addslashes(trim($_GET['payment_type']));
}
else
{
	$payment_type='';	
}

$cond=" where 1=1 ";
$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{

	$crit .= " and A.paymentdate between '$fromdate' and '$todate'";
}	


if($truckid !='')
{
	$cond .= " and  A.truckid ='$truckid' ";	
}
if($ownerid !='')
{
	$cond .= " and  ownerid ='$ownerid' ";	
}


if($head_id !='')
{
	$crit .= " and  A.head_id ='$head_id' ";	
}
if($drivername !='')
{
	$crit .= " and  A.drivername ='$drivername' ";	
}

if($payment_type !='')
{
	$crit .= " and  A.payment_type ='$payment_type' ";	
}
// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%" border="2">
									<thead>
                                    <tr>
                                        <tr><th colspan="9"><strong>BPS : ALL TRUCK EXPENSES REPORT DETAILS</strong></th> </tr>																								
                                         <tr><th colspan="9">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="9">TRUCK EXPENSES REPORT SUMMERY</th></tr>	                                   
                                    </tr>
										<tr>
                                             <th>Sno</th>  
                                            <th>Truck No</th> 
                                            <th>Driver Name</th> 
                                            <th>Owner Name</th> 
                                            <th>Head </th>
                                        	<th>Amount</th>                                            
                                            <th>Payment Type</th> 
                                            <th>Payment Date</th> 
                                            <th>Narration</th>  
                                            
                                           
                                        </tr>
									</thead>
                                    <tbody>
                                     <?php
									
									$slno=1;
									$sql = mysqli_query($connection,"select A.truckid,truckno from m_truck as A left join  truck_uchanti as B on A.truckid = B.truckid $cond and B.paymentdate between '$fromdate' and '$todate' group by truckid");
									while($row=mysqli_fetch_assoc($sql))
									{
										$truckid = $row['truckid'];
									$sel = "select * from truck_uchanti as A left join m_truck as B on A.truckid = B.truckid $crit && A.truckid='$truckid' order by A.paymentdate desc";
									
									?>
									
                             
											<tr>
                                            <td colspan="9" style="background-color:#00C; color:#FFF;"> TruckNo : <?php echo $row['truckno']; ?></td>
                                            
										</tr>
                                        
									<?php
									$slno=1;
									$tot_amt=0;
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row[truckid]'"); 
										$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'"); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($truckno);?></td>                                           
                                            <td><?php echo ucfirst($row['drivername']);?></td>
                                             <td><?php echo ucfirst($ownername);?></td> 
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");  ?></td>
                                            <td><?php echo ucfirst($row['uchantiamount']);?></td>
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                            <td><?php echo $cmn->dateformatindia($row['paymentdate']);?></td>
                                            <td><?php echo ucfirst($row['narration']);?></td> 
										</tr>
                                        <?php
								$tot_amt += $row['uchantiamount'];		
										
										$slno++;
									}
									?>
                                    
                                    <tr>
                                    		<td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"><?php echo number_format($tot_amt,2); ?> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"></td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            
                                    </tr>
                                      <tr>
                                           
                                            
									
                                     <td colspan="9"></td>
                                    	</tr>
                                    <?php 
									}
									?>
									</tbody>
							</table>

                
                            
                            


<script>window.close();</script>