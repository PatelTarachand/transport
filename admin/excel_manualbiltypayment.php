<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Billty Receiving Report";
$crit = " where 1=1 ";




// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="manualbiltypayment.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>Owner Name</th>
											<th>Truck No</th>
											<th>Payment Date</th>
											<th>Qty</th>
											<th>Amount</th>
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
									$sel = "select  * from  manualbiltypayment order by mbiltypayid";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'")?></td>
							<td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'")?></td>
							<td><?php echo $cmn->dateformatindia($row['paydate']);?></td>
                             <td><?php echo $row['qty'];?></td>
                            <td><?php echo $row['amount'];?></td>
                           
                           
                           
                        </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>
                            
                                


<script>window.close();</script>