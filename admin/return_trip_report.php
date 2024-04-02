<?php
error_reporting(0);
include("dbconnect.php");
$pagename = "return_trip_report.php";
$modulename = "Return Trip Report";
$tblname = "trip_entry";
$tblpkey = "trip_id";
$pagename = "return_trip_report.php";
$modulename = "Trip Report";
$crit = '';
if (isset($_GET['search'])) {
	$fromdate = $_GET['fromdate'];
	$todate = $_GET['todate'];
} else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

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
<!doctype html>
<html>

<head>

	<?php include("../include/top_files.php"); ?>
	<?php include("alerts/alert_js.php"); ?>


</head>

<body onLoad="hideval();">
	<?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">

		<div id="main">
			<div class="container-fluid">
				<!--  Basics Forms -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
								<?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i>Return Trip Report</h3>
								<?php include("../include/page_header.php"); ?>
							</div>

							<form method="get" action="" class='form-horizontal' enctype="multipart/form-data">
								<a href="return_trip_entry.php" class="btn btn-primary" style="float:right;">ADD NEW</a>
								<div class="control-group">
									<table class="table table-condensed">
										<tr>
											<td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
										</tr>

										<tr>
											<th style="text-align:left;">From Date</th>
											<th style="text-align:left;"> To Date</th>
											<th> <strong>Truck No </strong></th>
											<th> <strong>Consignor </strong></th>
											<th> <strong>Action </strong></th>



										</tr>
										<tr>

											<td> <input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
											</td>
											<td> <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
											</td>
											<td>
												<select name="truckid" id="truckid" class='select2-me' style="width: 220px;">
													<option value=""> Select </option>
													<?php
													$sql = mysqli_query($connection, "Select truckid,truckno from  m_truck  LEFT JOIN m_truckowner ON m_truck.ownerid = m_truckowner.ownerid where owner_type='Self'");
													while ($row = mysqli_fetch_array($sql)) {



													?>
														<option value="<?php echo $row['truckid']; ?>"><?php echo $row['truckno']; ?></option>
													<?php }
													?>
												</select>
												<script>
													document.getElementById('truckid').value = '<?php echo $truckid; ?>';
												</script>


											</td>

											<td>
												<select name="consignorid" id="consignorid" class='select2-me' style="width:220px;">
													<option value=""> Select </option>
													<?php $sql = mysqli_query($connection, "Select * from  m_consignor ");
													while ($row = mysqli_fetch_array($sql)) { ?>
														<option value="<?php echo $row['consignorid']; ?>"><?php echo $row['consignorname']; ?></option>
													<?php } ?>
												</select>
												<script>
													document.getElementById('consignorid').value = '<?php echo $consignorid; ?>';
												</script>

											</td>

											<center>
												<td>

													<input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search" onClick="return checkinputmaster('fromdate,todate');" style="width:80px;">
													<a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
												</td>
											</center>

										</tr>



									</table>
								</div>
							</form>

						</div>
					</div>
				</div>
				<!--   DTata tables -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i>Return Trip Details</h3>
							</div>
							<a class="btn btn-primary btn-lg" href="excel_return_entry1.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&consignorid=<?php echo $consignorid; ?>&truckid=<?php echo $truckid; ?>" target="_blank" style="float:right;"> Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
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
											<th class='hidden-480'>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sn = 1;
										//   echo "Select * from  $tblname where compid='$compid' and  sessionid='$sessionid'  order by $tblpkey desc limit 10";
										$sql = mysqli_query($connection, "Select * from  $tblname $crit and compid='$compid' and  sessionid='$sessionid' order by $tblpkey desc");
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
												<td class='hidden-480'>
													<!-- 	<a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4"target="_blank" >
                                                            <i class="fa fa-print">A4</i>
                                                            <a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
                                                            <i class="fa fa-print">A5</i>
                                                            </a> -->
													<a href="?editid=<?php echo $row['trip_id']; ?>">
														<img src="../img/b_edit.png" title="Edit">
													</a>&nbsp;&nbsp;&nbsp;
													<a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['trip_id']; ?>)">
														<img src="../img/del.png" title="Delete"></a>
													</a>
												</td>
											</tr>
										<?php } ?>

									<tfoot>

									</tfoot>
									</tbody>

								</table>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
	<script>
		function funDel(id) {
			//alert(id);   
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			//alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: '../ajax/delete.php',
					data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
						// alert(data);
						// alert('Data Deleted Successfully');
						location = pagename + '?action=10';
					}

				}); //ajax close
			} //confirm close
		} //fun close
	</script>
</body>
<?php
/*<script>
    // autocomplet : this function will be executed every time we change the text
    function autocomplet() {
    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $('#country_id').val();
    if (keyword.length >= min_length) {
    $.ajax({
    url: '\autocomplete/ajax_refresh.php',
    type: 'POST',
    data: {keyword:keyword},
    success:function(data){
    $('#country_list_id').show();
    $('#country_list_id').html(data);
    }
    });
    } else {
    $('#country_list_id').hide();
    }
    }
     
    // set_item : this function will be executed when we select an item
    function set_item(item) {
    // change input value
    $('#country_id').val(item);
    // hide proposition list
    $('#country_list_id').hide();
    }
</script>*/

?>

</html>
<?php
mysqli_close($connection);
?>