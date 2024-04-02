<?php  
include("dbconnect.php");

?>

<table class="table table-hover table-nomargin table-bordered">
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
										//$cond="where createdby='$userid' ";	
										$cond="where 1=1 ";
									}
									
                                 $curdate = date('Y-m-d');
								 $olddate =  date("Y-m-d", strtotime("-1 months")); 
                                   
									$sel = "select * from bidding_entry $cond && sessionid='$sessionid' && is_bilty=0 and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$olddate' and '$curdate'  order by tokendate desc limit 500";
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