<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='return_billty_record2.php';
$modulename = "Billty";
//print_r($_SESSION);
// $sale_date = date('Y-m-d');
$cond = '';
if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
 } else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
 }
 if (isset($_GET['bid_id'])) {
	$bid_id = trim(addslashes($_GET['bid_id']));
 } else
	$bid_id = '';
 
 
 
 
 
 if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));	
}
else
$consignorid = '';

if(isset($_GET['consigneeid']))
{
	$consigneeid = trim(addslashes($_GET['consigneeid']));	
}
else
$consigneeid = '';


if(isset($_GET['truckid']))
{
	$truckid = trim(addslashes($_GET['truckid']));	
}
else
$truckid = '';


 $crit = " ";
 if ($fromdate != "" && $todate != "") {
 
	$crit .= " and  tokendate between '$fromdate' and '$todate'";
 }
 
 if($consignorid !='') {
	
	$crit .=" and consignorid='$consignorid'";
	
	}
	if($consigneeid !='') {
	
	$crit .=" and consigneeid='$consigneeid'";
	
	}

	if($truckid !='') {
	
	$crit .=" and truckid='$truckid'";
	
	}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="excel_emami_bilty_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table border="1">
									<thead>
										<tr>
                                   <th>Sno</th>  
											<th>LR No</th>
											<th>Bilty No</th>
											<th>Bilty Date</th>
										
										<th>	Consignor</th>
											<th>Consignee</th>
											<th>Truck No.</th>
											<th>Destination</th>
											<th>Item</th>
											<th>Weight/(M.T.)</th>
											<th>Qty(Bags)</th>
											<th>Comp Rate</th>
											<th>Freight Rate</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{   $payUser=1;
										$cond="where compid='$_SESSION[compid]' ";	
									}
									else
									{
									    $payUser=0;
										//$cond="where createdby='$userid' ";	
										$cond="where compid='$_SESSION[compid]' ";											
									}
								//  echo "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from returnbidding_entry where 1=1 $crit  && sessionid='$sessionid' && is_bilty=1  and compid='$compid' order by bid_id desc limit 0,100";
									$sel =  "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from returnbidding_entry where 1=1 $crit && sessionid='$sessionid'   and compid='$compid' ";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									    $paydone=$row['is_complete'];
									    	$truckid = $row['truckid'];	
									    $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										  $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'");
									?>
									<tr tabindex="<?php echo $slno; ?>" class="abc">
						<td><?php echo $slno; ?></td>						
						<td><?php echo ucfirst($row['lr_no']);?></td>
						<td><?php echo ucfirst($row['bilty_no']);?></td>
						<td><?php echo  $row['tokendate'];?></td>
					
								<td><?php echo  $consignorname;?></td>		
						<td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
						<td><?php echo $truckno;?></td>
						<td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
						
						<td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>						
						<td><?php echo ucfirst($row['totalweight']);?></td>						
												
						<td><?php if($row['noofqty']!='0') { echo ucfirst($row['noofqty']); } ?></td>
						<td><?php if($row['comp_rate']!='0'){ echo ucfirst($row['comp_rate']); } ?></td>
						<td><?php  if($row['own_rate']!='0'){ echo $row['own_rate']*$row['totalweight']; } ?></td>
						<td><a href= "pdf_bilty_invoice_emami.php?bid_id=<?php echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>
					
						
					
										</tr>
                                        <?php
										$slno++;
								}
									?>
                                    
                   
									</tbody>
							</table>


<script>window.close();</script>