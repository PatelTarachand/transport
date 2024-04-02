<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='excel_bilty_report.php';
$modulename = "Billty Report";

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

if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
}

if(isset($_GET['itemid']))
{
	$itemid = trim(addslashes($_GET['itemid']));
	
}

if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));
	
}

$crit =" ";



// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bilty_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table border="1" >
									
                                    <thead>
                                    
										<tr>
                                            <th>Sno</th>  
                                            <th>Di No.</th>
                                            <th>Truck No.</th>
                                            <th>From Place</th>
                                            <th>Ship to Place</th>
                                            <th>Owner Name</th>
                                        	<th>Item</th>
                                            <th>Weight</th>
                                            <th>Final Rate(Mt)</th>
                                            <th>Advance Cash</th>
                                            <th>Advance Diesel</th>
                                            <th>Diesel ltr</th>
                                            <th>Other Advance Cash </th>
                                            <th> Advance (Consignor) </th>
                                            <th>Advance Cheque Amt</th>
                                            <th>Cheque No.</th>
                                            <th>Cheque Date</th>
                                            <th>Bank Name</th>
                                            <th>Advance Date</th>
                                        	
                                            
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from bidding_entry where isdispatch=1 && sessionid='$sessionid' $crit";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];	
										$itemid = $row['itemid'];
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										
							
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");							
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                             <td><?php echo $truckno;?></td>
                                              <td><?php echo ucfirst($row['placeid']);?>  
                                            </td>
                                             <td><?php echo ucfirst($row['destinationid']);?>  
                                            </td>
                                            <td><?php echo $ownername;?></td>
                                            <td><?php echo $itemname;?>  </td> 
                                            <td><?php echo ucfirst($row['totalweight']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['own_rate']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_cash']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_diesel']);?></td>
                                            <td><?php echo ucfirst($row['adv_dieselltr']);?></td>
                                            <td><?php echo ucfirst($row['adv_other']);?></td>
                                            <td><?php echo ucfirst($row['adv_consignor']);?></td>
                                            <td><?php echo ucfirst($row['adv_cheque']);?></td>
                                            <td><?php echo ucfirst($row['cheque_no']);?></td>
                                            <td><?php echo ucfirst($row['advchequedate']);?></td>
                                            <td><?php echo ucfirst($row['bankid']);?></td>
                                            <td><?php echo ucfirst($row['adv_date']);?></td>
                                            
                                              
                                                                                   
                                            
										</tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
</table>


<script>window.close();</script>