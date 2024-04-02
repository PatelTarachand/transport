<?php
error_reporting(0);
include("dbconnect.php");
$pagename = "purchase_report.php";
$modulename = "Purchase Report";

$tblname = "purchaseentry";
$tblpkey = "purchaseid";
if ($_GET['action'] != '') {
	$action = $_GET['action'];
} else {
	$action = '';
}

$purchase_date = date('Y-m-d');

$cond = '';

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
} else {
	$fromdate = '2022-07-01';
	$todate = date('Y-m-d');
}

if (isset($_GET['sup_id'])) {
	$sup_id  = trim(addslashes($_GET['sup_id']));
} else
	$sup_id = '';

if (isset($_GET['bill_type'])) {
	$bill_type  = trim(addslashes($_GET['bill_type']));
} else
	$bill_type = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {


	$crit .= " and  purchase_date   between '$fromdate' and '$todate'";
}

if ($sup_id != '') {
	$crit .= " and sup_id ='$sup_id'";
}
if ($bill_type != '') {
	$crit .= " and bill_type ='$bill_type'";
}
if ($_GET['purchaseid'] != "") {

	// echo "update purchase_entry  set is_complete=0  where is_complete=1 and purchaseid='$purchaseid";
	mysqli_query($connection, "update purchase_entry  set is_complete=0  where is_complete=1 and purchaseid='$purchaseid");
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
                                                <th> Supplier Name </th>
											
												<th> Bill No. </th>
                                            <th> Bill Type </th>
											<th> Qty </th>
                                        <th>Remark</th>
                                       <th> Net Total</th>
                                         
                                           
										</tr>
									</thead>
                                    <tbody>
									<?php
										$slno = 1;
										//echo "select * from purchaseentry where 1=1 $crit order by purchase_date desc";die;
										$sel = "select * from purchaseentry where 1=1 $crit group  by billno order by billno desc ";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
											$supplier_name = $cmn->getvalfield($connection, "suppliers", "sup_name", "sup_id='$row[sup_id]'");
											$total_amt = $cmn->getvalfield($connection, "purchasentry_detail", "sum(nettotal)", "purchaseid='$row[purchaseid]'");
											$qty = $cmn->getvalfield($connection, "purchasentry_detail", "qty", "purchaseid='$row[purchaseid]'");
											
										?>
											<tr>
												<td><?php echo $slno; ?></td>
												<td><?php echo dateformatindia($row['purchase_date']); ?></td>

												<td><?php echo $supplier_name; ?></td>
												<td><?php echo ucfirst($row['billno']); ?></td>
												
												<td><?php echo ucfirst($row['bill_type']); ?></td>
												<td><?php echo $qty; ?></td>
												<td><?php echo ucfirst($row['remark']); ?></td>
												<td><?php echo $total_amt; ?></td>

												
											</tr>
											
										<?php
											$totalamt += $total_amt;
											$totqty += $qty;

											$slno++;
										}
										?>
										<tfoot>
<tr><th></th><th></th><th></th><th></th><th>Total</th><th><?php echo $totqty; ?></th><th></th><th><?php echo $totalamt; ?></th></tr>

</tfoot>	
										
									</tbody>
									
								</table>


