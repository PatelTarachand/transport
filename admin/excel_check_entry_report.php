<?php include("dbconnect.php");

$crit='';
if(isset($_GET['fromdate'])!="" && isset($_GET['todate']) !="")
{
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['party_name']))
{
	$party_name = addslashes(trim($_GET['party_name']));
}

if(isset($_GET['check_no']))
{
	$check_no = addslashes(trim($_GET['check_no']));
}

$crit = " where 1 = 1 ";
if($fromdate!="" && $todate !='')
{

	$crit .= " and check_date between '$fromdate' and '$todate'";
}	


if($party_name !='')
{
	$crit .= " and  party_name ='$party_name' ";
	
}

if($check_no !='')
{
	$crit .= " and  check_no ='$check_no' ";
	
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
                                        <tr><th colspan="6"><strong>BPS : ALL CHEQUE ENTRY REPORT DETAILS</strong></th> </tr>																								
                                         <tr><th colspan="6">DATE :<?php echo $cmn->dateformatindia($fromdate);?> To <?php echo $cmn->dateformatindia($todate);?></th></tr>	
                                        <tr><th colspan="6">CHEQUE ENTRY REPORT SUMMERY</th></tr>	                                   
                                    </tr>
										<tr>
                                             <th>Sno</th>
                                            <th>Name Of Party</th>
                                            <th>Cheque No</th>
                                           	<th>Cheque Amount</th>
                                            <th>Remark</th>
                                             <th>Date</th> 
                                        </tr>
									</thead>
                                    <tbody>
                                      <?php
									
									$slno=1;
									$totalexp = 0;
									$sel = "select * from check_entry $crit order by check_entry_id desc "; 
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										        $check_amount = 0;									
												$check_amount = $row['check_amount'];
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo  $row['party_name']; ?></td>
                                            <td><?php echo $row['check_no']; ?></td>
                                           <td><?php echo $row['check_amount']; ?></td>
                                            <td><?php echo $row['remark'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['check_date']); ?></td>
										</tr>
                                        <?php
										$slno++;
										$totalexp += $check_amount;
									}
									?>
										
                                    <tr>
                                    		<td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php echo number_format($totalexp,2); ?></strong> </td>
                                        <td style="background-color:#00F; color:#FFF;"></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            
                                           
                                    </tr>							
									</tbody>
							</table>

                
<script>window.close();</script>