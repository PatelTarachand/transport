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

if(isset($_GET['truckid']))
{
	$truckid = addslashes(trim($_GET['truckid']));
}
if(isset($_GET['head_id']))
{
	$head_id = addslashes(trim($_GET['head_id']));
}

$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{

	$crit .= " and deduct_date between '$fromdate' and '$todate'";
}	


if($truckid !='')
{
	$crit .= " and  truckid ='$truckid' ";	
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
                                        <tr><th colspan="6"><strong>BPS : SALARY DEDUCTION DETAILS</strong></th> </tr>																								
                                        <tr><th colspan="6">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="6">TRUCK INCOME REPORT SUMMERY</th></tr>	                                   
                                    </tr>
								      <tr>
                                        <th>Sno</th>  
                                            <th>Truck No</th> 
                                            <th>Driver Name</th>                                           
                                        	<th>Amount</th>   
                                            <th>Deduction Date</th>  
                                            <th>Narration</th>
                                            
                                     </tr>
									</thead>
                                    <tbody>
                                   <?php
								  
									$slno=1;
									$totalexp = 0;
									$sql = "select * from salary_deduction $crit order by deduct_date desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{	
									
									$deduct_amt = 0;
									$deduct_amt = $row['deduct_amt'];
									
									$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($truckno);?></td>                                          
                                            <td><?php echo ucfirst($row['drivername']);?></td>                                           
                                            <td style="text-align:right;"><?php echo ucfirst($row['deduct_amt']);?></td>                                         
                                             <td><?php echo $cmn->dateformatindia($row['deduct_date']);?></td>
                                              <td><?php echo $row['narration']; ?></td> 
                                            
										</tr>
                                       <?php
										$slno++;
										$totalexp += $deduct_amt;
									}
									?>
									
                                    <tr>
                                    		<td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>                                          
                                        <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php echo number_format($totalexp,2); ?></strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                    </tr>								
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>