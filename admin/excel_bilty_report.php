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

if(isset($_GET['itemid']))
{
	$itemid = trim(addslashes($_GET['itemid']));
	
}

if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));
	
}

if(isset($_GET['truckid']))
{
	$truckid=trim(addslashes($_GET['truckid']));
}
else
$truckid='';


if($fromdate !='' && $todate !='')
{
		$crit.=" and gr_date between '$fromdate' and '$todate' ";	
}

if($itemid !='') {
	$crit .=" and itemid='$itemid' ";
}

if($truckid !='') {
	$crit .=" and truckid='$truckid' ";
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bilty_report.xls";
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
                                            <th>Advance</th>
                                            <th>Diesel Rs</th>
                                            <th>Petrol Pump</th>
                                            <th>Brand</th>                                       	 
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
									
								$tot_weight=0;
								$tot_own_rate=0;
								$tot_freight=0;
								$tot_advance=0;
								$tot_adv_diesel=0;
									
									 $sel = "select * from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit order by bid_id desc";
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
                    <td><?php echo number_format($advance,2);?></td>
                    <td><?php echo ucfirst($row['adv_diesel']);?></td>
                     <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");?></td> 
                    <td><?php echo $cmn->getvalfield($connection,"brand_master","brand_name","brand_id='$brand_id'");?></td>
                  
            
            </tr>
                                        <?php
							$tot_weight += $row['totalweight'];
							$tot_own_rate += $row['own_rate'];
							$tot_freight += $row['totalweight'] * $row['own_rate'];
							$tot_advance += $advance;
							$tot_adv_diesel += $row['adv_diesel'];
										
										$slno++;
								}
									?>
                                    
                                    
                      <tr style="background-color:#03F; color:#FFF;">
                      			<th style="text-align:right;background-color:#03F; color:#FFF;" colspan="9">Total</th>
                                <th style="text-align:right;background-color:#03F; color:#FFF;"><?php echo number_format($tot_weight,2); ?></th>
                                <th style="text-align:right;background-color:#03F; color:#FFF;"><?php echo number_format($tot_own_rate,2); ?></th>
                                <th style="text-align:right;background-color:#03F; color:#FFF;"><?php echo number_format($tot_freight,2); ?></th>
                                <th style="text-align:right;background-color:#03F; color:#FFF;"><?php echo number_format($tot_advance,2); ?></th>
                                <th style="text-align:right;background-color:#03F; color:#FFF;"><?php echo number_format($tot_adv_diesel,2); ?></th>
                                <th></th>
                                <th></th>
                      </tr>              
									</tbody>
							</table>


<script>window.close();</script>