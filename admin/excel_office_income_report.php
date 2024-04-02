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

if(isset($_GET['head_id']))
{
	$head_id = addslashes(trim($_GET['head_id']));
}
else
{
	$head_id='';	
}

if(isset($_GET['payment_type']))
{
	$payment_type = addslashes(trim($_GET['payment_type']));
}
else{
	$payment_type='';	
}

$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{

	$crit .= " and paymentdate between '$fromdate' and '$todate'";
}	


if($head_id !='')
{
	$crit .= " and  head_id ='$head_id' ";
	
}

if($payment_type !='')
{
	$crit .= " and  payment_type ='$payment_type' ";
	
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
                                        <tr><th colspan="8"><strong>BPS : ALL OFFICE INCOME REPORT DETAILS</strong></th> </tr>																								
                                        <tr><th colspan="8">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="8">OFFICE INCOME REPORT SUMMERY</th></tr>	                                   
                                    </tr>
								      <tr>
                                        <th>Sno</th>  
                                            <th>Type</th> 
                                            <th>Payee Name</th> 
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
									$totalexp = 0;
									$sql = "select * from otherincome  $crit  order by paymentdate desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{		
									$incomeamount = 0;
									$incomeamount = $row['incomeamount'];
									$truckid = $row['truckid']; 
									$stype = $row['stype'];
									$payeename = $row['payeename'];
									if($truckid !='0')
									{
										$stype= "Truck";	
										$payeename =$row['drivername'];
									}  
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($stype);?></td>                                          
                                            <td><?php echo ucfirst($payeename);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");  ?></td>
                                            <td style="text-align:right;"><?php echo ucfirst($row['incomeamount']);?></td>
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                             <td><?php echo $cmn->dateformatindia($row['paymentdate']);?></td>
                                              <td><?php echo $row['narration']; ?></td>
                                            
										</tr>
                                        <?php
										$slno++;
										$totalexp += $incomeamount;
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
                                           <td style="background-color:#00F; color:#FFF;"> </td>
                                    </tr>									
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>