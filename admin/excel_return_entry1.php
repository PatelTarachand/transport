<?php 
error_reporting(0);
include("dbconnect.php");

$tblname = "trip_entry";
$tblpkey = "trip_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_return_entry".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);
$tblname = "trip_entry";
$tblpkey = "trip_id";
$pagename  ='billty_record2.php';
$modulename = "Billty";
//print_r($_SESSION);
// $sale_date = date('Y-m-d');
$crit='';

	 $fromdate = $_GET['fromdate'];
 	$todate = $_GET['todate'];
	


if (isset($_GET['consignorid'])) {
	$consignorid = trim(addslashes($_GET['consignorid']));
} else
	$consignorid = '';
	

if (isset($_GET['truckid'])) {
	$truckid = trim(addslashes($_GET['truckid']));
} else
	$truckid = '';


if ($fromdate != '' && $todate != '') {
	$crit .= "where loding_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if ($truckid != '') {
	$crit .= " and truckid='$truckid'";
}
if ($consignorid != '') {
	$crit .= " and consignorid='$consignorid'";
}
?>
<<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
   <title>
	</title>
	<style type="text/css">
		table, th, td {
  border: 1px solid;
}	
	</style>
</head>
<body>
<table>
									<thead>
										<tr>
                              <th>S.No</th>
								<th>Trip No.</th>
								<th>Truck No.</th>
								<th class='hidden-350'>Loading Date</th>
								<th>Consignor</th>
								<th>Consignee</th>
								<!-- <th class='hidden-1024'>Truck No.</th> -->
								<th>Destination</th>
								<!-- <th>Item</th> -->
								<th>Weight/MT</th>
								<!-- <th>Qty (Bags)</th> -->
								<th> Expenses(Consignor) </th>
								<th> Expenses(Consignee) </th>
								<th> Expenses(Self) </th>
								<th>Petrol Pump</th>
								<th>Total Amount</th>
								<th>Total Expenses</th>
								<th>Total Amount</th>
                                               
                                                
										</tr>
									</thead>
									<tbody>
                           <?php
							$sn = 1;
							//   echo "Select * from  $tblname where compid='$compid' and  sessionid='$sessionid'  order by $tblpkey desc limit 10";
							// $sql = mysqli_query($connection, "Select * from  $tblname where compid='$compid' and  sessionid='$sessionid'  order by $tblpkey desc limit 10");
                     $sql = mysqli_query($connection, "Select * from  $tblname $crit and compid='$compid' and  sessionid='$sessionid' order by $tblpkey desc");

                     // $sql = mysqli_query($connection,"Select * from  $tblname where compid='$compid' and  sessionid='$sessionid'  order by $tblpkey");

							while ($row = mysqli_fetch_array($sql)) {
								$consignor_name = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid=$row[consignorid]");
								$consignee_name = $cmn->getvalfield($connection, "m_consignee", "consigneename", "consigneeid=$row[consigneeid]");
								$truckno = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid=$row[truckid]");
								$destination = $cmn->getvalfield($connection, "m_place", "placename", "placeid=$row[toplaceid]");
								$cash_adv = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no=$row[trip_no] and inc_ex_id='10'");
								$diesel_advance = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no=$row[trip_no] and inc_ex_id='1'");
								$consignor_exp = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", " category='Consignor' && trip_no='$row[trip_no]'  && truckid='$row[truckid]'");
								$consignee_exp = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", " category='Consignee' && trip_no='$row[trip_no]'  && truckid='$row[truckid]'");
								$self_exp = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", " category='Self' && trip_no='$row[trip_no]'  && truckid='$row[truckid]'");


								// 										   
							?>
								<tr>
									<td><?php echo $sn++; ?></td>
									<td><?php echo $row['trip_no']; ?></td>
									<td class='hidden-1024'><?php echo $truckno; ?></td>
									<td><?php echo dateformatindia($row['loding_date']); ?></td>
									<td><?php echo $consignor_name; ?></td>
									<td class='hidden-350'><?php echo $consignee_name; ?></td>
									<td class='hidden-1024'><?php echo $destination; ?></td>
									<!-- <td class='hidden-1024'><?php echo $itemname; ?></td> -->
									<td><?php echo $row['qty_mt_day_trip']; ?></td>
									<!-- <td><?php echo $row['qty']; ?></td> -->
									<td><?php echo $consignor_exp; ?></td>
									<td><?php echo $consignee_exp; ?></td>
									<td><?php echo $self_exp; ?></td>
									<td><?php echo $row['petrol_pump']; ?></td>
                           <td><?php echo $row['frieght_amt']; ?></td>

									<td><?php echo $row['trip_expenses']; ?></td>
									<td><?php echo $row['net_amount']; ?></td>
									<!-- <td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td> -->
								
								</tr>
							<?php } ?>
							
									</tbody>
								</table>
</body>
</html>
