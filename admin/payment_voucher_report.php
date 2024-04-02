<?php
error_reporting(0);
include("dbconnect.php");
$tblname = 'voucher_entry';
$tblpkey = 'bulk_vid';
$pagename  = 'payment_voucher_report.php';
$modulename = "Payment Voucher ";
$crit = "";
if ($_GET['billing_type'] != '') {
	$billing_type = $_GET['billing_type'];
}

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = $_GET['fromdate'];

	$todate = $_GET['todate'];
	$billing_type = trim(addslashes($_GET['billing_type']));
	if ($billing_type == 'Consignor') {
		$consignorid = trim(addslashes($_GET['partyid']));
	} else {
		$consigneeid = trim(addslashes($_GET['partyid']));
	}
} else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if (isset($_GET['billing_type'])) {
	$billing_type = trim(addslashes($_GET['billing_type']));
} else
	$billing_type = '';


if (isset($_GET['tp_id'])) {
	$tp_id = trim(addslashes($_GET['tp_id']));
} else
	$tp_id = '';
if ($fromdate != '' && $todate != '') {
	$crit .= "pay_date BETWEEN  '$fromdate' and  '$todate' ";
}

if ($billing_type != '') {
	$crit .= " and billing_type='$billing_type'";
	//echo $crit;
}
if ($consignorid != '') {
	$crit .= "and consignorid='$consignorid'";
}
if ($tp_id != '') {
	$crit .= "and tp_id='$tp_id'  ";
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
											<th style="text-align:left;">To Date</th>
											<th> <strong>Action </strong></th>



										</tr>
										<tr>

											<td><input type="date" name="fromdate" id="fromdate" value="<?php echo $fromdate; ?>" autocomplete="off" tabindex="1" class="form-control" required onChange="getSearch();"></td>

											<td><input type="date" name="todate" id="todate" value="<?php echo $todate; ?>" autocomplete="off" tabindex="2" class="form-control" required onChange="getSearch();"></td>

											<td style="display:none;">
												<div class="col-sm-12">
													<select id="billing_type" name="billing_type" onChange="getSearch();" tabindex="3" class='form-control'>
														<option value="">Select</option>
														<option value="Consignor">Consignor</option>
														<option value="Consignee">Consignee</option>


														<script>
															document.getElementById('billing_type').value = '<?php echo $billing_type; ?>';
														</script>
													</select>
											</td>
											<td style="display:none;">
												<div class="col-sm-8">
													<div class="form-group">


														<!-- <label for="">Party</label> -->
														<select name="partyid" id="partyid" class="form-control form-control-sm" onChange="getSearch();">
															<option value="">-Select-</option>
															<?php
															$sql = mysqli_query($connection, "select * from supplier_master where party_type='$_GET[billing_type]'");
															while ($row = mysqli_fetch_array($sql)) {
															?>
																<option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['party_name']; ?></option>

															<?php } ?>
															<script>
																document.getElementById('partyid').value = '<?php echo $partyid; ?>';
															</script>
														</select>
													</div>
												</div>

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
							<a class="btn btn-primary btn-lg" href="excel_payment_voucher_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&consignorid=<?php echo $consignorid; ?>&truckid=<?php echo $truckid; ?>" target="_blank" style="float:right;"> Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>

											<th>Voucher No </th>
											<th>Paid to </th>

											<th>Payment Date </th>
											<th>Remark </th>

											<th>Net Amount</th>
											<th>Action</th>

										</tr>
									</thead>
									<tbody>

										<?php $sn = 1;

										//echo"select * from payment_recive where $crit order by payment_recive_id desc";
										$sql = mysqli_query($connection, "select * from voucher_entry where $crit order by bulk_vid desc");
										while ($row = mysqli_fetch_array($sql)) {


											$loding_date = $cmn->getvalfield($connection, "trip_entry", "loding_date", "trip_id='$row[trip_id]'");
											$final_total = $cmn->getvalfield($connection, "payment_recive", "sum(final_total)", "bulk_vid='$row[bulk_vid]'");
										?>
											<tr>
												<td><?php echo $sn++; ?></td>

												<td><?php echo $row['voucher_no']; ?></td>
												<td><?php echo $row['paid_to']; ?></td>
												<td><?php echo dateformatindia($row['pay_date']); ?></td>
												<td><?php echo $row['remark']; ?></td>
												<td><?php echo $final_total; ?></td>
												<td>
													<a href='payment_recive.php?editid=<?php echo $row['bulk_vid']; ?>' class="btn btn-magenta">Edit</a>
													<a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['bulk_vid']; ?>)" class="btn btn-satblue">Delete</a>
													<a href="pdf_voucher.php?bulk_vid=<?php echo $row['bulk_vid'] ?>" class="btn btn-primary" target="_blank">
														<span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a>
												</td>


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

			var tablename = 'voucher_entry';
			var tableid = 'bulk_vid';

			if (confirm("Do You want to Delete this record ?")) {
				jQuery.ajax({
					type: 'POST',
					url: '../ajax/delet_voucher.php',
					data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
					dataType: 'html',
					success: function(data) {

						showrecord(<?php echo $_GET['editid']; ?>);
						savedata();
					}
				}); //ajax close
			}
		}
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