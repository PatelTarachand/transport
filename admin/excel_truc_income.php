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

	$crit .= " and createdate between '$fromdate' and '$todate'";
}	

$enddate = date("t", strtotime($fromdate));
// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin table-bordered" border="1">
									<thead>
                                    <tr>
                                        <tr><th colspan="7"><strong>BPS : ALL Truck Income </strong></th> </tr>																								
                                       <tr><th colspan="7">Date:<?php echo $cmn->dateformatindia($fromdate);?></th></tr>
                                        <tr><th colspan="7">Truck Income</th></tr>	                                   
                                    </tr>
								<tr>
                                               
                                               <th>Sno</th>    
                                            <th>Truck No</th> 
                                            <th>Driver Name</th> 
                                            <th>Head </th>
                                        	<th>Amount</th>                                            
                                            <th>Payment Type</th> 
                                            <th>Payment Date</th> 
                                                                                                                          					 								</tr>
									</thead>
                                    <tbody>
                                    <?php
                                     $slno=1;
									$totalexp = 0;
									//echo "select * from otherincome where truckid !=0 order by paymentdate desc";die;
									$sql = "select * from otherincome $crit and truckid !=0 order by createdate desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{	
									
									$incomeamount = 0;
									$incomeamount = $row['incomeamount'];
									
									$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($truckno);?></td>                                          
                                            <td><?php echo ucfirst($row['drivername']);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");  ?></td>
                                            <td><?php echo ucfirst($row['incomeamount']);?></td>
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                             <td><?php echo $cmn->dateformatindia($row['paymentdate']);?></td>
                                               
                                            
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
                                            <td style="background-color:#00F; color:#FFF;"><strong><?php echo number_format($totalexp,2); ?></strong> </td>
                                        <td style="background-color:#00F; color:#FFF; text-align:right;"></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                             <td style="background-color:#00F; color:#FFF;"> </td>
                                           
                                            
                                    </tr>						
									
										
										
									</tbody>
                                    
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>