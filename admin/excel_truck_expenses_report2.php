<?php  include("dbconnect.php");
$tblname = 'truck_expense';
$tblpkey = 'truck_expenseid';
$pagename  ='truck_expenses_report.php';
$modulename = "Billty Report";

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
	$head_id ='';	
}

if(isset($_GET['payment_type']))
{
	$payment_type = addslashes(trim($_GET['payment_type']));
}
else
{
	$payment_type='';	
}

if(isset($_GET['truckid']))
{
	$truckid = addslashes(trim($_GET['truckid']));
}
else
{
	$truckid='';	
}

if(isset($_GET['drivername']))
{
	$drivername = addslashes(trim($_GET['drivername']));
}
else
{
	$drivername='';	
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
if($truckid !='')
{
	$crit .= " and  truckid ='$truckid' ";
	
}

if($drivername !='')
{
	$crit .= " and  drivername ='$drivername' ";
	
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
                                        <tr><th colspan="8"><strong>BPS : ALL TRUCK EXPENSES REPORT DETAILS</strong></th> </tr>																								
                                         <tr><th colspan="8">FROM DATE :<?php echo $cmn->dateformatindia($fromdate);?>&nbsp;&nbsp;&nbsp;TO DATE :<?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="8">TRUCK EXPENSES REPORT SUMMERY</th></tr>	                                   
                                    </tr>
										<tr>
                                             <th>Sno</th>  
                                            <th>Head</th> 
                                            <th>Truck No </th>
                                             <th>Driver Name</th> 
                                        	<th>Amount</th>                                            
                                            <th>Payment Type</th> 
                                            <th>Payment Date</th>  
                                            <th>Narration</th>
                                        </tr>
									</thead>
                                    <tbody>
                                     <?php
									
									//echo "select * from truck_expense $crit";
									$slno=1;
									
									$totalexp = 0;
									//echo "select * from truck_expense $crit order by paymentdate desc";
									$sql = mysqli_query($connection,"select * from truck_expense $crit  && head_id not in('9','10','11','12','13') order by paymentdate desc");
									while($row = mysqli_fetch_array($sql))
									{		
										$uchantiamount = 0;									
										$uchantiamount = $row['uchantiamount'];

									//$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'"); ?>
									
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");  ?></td>
											 <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"); ?> </td>
                                             <td><?php echo $cmn->getvalfield($connection,"truck_expense","drivername","truckexpenseid='$row[truckexpenseid]'");  ?></td>
                                         		<td style="text-align:right;"><?php echo($row['uchantiamount']);?></td>
                                            	<td><?php echo($row['payment_type']);?></td> 
                                             <td><?php echo $cmn->dateformatindia($row['paymentdate']);?></td>
                                          <!--     <td><a href= "pdfreciept_truck_expenses.php?truck_expenseid=<?php echo $row['truck_expenseid'];?>" class="btn btn-success" target="_blank" >Print Reciept</a></td>-->
                                         <td><?php echo($row['narration']);?></td> 
                                           
										</tr>
                                         <?php
										$slno++;
										$totalexp += $uchantiamount;
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