<?php
error_reporting(0);
include("dbconnect.php");
$pagename = "sale_report.php";
$modulename = "Sale Report";

$tblname = "sale_entry";
$tblpkey = "saleid";
if ($_GET['action'] != '') {
	$action = $_GET['action'];
} else {
	$action = '';
}

$sale_date = date('Y-m-d');

$cond = '';

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
} else {
	$fromdate = '2022-07-01';
	$todate = date('Y-m-d');
}

if (isset($_GET['customer_id'])) {
	$customer_id  = trim(addslashes($_GET['customer_id']));
} else
	$customer_id = '';

if (isset($_GET['bill_type'])) {
	$bill_type  = trim(addslashes($_GET['bill_type']));
} else
	$bill_type = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {


	$crit .= " and  sale_date   between '$fromdate' and '$todate'";
}

if ($customer_id != '') {
	$crit .= " and customer_id ='$customer_id'";
}
if ($bill_type != '') {
	$crit .= " and bill_type ='$bill_type'";
}
if ($_GET['saleid'] != "") {

	// echo "update sale_entry  set is_complete=0  where is_complete=1 and saleid='$saleid";
	mysqli_query($connection, "update sale_entry  set is_complete=0  where is_complete=1 and saleid='$saleid");
 }

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="purchase_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table border="1">
											<thead>
										<tr>
											<th>Sno</th>
											<th > Date </th>
                                                <th> Customer Name </th>
											
                                            <th> Bill Type </th>
											<!-- <th> Qty </th> -->
											<!-- <th>Rate </th> -->
                                        <th>Remark</th>
                                       <th> Net Total</th>
                                         
                                           
										</tr>
									</thead>
                                    <tbody>
										<?php
										$slno = 1;
										// echo "select * from sale_entry where 1=1 $crit";
										$sel = "select * from sale_entry where 1=1 $crit ";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
											$customer_name = $cmn->getvalfield($connection, "m_customer", "customer_name", "customer_id='$row[customer_id]'");
											$total_amt = $cmn->getvalfield($connection, "saleentry_detail", "sum(nettotal)", "saleid='$row[saleid]'");
											$itemid = $cmn->getvalfield($connection, "saleentry_detail", "itemid", "saleid='$row[saleid]'");
											$qty = $cmn->getvalfield($connection, "saleentry_detail", "qty", "saleid='$row[saleid]'");
											$saleid=$row['saleid'];
											// $rate=$row['rate'];
											$bill_type=$row['bill_type'];
											$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid ='$itemid'");
											
										?>
											<tr>
												<td><?php echo $slno; ?></td>
												<td><?php echo dateformatindia($row['sale_date']); ?></td>

												<td><?php echo $customer_name; ?></td>

												
												<td><?php echo ucfirst($row['bill_type']); ?></td>
												<!-- <td><?php echo $qty; ?></td> -->
												<!-- <td><?php echo $rate; ?></td> -->
												<td><?php echo ucfirst($row['remark']); ?></td>
												<td><?php echo number_format($total_amt,2); ?></td>

											

												 
											
											</tr>
											
										<?php
											$totalamt += $total_amt;
	$totqty += $qty;
											$slno++;
										}
										?>
										
										<tfoot>
<tr><th></th><th></th><th></th><th></th><th>Total</th><th></th><th><?php echo $totalamt; ?></th></tr>

</tfoot>	
										
									</tbody>
									
								</table>


