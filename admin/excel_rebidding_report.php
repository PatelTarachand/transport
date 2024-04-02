<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='excel_bilty_report.php';
$modulename = "Billty Report";
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

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="rebidding.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									
                                    <thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Di no.</th>
                                        	<th>Consignee</th>
                                           <th>Sheep To City</th>
                                            <th>Item</th>
                                            <th>Company Rate/(M.T.)</th>
                                            <th>Own Rate/(M.T.)</th>
                                            <th>Total Weight/(M.T.)</th>
                                             <th>Bidding Date</th>
                                           <th>Pending Hour</th>
										</tr>
									</thead>
                                    <tbody>
                                    
                                 
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										$cond="where 1=1 ";	
									}
									
                                 //curdate  
								 $olddate =  date("Y-m-d", strtotime("-1 months")); 
                                   
									$sel = "select * from bidding_entry $cond && sessionid='$sessionid' && is_bilty=0 and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$fromdate' and '$todate'  order by bid_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
 									
											$s = $row['tokendate'];
											$dt = new DateTime($s);											
											$date = $dt->format('d-m-Y');
											$time = $dt->format('H:i');
											
																						
											$minutes = round((strtotime($s) - time()) / 60);
											$hour = ceil($minutes/60);
											$minute = $minutes%60;

									?>
                                    
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
                                             <td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>
											<td><?php echo ucfirst($row['comp_rate']);?></td>

                                            <td><?php echo ucfirst($row['own_rate']);?></td>
                                            
                                            <td><?php echo ucfirst($row['totalweight']);?></td>
                                            <td><?php echo $date.' '.$time;?></td>
											<td  style="color:red;"><span class="blink"><b><?php echo abs($hour).' h and '.abs($minute).' m'; ?></b></span></td>

                                        
                                           
                                            
										</tr>
                                      <?php
										$slno++;
								
									}
									
									
                                     
									?>
									</tbody>
							</table>


<script>window.close();</script>