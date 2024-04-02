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

if(isset($_GET['itemid']))
{
	$itemid=trim(addslashes($_GET['itemid']));
}
else
$itemid='';

if(isset($_GET['is_invoice']))
{
	$is_invoice = trim(addslashes($_GET['is_invoice']));
}
else
$is_invoice='';


if(isset($_GET['type']))
{
	$type = trim(addslashes($_GET['type']));
}
else
$type='';


if($fromdate !='' && $todate !='')
{
		$crit.=" and gr_date between '$fromdate' and '$todate' ";	
}

if($itemid !='') {
	$crit .=" and itemid='$itemid' ";
}

if($is_invoice !='') {
	$crit .=" and A.is_invoice='$is_invoice' ";
}


if($type !='') {
	$crit .=" and B.type='$type' ";
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bilty_status_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table class="table table-hover table-nomargin table-bordered" style=" margin-left:8px;">
									<thead>
										<tr>
                                            <th>All </th>  
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
                                          
                                            <th>Invoice No</th>
											 <th>Invoice Date</th>
										</tr>
									</thead>
                                    <tbody id="myTable">
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
									
									 $sel = "select A.* from bidding_entry as A left join m_consignee as B on A.consigneeid = B.consigneeid $cond  && A.is_bilty=1 $crit   order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{									
								$gr_date = $row['gr_date'];
								$is_invoice = $row['is_invoice'];
								$invoiceid = $row['invoiceid'];
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
								
								$invno = $cmn->getvalfield($connection,"invoicebilty","invno","invoiceid='$invoiceid'");
								
								if($invno=='') { $invno="Unbilled"; }	
								$invdate = $cmn->getvalfield($connection,"invoicebilty","invdate","invoiceid='$invoiceid'");	
								
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
                                        
                   <td><?php echo $invno;?></td>
				   <td><?php echo $invdate;?></td> 
                  
            
            </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>


<script>window.close();</script>