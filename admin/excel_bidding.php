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
                                            <th>Di no.</th>
                                             <th>Di Date</th>
                                        	<th>Consignor</th>
                                            <th>From Place</th>
                                            <th>Ship to City</th>
                                            <th>Session </th>
                                            <th>Item</th>
                                            <th>Company Rate/(M.T.)</th>
                                            <th>Own Rate/(M.T.)</th>
                                            <th>Total Weight/(M.T.)</th>
                                            <th>Brand</th>
                                            <th>Order No.</th>
                                            <th>Order type</th>
                                            <th>Remark</th>
                                             <!--<th>Print</th>-->
                                        	
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
										$cond="where createdby='$userid' ";	
									}
									
									
									 $sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as biddingdate from bidding_entry $cond && sessionid='$sessionid' $crit order by bid_id desc limit 500";
									
							
									
									
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
								
								$s = $row['tokendate'];
								$dt = new DateTime($s);
								
								$date = $dt->format('d-m-Y');
								$time = $dt->format('H:i:s');


									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                             <td><?php echo $date;?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?></td>
                                             <td><?php echo ucfirst($row['placeid']);?></td>
                                             <td><?php echo ucfirst($row['destinationid']);?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_session","session_name","sessionid = '$row[sessionid]'"));?></td>
                                             <td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>
											<td><?php echo ucfirst($row['comp_rate']);?></td>

                                            <td><?php echo ucfirst($row['own_rate']);?></td>
                                            
                                            <td><?php echo ucfirst($row['totalweight']);?></td>
                                            <td><?php echo ucfirst($row['order_no']);?></td>
                                            <td><?php echo ucfirst($row['order_type']);?></td>
											<td><?php echo ucfirst($row['remark']);?></td>

                                           <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                           
                                           
                                            
										</tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
</table>


<script>window.close();</script>