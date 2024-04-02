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

if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
}

if(isset($_GET['supplier_id']))
{
	$supplier_id = trim(addslashes($_GET['supplier_id']));
	
}

if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));
	
}


if($fromdate !='' && $todate !='')
{
		$crit.=" and DATE_FORMAT(adv_date,'%Y-%m-%d') between '$fromdate' and '$todate' ";	
}

if($supplier_id !='') {
	$crit .=" and supplier_id='$supplier_id' ";
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bilty_advance_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                             <th>Sno</th>  
                                            <th>GR Date</th>
                                            <th>GR No</th>
                                        	<th>Invoice No</th>
                                            <th>DI No</th>
											<th>Item Name</th>
                                            <th>Truck No</th>
                                            <th>Consignee</th>
                                            <th>Destination</th>
                                            <th>Weight/(M.T.)</th>
                                            <th>Rate/MT</th>
                                             <!--<th>Print</th>-->
                                             
                                            <th>Freight</th>
											<th>Advance Date</th>
                                            
                                            <th>Diesel Rs</th>
                                            <th>Petrol Pump</th>                                 	 
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
										//$cond="where createdby='$userid' ";	
									}
									
								$tot_weight=0;
								$tot_own_rate=0;
								$tot_freight=0;
								$tot_advance=0;
								$totaldieseladv=0;
									
									 $sel = "select * from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit  && isdispatch=1 && adv_diesel !=0 && consignorid !=4 order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{									
								$gr_date = $row['gr_date'];
								$truckid = $row['truckid'];
								$itemid = $row['itemid'];
								$consigneeid = $row['consigneeid'];
								$destinationid = $row['destinationid'];
								$supplier_id = $row['supplier_id'];
								$brand_id = $row['brand_id'];
								$s = $row['bilty_date'];
								$dt = new DateTime($s);								
								$date = $dt->format('d-m-Y');
								$time = $dt->format('H:i:s');	
								$adv_dieselltr = $row['adv_dieselltr'];
								$advance = $row['adv_cash']+$row['adv_other']+$row['adv_consignor']+$row['adv_cheque'];
									?>
            <tr>
                    <td><?php echo $slno; ?></td>
                    <td><?php echo $cmn->dateformatindia($row['gr_date']);?></td>
                    <td><?php echo $row['gr_no'];?></td>
                    <td><?php echo $row['invoiceno'];?></td>
                    <td><?php echo $row['di_no'];?></td>
					<td><?php echo $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");?></td>
                    <td><?php echo $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");?></td>
                    <td><?php echo ucfirst($row['totalweight']);?></td>
                    <td><?php echo ucfirst($row['own_rate']);?></td>
                    
                    <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                    
                    <td><?php echo number_format($row['totalweight'] * $row['own_rate'],2);?></td>
					<td><?php echo $cmn->dateformatindia($row['adv_date']); ?></td>
                    
                    <td><?php echo ucfirst($row['adv_diesel']);?></td>
                    
                   <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");?></td> 
                  
            
            </tr>
                                        <?php
							$totaldieseladv += $row['adv_diesel'];
										
										$slno++;
								}
									?>
                                    
                                    
<tr style="background-color:#0000CC; color:#FFFFFF;">
										<td  colspan="13">Total</td>
										<td><strong><?php echo number_format($totaldieseladv,2); ?></strong></td>
										<td></td>
								</tr>	
									</tbody>
							</table>


<script>window.close();</script>