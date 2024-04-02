<?php
include("dbconnect.php");
$tblname = 'returnbidding_entry';
$tblpkey = "bid_id";
$pagename = "bilty_receive_emami.php";
$modulename = "Return Bilty Receiving";

if (isset($_REQUEST['action']))
	$action = $_REQUEST['action'];
else
	$action = 0;

$cond = ' ';

if (isset($_GET['end_date'])) {
	$end_date = $cmn->dateformatusa(trim(addslashes($_GET['end_date'])));
} else
	$end_date = date('Y-m-d');

if (isset($_GET['start_date'])) {
	$start_date = $cmn->dateformatusa(trim(addslashes($_GET['start_date'])));
} else
	$start_date = date('Y-m-d', strtotime('-1 month', strtotime($end_date)));


if (isset($_GET['bilty_no'])) {
	$bilty_no = trim(addslashes($_GET['bilty_no']));
} else
	$bilty_no = '';

if (isset($_GET['di_no'])) {
	$di_no = trim(addslashes($_GET['di_no']));
} else
	$di_no = '';

if ($bilty_no != '') {

	$cond .= " and bilty_no='$bilty_no'";
}

if ($di_no != '') {

	$cond .= " and di_no='$di_no'";
}

if ($start_date != '' && $end_date != '') {
	$cond .= " and tokendate between '$start_date' and '$end_date' ";
}



?>
<!doctype html>
<html>

<head>

	<?php include("../include/top_files.php"); ?>
	<?php include("alerts/alert_js.php"); ?>

	<script>
		$(function() {

			$('#start_date').datepicker({
				dateFormat: 'dd-mm-yy'
			}).val();
			$('#end_date').datepicker({
				dateFormat: 'dd-mm-yy'
			}).val();
			$('.recdate').datepicker({
				dateFormat: 'dd-mm-yy'
			}).val();


		});
	</script>

</head>

<body onLoad="hideval();">
	<?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		<br>
	
		<div id="main">
			<div class="container-fluid">
				<!--  Basics Forms -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title" style="margin-top:0px;">
								<!-- <legend class="legend_blue"><a href="dashboard.php">
										<img src="menu/home.png" style="width:30px;" /><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->
								<?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
									<span style="float:right;padding-right: 24px;">
			<a href="builty_receive_return.php" class="btn btn-primary">Show List</a>

			</p>
		</span>
								<?php include("../include/page_header.php"); ?>
							</div>

							<form method="get" action="" class='form-horizontal'>
								<div class="control-group">
									<table class="table table-condensed">
										<tr>
											<td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
										</tr>

										<tr>
											<td style="width: 12%;"><strong>From Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
											<td style="width: 12%;"><input type="text" name="start_date" id="start_date" value="<?php echo $cmn->dateformatindia($start_date); ?>" autocomplete="off" tabindex="2" class="input-medium" required></td>
											<td style="width: 12%;"><strong>To Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
											<td style="width: 12%;"><input type="text" name="end_date" id="end_date" value="<?php echo  $cmn->dateformatindia($end_date); ?>" autocomplete="off" tabindex="5" class="input-medium"></td>
											<td style="width: 6%;"><strong>Bilty No.</strong> <strong>:</strong><span class="red">*</span></td>
											<td style="width: 12%;"><input type="text" name="bilty_no" id="bilty_no" value="<?php echo $bilty_no; ?>" maxlength="10" autocomplete="off" tabindex="5" class="input-medium"></td>
											<td style="margin-top: 0px;">

												<input type="submit" name="submit" id="submit" value="Search" class="btn btn-success" tabindex="10">
												<?php if (isset($_GET['edit']) && $_GET['edit'] !== "") { ?>
													<input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename; ?>';" />
												<?php
												} else {
												?> <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px;border-radius:4px !important;" onClick="document.location.href='<?php echo $pagename; ?>';">
												<?php
												}
												?>
											</td>

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
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding" style="overflow:scroll">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
											<th width="2%">Sn</th>
											<th width="6%">LR No.</th>
											<th width="6%">Bilty No.</th>
	                                    <th width="5%">Consignor Name</th>

											<th width="5%">Bilty Date</th>
											<th width="6%">Truck No.</th>
											<th width="6%">Truck Owner Name</th>
											<th width="6%">Disp. Wt</th>
											<th width="6%">Rec. Wt.</th>
											<th width="6%">Disp. Bags</th>
											<th width="7%">Rec. Bags</th>
											<th width="10%">Unloading Place</th>

											<th width="8%">Recd. Dt.</th>
											<th width="7%">Short.(MT)</th>
											<th width="7%">Short.(Bags)</th>
											<th width="11%">Type</th>
											<th width="7%" class='hidden-480'>Action</th>

										</tr>
									</thead>
									<tbody>
										<?php
										$sn = 1;
									// echo "select * from returnbidding_entry where 1=1 && is_bilty=1 $cond  && compid='$compid' && sessionid=$sessionid and recdate='0000-00-00' order by bid_id";
										$sql = mysqli_query($connection, "select * from returnbidding_entry where 1=1 && is_bilty=1 $cond  && compid='$compid' && sessionid=$sessionid and recdate='0000-00-00' order by bid_id");
										while ($row = mysqli_fetch_assoc($sql)) {

											$s = $row['tokendate'];
											$dt = new DateTime($s);
											$date = $dt->format('d-m-Y');
											$placeid = $row['destinationid'];
											$bid_id = $row['bid_id'];
											$recweight = $row['recweight'];
											$ewayno = $row['ewayno'];

											if ($recweight == 0) {
												$recweight = $row['totalweight'];
											}

											$destaddress = $row['destaddress'];
											$recdate = $cmn->dateformatindia($row['recdate']);
											$sortagr = $row['sortagr'];
											$truckid = $row['truckid'];
											$ownerid = $cmn->getvalfield($connection, "m_truck", "ownerid", "truckid='$truckid'");
											$ownername = $cmn->getvalfield($connection, "m_truckowner", "ownername", "ownerid='$ownerid'");
											$noofqty = $row['noofqty'];
											$shortagetype = $row['shortagetype'];
											$placename = $cmn->getvalfield($connection, "m_place", "placename", "placeid='$placeid'");
											$truckno = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$truckid'");
												$consignorname = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid='$row[consignorid]'");
											$recbag = $row['recbag'];

											if ($recbag == 0) {
												$recbag = $row['noofqty'];
											}

											if ($recdate != '') {
												$sortagbag = $noofqty - $row['recbag'];
											} else
												$sortagbag = '';



										?>

											<tr tabindex="<?php echo $sn; ?>" class="abc">
												<td><?php echo $sn++; ?></td>
												<td><?php echo $row['lr_no']; ?>
												<td><?php echo $row['bilty_no']; ?>
													<td><?php echo $consignorname; ?>
													<span style="color:#FFFFFF;"><?php echo $ewayno; ?></span>
												</td>

												<td><?php echo $date; ?> <span id="totalweight<?php echo $bid_id; ?>" style="display:none;"> <?php echo $row['totalweight']; ?></span></td>
												<td><?php echo $truckno; ?></td>
												<td><?php echo $ownername; ?></td>
												<td>
													<span id="rec1" style="color:red;">*</span>
													<input type="text" class="input-small" value="<?php echo $recweight; ?>" style="border: 1px solid #368ee0;width:50px;" autocomplete="off" readonly>
												</td>
												<td>
													<span id="rec1" style="color:red;">*</span>
													<input type="text" class="input-small" value="<?php echo $recweight; ?>" id="recweight<?php echo $bid_id; ?>" style="border: 1px solid #368ee0;width:47px;" autocomplete="off" onChange="getshortage(<?php echo $bid_id; ?>);">
												</td>


												<td><span id="totalbag<?php echo $bid_id; ?>"><?php echo $row['noofqty']; ?></span></td>

												<td>
													<span style="color:red;">*</span>
													<input type="text" class="input-small" value="<?php echo $recbag; ?>" id="recbag<?php echo $bid_id; ?>" style="border: 1px solid #368ee0;width:50px;" autocomplete="off" onChange="getshortage(<?php echo $bid_id; ?>);">
												</td>


												<td> <?php echo $placename; ?> </td>


												<td style="display: flex;align-items: center;">
													<span id="recvdate1" style="color:red;">*</span>
													<input type="text" class="formcent recdate" value="<?php echo $recdate; ?>" id="recdate<?php echo $bid_id; ?>" style="border: 1px solid #368ee0;width:57px;" autocomplete="off">
												</td>
												<td>
													<input type="text" value="<?php echo $sortagr; ?>" id="sortagr<?php echo $bid_id; ?>" style="border: 1px solid #368ee0;background-color:#6CF;width:60px;" autocomplete="off" readonly>
												</td>

												<td>
													<input type="text" value="<?php echo $sortagbag; ?>" id="sortagbag<?php echo $bid_id; ?>" style="border: 1px solid #368ee0;background-color:#6CF;width:60px;" autocomplete="off" readonly>
												</td>
												<td>
													<select name="shortagetype" id="shortagetype<?php echo $bid_id; ?>" style="width:100px;">
														<option value="">No Shortage</option>
														<option value="Shortage">Shortage</option>
														<option value="Damage">Damage</option>
													</select>
													<script>
														document.getElementById('shortagetype<?php echo $bid_id; ?>').value = '<?php echo $shortagetype; ?>';
													</script>
												</td>

												<td>
													<input type="button" class="btn btn-sm btn-success" value="Save" onClick="getsave(<?php echo $bid_id; ?>);">
													<span style="color:#F00;" id="msg<?php echo $bid_id; ?>">
														<?php
														$paydone = $row['is_complete'];
														if ($usertype == 'admin') {
															$payUser = 1;
														} else {
															$payUser = 0;
														}
														if ($paydone != 0) {
															if ($usertype == 'admin') {  ?>
																<input type="button" class="btn btn-sm btn-success" value="Save" onClick="getsave(<?php echo $bid_id; ?>);">
																<span style="color:#F00;" id="msg<?php echo $bid_id; ?>"></span>
															<?php } else {
																echo "Payment Done.";
															}
														} else { ?>
															<!--<input type="button" class="btn btn-sm btn-success" value="Save" onClick="getsave(<?php echo $bid_id; ?>);"  >-->
															<!--             <span style="color:#F00;" id="msg<?php echo $bid_id; ?>"></span> -->
														<?php } ?>
												</td>
											</tr>
										<?php
										}

										?>

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

		function hideval() {
			var paymode = document.getElementById('paymode').value;
			if (paymode == 'cash') {
				document.getElementById('checquenumber').disabled = true;
				document.getElementById('session_name').disabled = true;
				document.getElementById('checquenumber').value = "";
				document.getElementById('session_name').value = "";
			} else {
				document.getElementById('checquenumber').disabled = false;
				document.getElementById('session_name').disabled = false;
			}
		}

		function getshortage(bid_id) {
			var totalweight = parseFloat(document.getElementById('totalweight' + bid_id).innerHTML);
			var recweight = parseFloat(document.getElementById('recweight' + bid_id).value);
			var recbag = parseFloat(document.getElementById('recbag' + bid_id).value);
			var totalbag = parseFloat(document.getElementById('totalbag' + bid_id).innerHTML);

			if (isNaN(totalweight)) {
				totalweight = 0;
			}
			if (isNaN(recweight)) {
				recweight = 0;
			}
			if (isNaN(recbag)) {
				recbag = 0;
			}
			if (isNaN(totalbag)) {
				totalbag = 0;
			}

			var shortage = totalweight - recweight;
			var shortagebag = totalbag - recbag;

			document.getElementById('sortagr' + bid_id).value = shortage.toFixed(2);
			document.getElementById('sortagbag' + bid_id).value = shortagebag;

		}

		function getsave(bid_id) {
			var recweight = document.getElementById('recweight' + bid_id).value;
			var totalweight = parseFloat(document.getElementById('totalweight' + bid_id).innerHTML);

			//var destaddress = document.getElementById('destaddress'+bid_id).value;
			var recdate = document.getElementById('recdate' + bid_id).value;
			var sortagr = document.getElementById('sortagr' + bid_id).value;
			var recbag = document.getElementById('recbag' + bid_id).value;
			var sortagbag = document.getElementById('sortagbag' + bid_id).value;
				var shortagetype = document.getElementById('shortagetype' + bid_id).value;
			document.getElementById("msg" + bid_id).innerHTML = '';

			if (recweight != totalweight && shortagetype == '') {
				alert("Please Select Shortage Type..!!!");
				return false;
			}
			if (recweight == '' || recweight == '0') {
				alert("Please Enter Receive weight");
				document.getElementById('recweight' + bid_id).value = '';
				document.getElementById('recweight' + bid_id).focus();
				return false;
			}
			if (recdate == '') {
				alert("Please Enter Receive Date");
				document.getElementById('recdate' + bid_id).value = '';
				document.getElementById('recdate' + bid_id).focus();
				return false;
			}

	if (sortagbag!= 0 && shortagetype=='') {
				alert("Please Select Shortagetype");
			
				return false;
			}

			$.ajax({
				type: 'POST',
				url: 'return_updaterecieving.php',
				data: 'bid_id=' + bid_id + '&recweight=' + recweight + '&recdate=' + recdate + '&sortagr=' + sortagr + '&recbag=' + recbag + '&shortagetype=' + shortagetype+ '&sortagbag=' + sortagbag,
				dataType: 'html',
				success: function(data) {
				// 	alert(data);
					// alert('Data Deleted Successfully');
					if (data == 1) {
						document.getElementById('msg' + bid_id).innerHTML = 'Updated';

					}
				}

			}); //ajax close

		}
	</script>
	<script>
		function checkval() {
			var recweight = document.getElementById('recweight').value.trim();
			var destaddress = document.getElementById('destaddress').value.trim();
			var recdate = document.getElementById('recdate').value.trim();

			if (recweight == '') {
				//alert("Please Enter Full Name");
				document.getElementById('rec1').innerHTML;
				document.getElementById("recweight").focus();
				return false;
			}

			if (destaddress == '') {
				//alert("Please Enter Full Name");
				document.getElementById('rec1').innerHTML;
				document.getElementById("des1").focus();
				return false;
			}

			if (recdate == '') {
				//alert("Please Enter Full Name");
				document.getElementById('rec1').innerHTML;
				document.getElementById("recdate1").focus();
				return false;
			}
			return true;
		}
	</script>

</body>


</html>
<?php
mysqli_close($connection);
?>