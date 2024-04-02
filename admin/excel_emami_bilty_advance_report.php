<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='emami_bilty_advance_report.php';
$modulename = "Bilty Advance";

$crit=" ";

if (isset($_GET['search'])) {
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
} else {
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d', strtotime('-3 month', strtotime($todate)));
}



if($fromdate !='' && $todate !='')
{
		$crit.=" and adv_date between '$fromdate' and '$todate' ";	
}

if ($_GET['itemid'] != '') {
	$itemid = $_GET['itemid'];
	$crit .= " and itemid = '$itemid' ";
}
$itemid = '';

if ($_GET['selectype'] != '') {
	$selectype = $_GET['selectype'];
	$crit .= " and selectype = '$selectype' ";
}
$selectype= '';

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="emami_bilty_advance_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
										<thead>
										<tr>
                                            <th>SN</th>  
                                            <th>LR No</th>
                                            <th>Bilty Date</th>
                                        	<th>Invoice No</th>
											<th>Invoice Date</th>
											<th>E Way Bill No</th>
                                            <th>DI No</th>
											<th>Consignee</th>
											<th>Destination</th>
											 <th>Truck No</th>
										
                                            <th>Item Name</th>
                                            <th>Weight
                                            	<p>/(M.T.)</p></th>
                                            <th>Qty</th>
                                            <?php 
                                            if(@$selectype=='Advance Cash'){
                                            ?>
                                            <th>Advance</th>
                                           
                                           
                                             <?php 
                                        		 }
                                            else if(@$selectype=='Advance Diesel'){
                                            ?>
                                            <th>Diesel Rs</th>
                                            <th>Petrol Pump</th>
                                        	<?php }
                                        	else { ?>
                                        		 <th>Advance</th>
                                        		 
                                        		 <th>Diesel Rs</th>
                                        		 <th>Petrol Pump</th>
                                        	<?php } ?>
                                             <th>Other <p>Advance Date</p></th>
                                            <th>Rec. Weight</th>
											<th>Rec Bags</th>
											<th>Rec Date</th>
                                                                           	 
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
									
								// 	echo "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit  and compid='$compid' order by bid_id desc";
									 $sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit  and compid='$compid' order by bid_id desc";
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
								$advance = $row['adv_cash']+$row['adv_cheque'];
									?>
            <tr tabindex="<?php echo $slno; ?>" class="abc">
                    <td><?php echo $slno; ?></td>
					<td><?php echo $row['lr_no'];?></td>
                    <td><?php echo $row['tokendate'];?></td>
					<td><?php echo $row['invoiceno'];?></td>
					<td><?php echo $cmn->dateformatindia($row['inv_date']);?></td>
                    <td><?php echo $row['ewayno'];?></td>                    
                    <td><?php echo $row['gr_no'];?></td>
					<td><?php echo $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");?></td>
					<td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");?></td>
					

					<td><?php echo $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");?></td>
					 <td><?php echo ucfirst($row['totalweight']);?></td>
					  <td><?php echo ucfirst($row['noofqty']);?></td>
                   
                         <?php 
                                            if($selectype=='Advance Cash'){
                                            ?>              
                    <td><?php echo ucfirst($advance);?></td>
                     
                                           
                    	
                    	<?php	 }
                                            else if($selectype=='Advance Diesel'){
                                            ?>
					<td><?php echo ucfirst($row['adv_diesel']);?></td>
                    <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");?></td>
                    <?php }
                                        	else { ?>
                                     <td><?php echo ucfirst($advance);?></td>
                                     
                                     <td><?php echo ucfirst($row['adv_diesel']);?></td>
                    <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");?></td>
                                        		<?php } ?>
                                        		<td><?php echo $cmn->dateformatindia($row['adv_date']);?></td>
                    <td><?php echo ucfirst($row['recweight']);?></td>
					<td><?php echo ucfirst($row['recbag']);?></td>
					<td><?php echo $cmn->dateformatindia($row['recdate']);?></td>					
                    
                 
            </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>


<script>window.close();</script>