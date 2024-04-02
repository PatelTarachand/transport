<?php
date_default_timezone_set("Asia/Kolkata");
include("dbconnect.php");
//print_r($_SESSION);
$tblname = "bidding_entry";
$tblpkey = "bid_id";
$pagename = "bulk_bilty_payment_emami_report.php";
$modulename = " Profit And Loss  Report";
include("../lib/smsinfo.php");
if (isset($_GET['month'])) {
	$month = trim(addslashes($_GET['month']));
} else {
	$month = date('m');
}


if (isset($_GET['year'])) {
	$year = trim(addslashes($_GET['year']));
} else
	$year = '2024';

if ($month != '') {
	$fromdate = date("$year-$month-01");
	$todate = date("Y-m-t", strtotime($fromdate));
}

if ($fromdate != '' && $todate != '') {
	$crit .= "tokendate BETWEEN  '$fromdate' and  '$todate' ";
	$crit1 .= "service_date BETWEEN  '$fromdate' and  '$todate' ";
	$crit2 .= "maint_date BETWEEN  '$fromdate' and  '$todate' ";
	$crit3 .= "pay_date BETWEEN  '$fromdate' and  '$todate' ";
	$crit4 .= "billdate BETWEEN  '$fromdate' and  '$todate' ";
	$crit6 .= "payment_date BETWEEN  '$fromdate' and  '$todate' ";
	//echo $crit;
}

if (isset($_GET['truckid'])) {
	$truckid = trim(addslashes($_GET['truckid']));
} else {
	$truckid = '';
}


if ($truckid != '') {

	$crit .= "and truckid='$truckid'  ";
	$crit1 .= "and truckid='$truckid'  ";
	$crit2 .= "and truckid='$truckid'  ";
	$crit3 .= "and truckid='$truckid'  ";
	$crit5 .= "and truckid='$truckid'  ";
	$crit6 .= "and truckid='$truckid'  ";
}
?>
<!doctype html>
<html>

<head>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

	<?php include("../include/top_files.php"); ?>
	<style>
		p {
			padding-left: none;
			padding-right: none;
			padding-top: none;
			padding-bottom: none;
			font-size: 1em;
			font-family: serif;
			color: red;
			font-weight: bold;
			/*			text-align: center;*/
			animation: animate 1.5s linear infinite;
		}

		@keyframes animate {
			0% {
				opacity: 0;
			}

			50% {
				opacity: 0.7;
			}

			60% {
				opacity: 0;
			}
		}

		.fixTableHead {
			overflow-y: auto;
			height: 110px;
		}

		.fixTableHead thead th {
			position: sticky;
			top: 0;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		th,
		td {
			padding: 8px 15px;
			border: 2px solid #529432;
		}

		th {
			background: #ABDD93;
		}
	</style>
</head>


<body>


	<?php include("../include/top_menu.php"); ?>


	<div class="container-fluid" id="content">

		<div id="main">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							<div class="box-content nopadding">
								<form method="get" action="">
									<fieldset style="margin-top:45px; margin-left:45px;">
										<!-- <legend class="legend_blue"><a href="dashboard.php">
												<img src="menu/home.png" style="width:30px;" /><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->
										<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?> </legend>
										<table width="1037">
											<tr>
												<td style="text-align:center;"><strong>Month</strong><span style="color: red;">*</span></td>
												<td style="text-align:center;"><strong>Year</strong><span style="color: red;">*</span></td>

												<td><strong>Truck No: </strong></td>
												<td><strong>Action </strong></td>



											</tr>

											<tr>
												<td>
													<!-- <input type="date" name="fromdate" id="fromdate" value="<?php echo $fromdate; ?>" autocomplete="off" tabindex="1" class="form-control" required> -->
													<select name="month" id="month" class="form-control">
														<option value="01">January</option>
														<option value="02">February</option>
														<option value="03">March</option>
														<option value="04">April</option>
														<option value="05">May</option>
														<option value="06">June</option>
														<option value="07">July</option>
														<option value="08">August</option>
														<option value="09">September</option>
														<option value="10">October</option>
														<option value="11">November</option>
														<option value="12">December</option>
													</select>
													<script>
														document.getElementById('month').value = "<?php echo $month; ?>";
													</script>

												</td>

												<td>
													<!-- <input type="date" name="todate" id="todate" value="<?php echo $todate; ?>" autocomplete="off" tabindex="2" class="form-control" required> -->
													<select name="year" id="year" class="form-control">
														<?php
														for ($i = 2022; $i < 2028; $i++) {
														?>
															<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php } ?>
													</select>
													<script>
														document.getElementById('year').value = "<?php echo $year; ?>";
													</script>



												</td>


												<td>
													<div class="col-sm-8">
														<!-- <select id="truckid" name="truckid" class="select2-me input-large" style="width:220px;" onChange="getOwner(this.value);" required > -->
														<select data-placeholder="Choose a Country..." name="truckid" id="truckid" style="width:250px" tabindex="3" class="formcent select2-me">

															<option value=""> - Select - </option>
															<?php
															$sql_fdest = mysqli_query($connection, "select truckid,truckno from m_truck");
															while ($row_fdest = mysqli_fetch_array($sql_fdest)) {
															?>
																<option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
															<?php
															} ?>
														</select>
														<script>
															document.getElementById('truckid').value = '<?php echo $truckid; ?>';
														</script>
												</td>


												<td>

													<input type="submit" name="submit" id="submit" value="search" class="btn btn-success" tabindex="4">
													<a href="truck_p_l_report.php" class="btn btn-danger"> Reset</a>
												</td>

											</tr>


										</table>
									</fieldset>
								</form>
							</div>
						</div>
					</div> <!--rowends here -->
				</div> <!--com sm 12 ends here -->

				<!--rowends here -->

			</div><!--class="container-fluid"  ends here -->
		</div>
			<div class="container-fluid">
		<div class="row-fluid">
          <div class="span12">
            <div class="box box-bordered">
              <div class="box-title">
                <h3><i class="icon-table"></i>Opening Balance : <?php echo $prevbalance;?></h3>
              <a class="btn btn-primary btn-lg" href="pdf_p_l_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" target="_blank"
                                style="float:right;" >  Print </a>
              </div>
		<div class="container-fluid">

			<?php $enddateexpalert = date('Y-m-d', strtotime('+1 months')); ?>
			<div class="row">
				<div class="col-sm-6">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Trip Expense
								</h3>
							</div>
							
						<div class="box-content" style="height:300px; overflow:scroll;padding:0">

							<table class="fixTableHead table table-hovertable-nomargin dataTable dataTable-tools table-bordered" style="width:100%;white-space: nowrap">
								<thead>
									<th>S.no.</th>
									<th>LR No.</th>
									<th>Bulty No.</th>
									<th> Date </th>
									<th>Type</th>
									<th>Freight Amount</th>
									<th>Truck Expenses.</th>
									<th> Net Amount </th>



								</thead>
								<tbody>
									<?php
									$slno = 1;
									// echo "	SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type FROM bidding_entry WHERE $crit 
									// UNION SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type FROM returnbidding_entry WHERE $crit";
									$sel = "SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type,comp_rate,totalweight FROM bidding_entry WHERE $crit 
			UNION SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type,comp_rate,totalweight FROM returnbidding_entry WHERE $crit";
									// 			"	SELECT lr_no,bilty_no,inv_date,freightamt,adv_cash,adv_consignor FROM bidding_entry WHERE $crit 
									// UNION SELECT lr_no,bilty_no,inv_date,freightamt,adv_cash,adv_consignor FROM returnbidding_entry WHERE $crit"

									$res = mysqli_query($connection, $sel);
									while ($row = mysqli_fetch_array($res)) {

										$truck_no = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row[truckid]'");
										//echo $doc_expiry_date = date("d-m-Y", strtotime(date("Y-m-d", strtotime($row['expiry'])) . "-5 day"));
										$currentdate;
										$freightamt = $row['comp_rate'] * $row['totalweight'];
                                       $adv_consignor=  $row['adv_consignor'];
                                       $totalexp=$adv_consignor + $row['adv_cash'];
										$netamt = $freightamt - $adv_consignor;
										// 	  if ($doc_expiry_date <= $currentdate) { 
									?>
										<tr>
											<td><?php echo $slno++; ?></td>
											<td><?php echo ucfirst($row['lr_no']); ?></td>
											<td><?php echo ucfirst($row['bilty_no']); ?></td>
											<td><?php echo  $row['tokendate']; ?></td>
											<td><?php echo  $row['entry_type']; ?></td>
											<td><?php echo  $freightamt; ?></td>
											<td><?php echo  $totalexp; ?></td>
											<td><?php echo  $netamt; ?></td>



										</tr>

									<?php
									$netGrandAmount += $netamt;
									}
									
									$slno++;



									?>

								   
</tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="7" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netGrandAmount),2); ?></th>
                                            </tr>
                                        </tfoot>

								</thead>
							</table>


						</div>
					</div>
				</div>



				<div class="col-sm-6">
					<div class="box box-color  box-bordered">
						<div>
						<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>

								Truck Expenses :
							</h3>

						</div>
						</div>
						<div class="box-content" style="height:300px; overflow:scroll;padding:0">

							<table class="fixTableHead table table-hovertable-nomargin dataTable dataTable-tools table-bordered" style="width:100%;white-space: nowrap">

								<thead>
									<th>S.no.</th>
									<th>Particular</th>
									<th>Date </th>
									<th>Amount</th>


								</thead>
								<tbody>
									<?php
									$slno = 1;

									$sel = "SELECT headid,service_date,amount FROM service_entry WHERE $crit1 
			UNION SELECT headid,maint_date,amount FROM maintenance_entry WHERE $crit2";


									$res = mysqli_query($connection, $sel);
									while ($row = mysqli_fetch_array($res)) {

										$truck_no = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row[truckid]'");
										$maintenance = $cmn->getvalfield($connection, "head_master", "headname", "headid='$row[headid]'");

										//echo $doc_expiry_date = date("d-m-Y", strtotime(date("Y-m-d", strtotime($row['expiry'])) . "-5 day"));

										// 	  if ($doc_expiry_date <= $currentdate) { 
									?>
										<tr>
											<td><?php echo $slno++; ?></td>
											<td><?php echo ucfirst($maintenance); ?></td>
											<td><?php echo ucfirst($row['service_date']); ?></td>
											<td><?php echo  $row['amount']; ?></td>



										</tr>

									<?php
											$netkharidiAmount += $row['amount'];
									}
							

									$slno++;



									?>
   
   </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="3" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netkharidiAmount),2); ?></th>
                                            </tr>
                                        </tfoot>

								</thead>
							</table>


						</div>
					</div>
				</div>

			</div>



		</div>
	</div>



	</div>
	<div class="container-fluid">

		<?php $enddateexpalert = date('Y-m-d', strtotime('+1 months')); ?>
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-color  box-bordered">
					<div>
					<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>

							Employee Payment:
						</h3>

					</div>
					</div>
					<div class="box-content" style="height:300px; overflow:scroll;padding:0">

						<table class="fixTableHead table table-hovertable-nomargin dataTable dataTable-tools table-bordered" style="width:100%;white-space: nowrap">

							<!-- <table class="fixTableHead table table-hover table-nomargin" style="width:100%;white-space: nowrap"> -->

							<thead>
								<th>S.no.</th>
								<th>Payment Date</th>
								<th>Driver Name</th>

								<th>Payment Type</th>
								<th>Pay Amount</th>



							</thead>
							<tbody>
								<?php
								$slno = 1;
								// echo "	SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type FROM bidding_entry WHERE $crit 
								// UNION SELECT lr_no,bilty_no,tokendate,freightamt,adv_cash,adv_consignor,entry_type FROM returnbidding_entry WHERE $crit";

								$sel = "SELECT * FROM emp_payment WHERE $crit3";

								$res = mysqli_query($connection, $sel);
								while ($row = mysqli_fetch_array($res)) {
									$empname = $cmn->getvalfield($connection, "m_employee", "empname", "empid='$row[empid]' ");
									$amount=$row['amount'];

								?>
									<tr>
										<td><?php echo $slno++; ?></td>
										<td><?php echo $row['pay_date']; ?></td>
										<td><?php echo ucfirst($empname); ?></td>

										<td><?php echo  $row['payment_type']; ?></td>
										<td><?php echo  $row['amount']; ?></td>



									</tr>

								<?php
								    $netexpenses_amt += $row['amount'];
								}
   

								$slno++;

								?>

						   
</tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="4" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netexpenses_amt),2); ?></th>
                                            </tr>
                                        </tfoot>


							</thead>
						</table>


					</div>
				</div>
			</div>



			<div class="col-sm-6">
				<div class="box box-color  box-bordered">
					<div>
					<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
							Payment:
						</h3>

					</div>
					</div>
					<div class="box-content" style="height:300px; overflow:scroll;padding:0">

						<table class="fixTableHead table table-hovertable-nomargin dataTable dataTable-tools table-bordered" style="width:100%;white-space: nowrap">

							<!-- <table class="fixTableHead table table-hover table-nomargin" style="width:100%;white-space: nowrap"> -->
							<thead>
								<th>S.no.</th>
								<th>Type </th>

								<th>Lr No. </th>
								<th>Bill No. </th>
								<th>Bill Date</th>
								<th>Amount</th>


							</thead>
							<tbody>
								<?php
								$slno = 1;
								$sel = "SELECT * FROM returnbill where $crit4";
								$res = mysqli_query($connection, $sel);
								while ($row = mysqli_fetch_array($res)) {
									$billno = $row['billno'];
									$billid = $row['billid'];

									$sel1 = "SELECT * FROM returnbill_details where billid='$billid'";
									$res1 = mysqli_query($connection, $sel1);
									while ($row1 = mysqli_fetch_array($res1)) {
										$ulamt = $row1['ulamt'];
										$bid_id = $row1['bid_id'];

										$sel2 = "SELECT * FROM returnbidding_entry where bid_id='$bid_id' $crit5 ";
										$res2 = mysqli_query($connection, $sel2);
										while ($row2 = mysqli_fetch_array($res2)) {
											$adv_consignor = $row2['adv_consignor'];

											$truck_no = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row2[truckid]'");
											$currentdate;
											$freightamt = $row['comp_rate'] * $row['totalweight'];
											$lr_no = $row2['lr_no'];
											$cgst_percent = $row['cgst_percent'];
											$sgst_percent = $row['sgst_percent'];
											$netamt = $freightamt - $row2['adv_cash'];
											$totalweight   = $row2['totalweight'];
											$entry_type   = $row2['entry_type'];
											$recweight = $row2['recweight'];
											$rate = $row2['comp_rate'];
											if ($totalweight <= $recweight)
												$total = ($rate * $recweight);
											else
												$total =  ($rate * $recweight);

											if ($totalweight <= $recweight) {
												$qty = $totalweight;
												$shortagetype = '';
											} else {
												$qty = $totalweight;
												$shortagetype = $row['shortagetype'];
											}

											$cgstamt = $cgst_percent *  $total / 100;
											$sgstamt = $sgst_percent *  $total / 100;
											$net =     $total + $cgstamt + $sgstamt + $ulamt - $adv_consignor;
								?>
											<tr>
												<td><?php echo $slno++; ?></td>
												<td><?php echo  $entry_type; ?></td>


												<td><?php echo $lr_no; ?></td>
												<td><?php echo $row['billno']; ?></td>
												<td><?php echo  $row['billdate']; ?></td>
												<td><?php echo  $net; ?></td>



											</tr>

									<?php
									$netamt1+=$net;
										}

									}
								}
						
								$slno++;

								$sel3 = "SELECT * FROM bidding_entry where  $crit6 ";
								$res3 = mysqli_query($connection, $sel3);
								while ($row3 = mysqli_fetch_array($res3)) {
									$adv_consignor = $row2['adv_consignor'];
									$payment_vochar = $cmn->getvalfield($connection, "bulk_payment_vochar", "payment_vochar", "bid_id='$row3[bid_id]'");

									$newrate = $row3['newrate'];
									$recweight = $row3['recweight'];
									$commission = $row3['commission'];
									$adv_diesel = $row3['adv_diesel'];
									$adv_cash = $row3['adv_cash'];
									$adv_other =  $row3['adv_other'];
									$adv_consignor =  $row3['adv_consignor'];
									$adv_cheque = $row3['adv_cheque'];
									$sortamount = $row3['sortamount'];
									$entry_type   = $row3['entry_type'];

									$tot_adv = $adv_cash  + $adv_cheque + $adv_other + $adv_consignor;
									$netamount = $newrate * $recweight;
									$tds_amount = $netamount * $row3['tds_amt'] / 100;
									
									$total_paid = $netamount - $commission - $adv_diesel - $tot_adv - $tds_amount - $sortamount;
									?>
									<tr>
										<td><?php echo $slno++; ?></td>
										<td><?php echo  $entry_type; ?></td>


										<td><?php echo $row3['lr_no']; ?></td>
										<td><?php echo $payment_vochar; ?></td>
										<td><?php echo  $row3['payment_date']; ?></td>
										<td><?php echo  $total_paid; ?></td>



									</tr>

								<?php
											
							$netamt  +=	$total_paid;
                                $grandtotal=$netamt1+$netamt;
								}
					
								$slno++;



								?>



   
</tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="5" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netamt1+$netamt),2); ?></th>
                                            </tr>
                                        </tfoot>



							</thead>
						</table>


					
				                  </div></div>
                 
                                             
			</div>
			   <table class="table" width="99%" border="1"   style="font-size:16px; margin-right: 50px; margin-left: 10px;" >
                        	<tr bgcolor="#CCCCCC">
                            	
                            	<td align="right"><strong>Balance Amt : <i class="fa fa-inr"></i> <?php echo number_format(round($balamt),2); ?></strong></td>
                            </tr>
                           
                        </table>
		</div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>

	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-38620714-4']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>

	<script>
		(function blink() {
			$('#blink_me').fadeOut(500).fadeIn(500, blink);
		})();
		function myFunction() {
			setInterval(function() {

				$.ajax({
					type: 'POST',
					url: 'getdashboardnotification.php',
					data: '1=1',
					dataType: 'html',
					success: function(data) {
						// alert(data);

						document.getElementById('div11').innerHTML = data;

					}
				}); //ajax close		   

			}, 30000);
		}


		var sn = 1;

		function blink_text() {
			// $('.blink').fadeOut(500);
			// $('.blink').fadeIn(500);
			if (sn % 2 == 0) {
				$('.blink').css({
					"color": "red"
				}, 500);
			} else {
				$('.blink').css({
					"color": "black"
				}, 500);
			}


			sn = sn + 1;
		}

		setInterval(blink_text, 500);
	</script>
</body>

</html>
<?php
mysqli_close($connection);
?>