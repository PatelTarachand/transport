<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Billty Receiving Report";
$crit = " where 1=1 ";




// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="manualbillpayment.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>Invoice No</th>
											<th>Invoice Date</th>
											<th>Qty</th>
											<th>Amount</th>
											
											<th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									if($usertype=='admin')
									{
									$crit="";
									}
									else
									{
									//$crit=" && createdby='$userid'";	
									$crit="";
									}	
									$sel = "select  * from  manualinv order by minvid";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $row['invno'];?></td>
							<td><?php echo $cmn->dateformatindia($row['invdate']);?></td>
                             <td><?php echo $row['qty'];?></td>
                            <td><?php echo $row['amount'];?></td>
                           
                           
                            <td class='hidden-480'>
                           <a href= "?minvid=<?php echo ucfirst($row['minvid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
						    &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['minvid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
						   
                           </td>
                        </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>
                            
                                


<script>window.close();</script>