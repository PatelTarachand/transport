<?php
error_reporting(0);
include("dbconnect.php");
$pagename = "excel_purchase_payment_report.php";
$modulename = "Purchase Payment Report";
$tblname = "payment";
$tblpkey = "payment_id";
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
	$fromdate = date('Y-m-d');
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


	$crit .= " and  paymentdate   between '$fromdate' and '$todate'";
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
$filename = "purchase_report.xls";
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=" . $filename);



?>
<table border="1">
    <thead>
        <tr>
        <th>S.No</th>
                                                                            <th>Supplier Name</th>

                                                                            <th>Payment Date</th>
                                                                            <th>Paid Amount</th>
                                                                            <th>Disc Amt</th>
                                                                            <!-- <th>Print</th> -->

                                                                            <th>Remark</th>


        </tr>
    </thead>
    <tbody>
    <?php
                            $sn = 1;
                            $netamount = 0;
                            //  echo "select A.* from payment as A left join m_supplier_party as B on A.suppartyid=B.suppartyid where A.paymentdate between '$fromdate' and '$todate' and A.type='purchase' $crit and  A.createdby='$loginid' order by paymentid";
                            $sql = mysqli_query($connection, "select * from payment where type='purchase' and  iscomp=1 $crit ");
                            while ($row = mysqli_fetch_assoc($sql)) {

                            ?>
                                <tr class="abc" tabindex="<?php echo $sn; ?>">
                                    <td><?php echo $sn++; ?></td>
                                    <td> <?php echo $cmn->getvalfield($connection,"suppliers","sup_name","sup_id='$row[sup_id]'"); ?> </td>
                                    <td><?php echo $cmn->dateformatindia($row['paymentdate']); ?></td>
                                    <td style="text-align:left;"><?php echo number_format($row['paid_amt'], 2); ?></td>
                                    <td style="text-align:left;"><?php echo number_format($row['discamt'],2); ?></td>
                                    <td><?php echo $row['narration']; ?></td>
								<!-- <td>

								<input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="editselected('<?php echo $row['paymentid']; ?>','<?php echo $cmn->dateformatindia($row['paymentdate']); ?>','<?php echo $row['sup_id']; ?>','<?php echo $row['paid_amt']; ?>','<?php echo $row['narration']; ?>','<?php echo $row['discamt']; ?>','<?php echo $row['pay_type']; ?>');" value="E"> &nbsp;
								<input type="button" class="btn btn-danger" name="add_data_list" id="add_data_list" onClick="funDel1('<?php echo $row['paymentid']; ?>');" value="X">

								</td>	 -->


                                </tr>
											
										<?php
										     $netamount += $row['paid_amt'];
										     $discamt1 += $row['discamt'];
	$totqty += $qty;
											$slno++;
										}
										?>
										
	<tfoot>
<tr><th></th><th></th><th>Total</th><th><?php echo $netamount; ?></th><th><?php echo number_format($discamt1,2); ?></th><th></th></tr>

</tfoot>
									</tbody>

</table>