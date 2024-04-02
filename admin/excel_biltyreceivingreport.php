<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Billty Receiving Report";
$crit = "";

if(isset($_GET['fromdate']))
{
	$fromdate = trim(addslashes($_GET['fromdate']));
	
}
if(isset($_GET['todate']))
{
	
	$todate = trim(addslashes($_GET['todate']));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));	
}

if($consignorid !='')
{
	$crit .=" and consignorid='$consignorid' ";
}

if($fromdate !='' && $todate !='')
{
	$crit .=" and recdate between '$fromdate' and '$todate' ";
}



// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="biltyreceiving.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th >Sno</th>  
                                            <th >D.I No.</th>
											<th >GR No.</th>
											<th >Truck No.</th>
                                        	<th >Bilty Date</th>
                                            <th >Des. Wt.</th>
											 <th >Rec. Wt.</th>
											  <th >Dispatch Bags</th>
											   <th >Rec. Bags</th>
                                        	<th >Unloading Place</th>
                                            <th style="display:none;">Destination Address</th>
											<th >Recd. Dt.</th>                                            									                                            <th >Shortage(MT)</th>  
											<th >Shortage(Bags)</th>    
                                        	
                                           
										</tr>
									</thead>
                                    <tbody>
						<?php 
						$sn=1;
						
						 $sql = mysqli_query($connection,"select * from bidding_entry where 1=1 && is_bilty=1  and isreceive=1 and sessionid='$sessionid' $crit");
						while($row=mysqli_fetch_assoc($sql)) {
							
						$s = $row['tokendate'];
						$dt = new DateTime($s);											
						$date = $dt->format('d-m-Y');
						$placeid = $row['destinationid'];
						$bid_id = $row['bid_id'];
						$recweight = $row['recweight'];
						
						if($recweight==0) { $recweight= $row['totalweight']; }
						
						$destaddress = $row['destaddress'];
						$recdate = $cmn->dateformatindia($row['recdate']);
						$sortagr = $row['sortagr'];	
						$truckid = $row['truckid'];
						$noofqty = $row['noofqty'];						
						$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
						$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
						$recbag = $row['recbag'];
						
						if($recdate !='') {
						$sortagbag = $noofqty - $row['recbag'];
						}
						else
						$sortagbag='';	 
						
						
						
						?>
                      
					<tr>
							 <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['di_no']; ?></td>
							<td><?php echo $row['gr_no']; ?></td>
							<td><?php echo $truckno; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $row['totalweight']; ?></td>                        
                            <td><?php echo $recweight; ?></td>						
							<td><?php echo $row['noofqty']; ?></td>                        
                            <td><?php echo $recbag; ?>   </td>
                            <td> <?php echo $placename; ?>  </td>
                            <td style="display:none;"> 
							<?php echo $destaddress; ?></td>
                            <td><?php echo $recdate; ?>   </td>
                            <td><?php echo $sortagr; ?> </td>
							<td><?php echo $sortagbag; ?> </td>
							
                        </tr>
                    	<?php 
						}
						
						?>
                    
									</tbody>
								</table>
                            
                                


<script>window.close();</script>