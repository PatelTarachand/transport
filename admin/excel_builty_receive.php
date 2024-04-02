<?php
include("dbconnect.php");
$tblname = "";
$tblpkey = "";
$pagename = "builty_receive.php";
$modulename = "Bilty Receiving Report";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

$cond=' ';


if(isset($_GET['start_date']))
{
	$start_date = $_GET['start_date'];	
}
else
$start_date = date('Y-m-d');

if(isset($_GET['end_date']))
{
	$end_date = $_GET['end_date'];	
}
else
$end_date = date('Y-m-d');

if(isset($_GET['di_no']))
{
	$di_no = trim(addslashes($_GET['di_no']));	
}
else
$di_no = '';

if($di_no !='') {
	
	$cond .=" and lr_no='$di_no'";
	
	}
	
if($start_date !='' && $end_date !='')
{
		$cond .=" and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$start_date' and '$end_date' ";
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="builty_receive.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table border="1">
									<thead>
										<tr>
                                            <th >Sno</th>  
                                          
											<th >LR No.</th>
											<th >Truck No.</th>
                                        	<th >Bilty Date</th>
                                            <th >Des. Wt.</th>
											 <th >Rec. Wt.</th>
											  <th >Dispatch Bags</th>
											   <th >Rec. Bags</th>
                                        	<th >Unloading Place</th>
                                            
											<th >Recd. Dt.</th>                                            									                                            
											<th >Shortage(MT)</th>  
											<th >Shortage(Bags)</th> 
                                             <th>Final Pay</th>  
                                             <th>Action</th>  

                                        
                                           
										</tr>
									</thead>
                                    <tbody>
						<?php 
						$sn=1;
				// 		echo "select * from bidding_entry where 1=1 && is_bilty=1 and compid='$compid' and isreceive!=0 $cond and sessionid =$sessionid";
						
						$sql = mysqli_query($connection,"select * from bidding_entry where 1=1 && is_bilty=1 and compid='$compid' and isreceive!=0 $cond and sessionid =$sessionid");
						while($row=mysqli_fetch_assoc($sql)) {
							
						$s = $row['tokendate'];
						$dt = new DateTime($s);											
						$date = $dt->format('d-m-Y');
						$placeid = $row['placeid'];
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
						
						$fpay = $row['fpay'];
						
						?>
                      
					<tr>
							 <td><?php echo $sn++; ?></td>
                          
							<td><?php echo $row['lr_no']; ?></td>
							<td><?php echo $truckno; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><span id="totalweight<?php echo $bid_id; ?>"><?php echo $row['totalweight']; ?></span></td>
                        
                            <td>
							<span id="rec1" style="color:red;" >*</span>
                            <input type="text" class="input-small" value="<?php echo $recweight; ?>" id="recweight<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:140px; width:60px;"  autocomplete="off" onChange="getshortage(<?php  echo $bid_id; ?>);" >
                            </td>
							
							
							 <td><span id="totalbag<?php echo $bid_id; ?>"><?php echo $row['noofqty']; ?></span></td>
                        
                            <td>
							<span style="color:red;" >*</span>
                            <input type="text" class="input-small" value="<?php echo $recbag; ?>" id="recbag<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:140px;width:60px;"  autocomplete="off" onChange="getshortage(<?php  echo $bid_id; ?>);" >
                            </td>
							
							
                            <td> <?php echo $placename; ?>  </td>
							
                            
                            <td>
							<span id="recdate1" style="color:red;" >*</span>
							 <input type="text" class="formcent recdate" value="<?php echo $recdate; ?>" id="recdate<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:80px;"  autocomplete="off" 
                                      >
                            </td>
                            <td>
							<input type="text" value="<?php echo $sortagr; ?>" id="sortagr<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;background-color:#6CF;width:60px;"  autocomplete="off"  readonly >  
							</td>
							
							<td>
							<input type="text" value="<?php echo $sortagbag; ?>" id="sortagbag<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;background-color:#6CF;width:60px;"  autocomplete="off"  readonly >  
							</td>
							<td>
                          <input type="text" class="input-small" value="<?php echo $fpay; ?>" id="fpay<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:80px;"  autocomplete="off" >  
                            </td>
							<td>    <a onClick="funDelotp('<?php echo $row['bid_id']; ?>');"><img src="../img/del.png" title="Delete"></a>
										   <input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_delete_<?php echo  $row['bid_id'] ; ?>" onClick="funDel('<?php echo $row['bid_id'];?>');" value="X"></td>
                          
                    </tr>
                    	<?php 
						}
						
						?>
                    
									</tbody>
								</table>


<script>window.close();</script>