<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = 'returnbill';
$tblpkey = 'billid';
$pagename  = 'return_entry_emami.php';
$modulename = "Bill Generation";
//print_r($_SESSION);
$billno = $cmn->getcode($connection, "returnbill", "billno", "1=1 and sessionid = $_SESSION[sessionid] && compid='$compid'");
//if($billno !='') { $billno = $billno + 1; }
$grossamt = 0;
$istaxable = 1;
$billdate = '';
$net = 0;
$netamt = 0;
if (isset($_GET['consignorid1'])) {
	$consignorid = addslashes(trim($_GET['consignorid1']));
	//die;
} else
	$consignorid  = '';

if (isset($_GET['consigneeid'])) {
	$consigneeid = addslashes(trim($_GET['consigneeid']));
	//die;
} else
	$consigneeid  = '';

if (isset($_GET['consi_type'])) {
	$consi_type = addslashes(trim($_GET['consi_type']));
	//die;
} else
	$consi_type  = '';


if (isset($_GET['edit'])) {
	$billid = addslashes(trim($_GET['edit']));
	$sql_eidt = mysqli_query($connection, "Select * from returnbill where billid = '$billid'");
	if ($sql_eidt === FALSE) {
		die(mysqli_error()); // TODO: better error handling
	}
	$row_edit = mysqli_fetch_assoc($sql_eidt);
	$consignorid = $row_edit['consignorid']; //die;
	$consigneeid = $row_edit['consigneeid'];
	$billno = $row_edit['billno'];
	$billdate = $cmn->dateformatindia($row_edit['billdate']);
	$taxable_percent = $row_edit['taxable_percent'];
	$serv_tax_percent = $row_edit['serv_tax_percent'];
	$ecess_percent = $row_edit['ecess_percent'];
	$hcess_percent = $row_edit['hcess_percent'];
	$safai_percent = $row_edit['safai_percent'];
	$krishi_cess = $row_edit['krishi_cess'];
	$grossamt = 0;
	$ispaid = $row_edit['ispaid'];
	$istaxable = $row_edit['istaxable'];
	$cgst_percent = $row_edit['cgst_percent'];
	$sgst_percent = $row_edit['sgst_percent'];
} else {
	$billid = 0;
	$ispaid = 0;
	$billdate = date('d-m-Y');
	$sql_t = mysqli_query($connection, "select * from tax_settings");
	$row_t = mysqli_fetch_assoc($sql_t);
	$taxable_percent = $row_t['taxable_percent'];
	$serv_tax_percent  = $row_t['serv_tax_percent'];
	$ecess_percent = $row_t['ecess_percent'];
	$hcess_percent  = $row_t['hcess_percent'];
	$safai_percent = $row_t['safai_percent'];
	$krishi_cess =  $row_t['krishi_cess'];
	$cgst_percent = '';
	$sgst_percent =  '';
}

?>
<!doctype html>
<html>

<head>
	<?php include("../include/top_files.php"); ?>
	<style>
		.form-actions {
			text-align: center;
		}

		#save {
			background: #2c9e2e;
			font-weight: 100;
			font-size: 16px;
			border: 1px solid #2c9e2e;
		}

		#clear {
			background: #8a6d3b;
			font-weight: 100;
			font-size: 16px;
			border: 1px solid #8a6d3b;
			margin-left: 15px;
		}

		.alert-success {
			color: #31708f;
			background-color: #d9edf7;
			border-color: #bce8f1;
		}

		.innerdiv {
			float: left;
			width: 390px;
			margin-left: 8px;
			padding: 6px;
			height: 25px;
			/*border:1px solid #333;*/
		}

		.innerdiv>div {
			float: left;
			margin: 5px;
			width: 140px;
		}

		.text {
			margin: 5px 0 0 8px;

		}

		.col-sm-2 {
			width: 100%;
			height: 43px;
		}

		.navbar-nav {
			position: relative;
			width: 100%;
			background: #368ee0;
			color: #FFF;
			height: 35px;
		}

		.navbar-nav>li {
			font-size: 14px;
			color: #FFF;
			padding-left: 10px;
			padding-top: 7px;
			width: 105px;
		}

		.btn.btn-primary {
			width: 80px;

		}

		.formcent {
			margin-top: 6px;
			border: 1px solid #368ee0;
		}

		.text1 {
			margin: 5px 0 0 8px;
		}
	</style>
</head>

<body data-layout-topbar="fixed">
	<?php include("../include/top_menu.php"); ?>
	<div class="container-fluid nav-hidden" id="content">

		<div class="container-fluid">
			<?php include("../include/showbutton.php"); ?>
			<div class="row-fluid" id="new">
				<div class="row">

					<form method="get" action="">

						<fieldset style="margin-top:30px; margin-left:45px;">

							<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; GST Bill Generation</legend>

							<table width="60%" border="0">
								<tr>
									<td style="width: 30%;"><label><strong>Type</strong> <span class="err" style="color:#F00;">*</span></label></td>
									<?php if ($consi_type == 'Consignor') { ?> <td id="d1"><label><strong>Consignor</strong> <span class="err" style="color:#F00;">*</span></label></td><?php } ?>
									<?php if ($consi_type == 'Consignee') { ?> <td id="d3"><label><strong>Consignee</strong> <span class="err" style="color:#F00;">*</span></label></td><?php } ?>
								</tr>
								<tr>
									<td style="width: 30%;">
										<select name="consi_type" id="consi_type" onChange="getType(this.value);" class="select2-me input-medium" style="width:250px;" required>
											<option value=""></option>
											<option value="Consignor">Consignor</option>
											<option value="Consignee">Consignee</option>
										</select>
										<script>
											document.getElementById("consi_type").value = '<?php echo $consi_type; ?>';
										</script>
									</td>

									<?php if ($consi_type == 'Consignor') { ?>

										<td id="d2" style="width: 30%;">
											<select name="consignorid1" id="consignorid1" class="select2-me input-medium" style="width:250px;">
												<option value=""></option>
												<?php
												$sql = mysqli_query($connection, "Select * from  returnbidding_entry where is_invoice='0' and bill_type='Consignor' ");
												
												
												while ($row = mysqli_fetch_assoc($sql)) {
												    
												    	 $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'  ");
												?>
													<option value="<?php echo $row['consignorid']; ?>"><?php echo $consignorname; ?></option>
												<?php
												} ?>
											</select>
											<script>
												document.getElementById("consignorid1").value = '<?php echo $consignorid; ?>';
											</script>


										</td>
									<?php } ?>

									<?php if ($consi_type == 'Consignee') { ?>
										<td id="d4" style="width: 30%;">
											<select name="consigneeid" id="consigneeid" class="select2-me input-medium" style="width:250px;">
												<option value=""></option>
												<?php
												$sql = mysqli_query($connection, "Select * from  returnbidding_entry where is_invoice='0' and bill_type='Consignee'");
												while ($row = mysqli_fetch_assoc($sql)) {
												    
												     $consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$row[consigneeid]'  ");
												?>
													<option value="<?php echo $row['consigneeid']; ?>"><?php echo $consigneename; ?></option>
												<?php
												} ?>
											</select>
											<script>
												document.getElementById("consigneeid").value = '<?php echo $consigneeid; ?>';
											</script>

										</td>
									<?php } ?>
				</div>
				<td style="width: 10%;"><input type="submit" name="sub" class="btn btn-success" id="" value="Search"></td>
				<td>
					<a href="<?php echo $pagename; ?>" class="btn btn-danger" style="border-radius:4px !important;">Cancel</a>
				</td>
				</tr>
				</table>

				</fieldset>
				</form>
			</div> <!--com sm 12 ends here -->
			<?php
			if ($consignorid != "" || $consignorid != '0') {
			?>
				<div class="row-fluid">
					<div class="span12">
						<form action="save_gstbilling_emami_return.php" method="post">
							<div class="box box-bordered">
								<div class="box-content nopadding" style="border-top: 2px solid #ddd;">
									<table align="center" class="table table-condensed table-bordered" style="width:100%">
										<tr>
											<td align="center" style="display:none;"><strong>Apply Taxes</strong></td>
											<td align="center"><strong>Bill No.</strong></td>
											<td align="center"><strong>Bill Date</strong></td>
											<td align="center"><strong>Total Amount</strong></td>
												<td align="center"><strong>Bill Type</strong></td>
												
												 <td id="gst1" <?php
                                                                                if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>>GST Type</td>
											<!--<td align="center"><strong>GST Type</strong></td>-->
										<?php if ($gstvalid == 'Yes') { ?> 	 <td  id="gst3" <?php
                                                                                if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>>CGST Percent</td>
											<?php } ?>
											<!--<?php if ($gstvalid == 'Yes') { ?> <td align="center"><strong>CGST Percent</strong></td><?php } ?>-->
											
													<!--<?php if ($gstvalid == 'Yes') { ?> <td align="center"><strong>SGST Percent</strong></td><?php } ?>-->
											<?php if ($gstvalid == 'Yes') { ?><td  id="gst4" <?php
                                                                                if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>> <strong>SGST Percent</strong></td><?php } ?>
                                                                                
                                                                                <?php if ($gstvalid == 'Yes') { ?><td  id="gst7" <?php
                                                                                if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>> <strong>SGST Percent</strong></td><?php } ?>
										</tr>
										<tr>
											<td align="center" style="display:none;">
												<select name="istaxable" id="istaxable" class="input-mini" onChange="setTotal();">
													<option value="1">Yes</option>
													<option value="0">No</option>
												</select>
												<script>
													document.getElementById('istaxable').value = '<?php echo $istaxable; ?>';
												</script>
											</td>
											<td align="center"><input type="text" class="input-medium" name="billno" id="billno" value="<?php echo $billno; ?>"></td>
											<td align="center"><input type="text" class="input-medium" name="billdate" id="billdate" value="<?php echo $billdate; ?>"></td>
											<td align="center"><input type="text" class="input-medium" name="net" id="net" value="<?php echo $net; ?>" readonly></td>
											  <td>
                                 <select data-placeholder="Choose Payment Type..." name="bill_type" id="bill_type" class="formcent select2-me" tabindex="4" style="width:100px;" onChange="showAmt();gstType();" required>
                                       <option value="">Select</option>
                                       <option value="Invoice">Invoice</option>
                                       <option value="challan">challan</option>

                                    </select>
                                    <script>
                                       document.getElementById('bill_type').value ='<?php echo $bill_type; ?>';
                                    </script>
                                 
                                 </td>
											<?php if ($gstvalid == 'Yes') { ?>

											 <td id="gst2" <?php
                                                                    if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>>
												    <select name="gst_type" id="gst_type" onChange="gstType();" class="select2-me input-medium" style="width:250px;" >
														<option value=""></option>
														<option value="CSGST">CGST-SGST</option>
														<option value="IGST">IGST</option>
													</select>
													<script>
														document.getElementById("gst_type").value = '<?php echo $gst_type; ?>';
													</script>
												</td>

											 <td id="gst5" <?php
                                                                    if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>><input type="text" class="input-small" name="cgst_percent" style="color:#f00; font-weight:bold;text-align:center;" id="cgst_percent"  value="<?php echo $cgst_percent;  ?>" onChange="setTotal();"><strong>%</strong></td>

											 <td id="gst6" <?php
                                                                    if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>><input type="text" class="input-small" name="sgst_percent" style="color:#f00; font-weight:bold;text-align:center;" id="sgst_percent" value="<?php echo $sgst_percent; ?>" onChange="setTotal();"><strong>%</strong></td>
                                                                    
                                                                     <td id="gst8" <?php
                                                                    if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>><input type="text" class="input-small" name="igst" style="color:#f00; font-weight:bold;text-align:center;" id="igst"  value="" onChange="setTotal();"><strong>%</strong></td>
											<?php } else { ?>
												<td align="center" style="display:none"><input type="text" class="input-small" name="cgst_percent" style="color:#f00; font-weight:bold;text-align:center;" id="cgst_percent" value="0" onChange="setTotal();"><strong>%</strong></td>
												<td align="center" style="display:none"><input type="text" class="input-small" name="sgst_percent" style="color:#f00; font-weight:bold;text-align:center;" id="sgst_percent" value="0" onChange="setTotal();"><strong>%</strong></td>
											<?php } ?>

										</tr>
									</table>
									<br>
									<table align="center" width="100%">
										<tr bgcolor="#CCCCCC" style="border:#333 solid 1px">
											<td><strong class="red">Add LR No.</strong></td>
											<td>
												<select name="bid_id" id="bid_id" class="select2-me input-medium" onChange="checkreturnbidding_entry(this.value);">
													<option value=""></option>
													<?php
													if ($consi_type == 'Consignee') {
														$sql = mysqli_query($connection, "Select bid_id,lr_no,tokendate from returnbidding_entry where is_invoice='0' && consigneeid='$consigneeid' && compid='$compid' && sessionid =$sessionid  order by bid_id desc");
													} else {
													   // echo "Select bid_id,lr_no,tokendate from returnbidding_entry where is_invoice='0' && consignorid='$consignorid' && compid='$compid'  && sessionid =$sessionid   order by bid_id desc";
														$sql = mysqli_query($connection, "Select bid_id,lr_no,tokendate from returnbidding_entry where is_invoice='0' && consignorid='$consignorid' && compid='$compid'  && sessionid =$sessionid   order by bid_id desc");
													}
													while ($row = mysqli_fetch_assoc($sql)) {
													?>
														<option value="<?php echo $row['bid_id']; ?>"><?php echo $row['lr_no']; ?></option>
													<?php
													} ?>
												</select>
												<script>
													document.getElementById("bid_id").value = '<?php echo $bid_id; ?>';
												</script>
											</td>

											<td width="55%">&nbsp;</td>
										<td>
                                <input type="button" name="removereturnbidding_entry" id="removereturnbidding_entry" class="btn btn-danger" value="Remove Selected" onClick="funremovereturnbidding_entry();" >
											</td>
											<input type="hidden" id="removelist" value="">
											<input type="hidden" id="addlist" name="addlist" value="">
											</td>
											<td align="right" width="12%">
												<input type="text" name="searchreturnbidding_entry" id="searchreturnbidding_entry" class="input-medium" value="" placeholder="Search Billty No.">
											</td>
										</tr>
									</table>
									<table border="1" width="100%" align="center" id="returnbidding_entrylist">
										<thead>
											<tr style="background-color:#6CC">
												<th width="3%">Del</th>
												<!--<th width="3%">Sno</th>-->
												<th width="7%">Date.</th>
												<th width="8%">LR No.</th>
												<th width="8%">Owner Name.</th>
												<th width="11%">Bilty No. </th>
												<!--<th>PUR ORDER No.</th>-->
												<th width="12%">Vehicle</th>
												<th width="13%">Destination</th>
												<th width="9%">Des. Wt.</th>
												<th width="8%">Rec. Wt.</th>
												<th width="7%">U/L Amt</th>
												<th width="6%">Rate</th>
												<th width="8%">Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if ($billid != 0) {
												$slno = 1;

												$sel = "select * from  returnbill_details left join returnbidding_entry on returnbidding_entry.bid_id = returnbill_details.bid_id  where returnbidding_entry.invoiceid = '$billid' && returnbidding_entry.compid='$compid' ";
												$res = mysqli_query($connection, $sel);
												$cnt = mysqli_num_rows($res);
												if ($cnt == 0) { ?>
													<tr>
														<td colspan="9" align="center"><strong>No Record Found...</strong></td>
													</tr>
													<?php
												} else {
													$returnbidding_entrylist = "";
													$grossamt = 0;
													while ($row = mysqli_fetch_array($res)) {
														$ownerid = $cmn->getvalfield($connection, "m_truck", "ownerid", "truckid = '$row[truckid]'");
														$ownername = $cmn->getvalfield($connection, "m_truckowner", "ownername", "ownerid = '$ownerid'");
														$returnbidding_entrylist .=  $row['bid_id'] . ",";
														$destinationid = $row['destinationid'];
														$tokendate = $row['tokendate'];
														$rate = $row['own_rate'];
														$ulamt = $row['ulamt'];
														$pur_no = "";
														$grossamt += (($rate * $row['totalweight']) + $ulamt);
													?>
														<tr class="data-content" data-val="<?php echo ucfirst($row['bilty_no']); ?>">
															<td> 
															
						<!-- <a onClick="funDelotp('<?php echo $row['bid_id'];?>');"><img src="../img/del.png" title="Delete"></a>
										   <input type="button" class="btn btn-danger" name="add_d ata_list" style="display: none;" id="add_data_delete_<?php echo  $row['bid_id'] ; ?>" onClick="funDel1('<?php echo $row['bid_id']; ?>');" value="X">	
															 -->
<a onClick="funDelotp1('<?php echo $row['billdetailid']; ?>');"><img src="../img/del.png" title="Delete"></a>
<input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_deleteS1_<?php echo  $row['billdetailid']; ?>"  onClick="funDel1(<?php echo $row['billdetailid']; ?>,<?php echo $row['bid_id']; ?>);" value="X"></td>
															
															<td align="center"><input type='checkbox' id='chk<?php echo $row['bid_id']; ?>' value='1' onclick='addids(<?php echo $row['bid_id']; ?>);'></td>
															
															<td><strong><?php echo $cmn->dateformatindia($row['tokendate']); ?></strong></td>
															<td><?php echo $row['lr_no']; ?></td>
															<td><?php echo $ownername; ?></td>
															<td><?php echo $row['bilty_no']; ?></td>
															<td><strong><?php echo ucfirst($cmn->getvalfield($connection, "m_truck", "truckno", "truckid = '$row[truckid]'")); ?></strong></td>
															<td><strong>
																	<?php echo ucfirst($cmn->getvalfield($connection, "m_place", "placename", "placeid = '$row[destinationid]'")); ?></strong></td>

															<td><strong><span id='destwt<?php echo $row['bid_id']; ?>'>

																		<?php echo $row['totalweight']; ?></span> </strong></td>
															<td><strong><span id='recwt<?php echo $row['bid_id']; ?>'><?php echo $row['recweight']; ?></span></strong></td>

															<td align="center"><strong>
																	<input type='text' id='ulamt<?php echo $row['bid_id']; ?>' style='width:50px;' name='ulamt[]' onchange='setAmt(this.value,<?php echo $row['bid_id']; ?>);' readonly class='input-medium ulamt' value='<?php echo $ulamt; ?>'></strong></td>

															<td align="center"><strong>
																	<input type='text' id='rate<?php echo $row['bid_id']; ?>' style="width:50px" name='rate[]' onchange='setAmt(this.value,<?php echo $row['bid_id']; ?>);' class='input-medium rate' value='<?php echo $rate; ?>'></strong></td>

															<td align="right"><strong><span class="amt_basant" id='amt<?php echo $row['bid_id']; ?>'>

																		<?php if ($row['totalweight'] > $row['recweight']) echo (($rate * $row['totalweight']) + $ulamt);
																		else echo (($rate * $row['totalweight']) + $ulamt); ?></span></strong></td>
														</tr>
											<?php
														$slno++;
													}
													if ($istaxable == '1') {
														$taxableamt = ($taxable_percent * $grossamt) / 100;
														$servtaxamt = ($serv_tax_percent * $grossamt) / 100;
														$netamt = $grossamt + $servtaxamt + $taxableamt;
													} else {
														$taxableamt = 0;
														$servtaxamt = 0;
														$netamt = $grossamt;
													}
												}
											}
											$returnbidding_entrylist = rtrim($returnbidding_entrylist, ",");
											?>

											<script>
												document.getElementById('addlist').value = '<?php echo $returnbidding_entrylist; ?>';
											</script>

										</tbody>

									</table>

									<table border="1" width="100%" style="background-color:#007CB9; color:#fff" align="center">
										<tr>
											<td width="92%" align="right">
												<strong>GROSS AMT :</strong>
											</td>
											<td align="right"><strong><span id="grossamt" style="color:#FFF"><?php echo round($grossamt, 2); ?></span></strong>&nbsp;&nbsp;
											</td>
										</tr>
										<tr style="display:none;">
											<td align="right">
												<strong>CGST AMT :</strong>
											</td>
											<td width="9%" align="right"><strong><span id="taxableamt" style="color:#FFF"><?php echo round($cgst_percent, 2); ?></span></strong>&nbsp;&nbsp;</td>
										</tr>
										<tr style="display:none;">
											<td align="right">
												<strong>SGST AMT :</strong>
											</td>
											<td width="9%" align="right"><strong><span id="servtaxamt" style="color:#FFF"><?php echo round($sgst_percent, 2); ?></span></strong>&nbsp;&nbsp;</td>
										</tr>
										<tr>
										<tr style="background-color:rgb(228, 84, 84);">
											<td align="right">
												<strong>Net AMT :</strong>
											</td>
											<td align="right">
												<strong><span id="netamt" style="color:#FFF"><?php echo number_format(round($netamt), 2); ?></span></strong>&nbsp;&nbsp;
											</td>
										</tr>
									</table>
									<script>
										$("#net").val('<?php echo number_format(round($netamt), 2); ?>');
									</script>
									<br>
									<center>
									<?php if ($ispaid == '0') { ?>
										<table style="text-align:center;">
										
											<tr>
												<td><input type="submit" name="save" class="btn btn-success" id="" value="Save" onClick="return checkinputs();"></td>
												<td>
													<a href="return_entry_emami.php" class="btn btn-danger" style="border-radius:4px !important;">Cancel</a>
												</td>
											</tr>
											
										</table>
									<?php
									}
									?>
									</center>
									<input type="hidden" name="billid" id="billid" value="<?php echo $billid; ?>">
									<input type="hidden" name="consignorid" id="consignorid" value="<?php echo $consignorid; ?>">
									<input type="hidden" name="consigneeid" id="consigneeid" value="<?php echo $consigneeid; ?>">
									<input type="hidden" name="consi_type" id="consi_type" value="<?php echo $consi_type; ?>">
									<br /><br />
								</div>

							</div>
						</form>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		<div class="row-fluid" id="list">
			<div class="span12">



				<div class="box box-bordered">

					<div class="box-title">
						<h3><i class="icon-edit"></i>Billing Report</h3>
					</div>


					<div class="box-title">
						<h3><i class="icon-table"></i><?php echo $modulename; ?> Details&nbsp;<span class="red">( Only 100 records are shown below for more <a href="return_billing_report.php?consignorid=<?php echo $consignorid; ?>" target="_blank">Click Here</a>)</span></h3>

					</div>
					<div class="box-content nopadding">
						<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
							<thead>
								<tr>
							
									<th width="4%">Sno</th>
									<th width="10%">Date</th>
									<th width="10%">Bill No</th>
									<th width="10%">Type</th>
									<th width="15%">Consignor Name</th>
									<th width="15%">Consignee Name</th>
									<th width="10%">Session</th>
									<th width="10%">Bill Amount</th>

									<th width="25%" class='hidden-480'>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$slno = 1;
// echo "select * from returnbill where billdate > '2017-06-30' && sessionid='$_SESSION[sessionid]' && compid='$compid' order by billid desc limit 0,100";
								$sel = "select * from returnbill where billdate > '2017-06-30' && sessionid='$_SESSION[sessionid]' && compid='$compid' order by billid desc limit 0,100";
								$res = mysqli_query($connection, $sel);
								while ($row = mysqli_fetch_array($res)) {

									if ($row['ispaid'] == '0')
										$status = "<span class='red'><strong>Unpaid</strong></span>";
									else

										$status = "<span style='color: green;'><strong>Paid</strong></span>";
									$billamount = $cmn->get_total_billing_amt1($connection, $row['billid']);
									$consignorname = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid='$row[consignorid]'");
									$consigneename =  $cmn->getvalfield($connection, "m_consignee", "consigneename", "consigneeid='$row[consigneeid]'");

								?>
									<tr tabindex="<?php echo $slno; ?>" class="abc">
									
										<td><?php echo $slno; ?></td>
										<td><?php echo $cmn->dateformatindia(ucfirst($row['billdate'])); ?></td>
										<td><?php echo ucfirst($row['billno']); ?></td>
										<td><?php echo ucfirst($row['consi_type']); ?></td>
										<td><?php echo $consignorname; ?></td>
										<td><?php echo $consigneename; ?></td>

										<td><?php echo $cmn->getvalfield($connection, "m_session", "session_name", "sessionid='$_SESSION[sessionid]'"); ?></td>
										<td><?php echo number_format($billamount, 2); ?></td>



										<td class='hidden-480'>
											<a href="?edit=<?php echo $row['billid']; ?>&consi_type=<?php echo $row['consi_type']; ?>"><img src="../img/b_edit.png" title="Edit"></a>
											&nbsp;&nbsp;&nbsp;
											<?php
											if ($row['ispaid'] == '0') {
											?>
												<a onClick="funDelotp('<?php echo $row['billid']; ?>');"><img src="../img/del.png" title="Delete"></a>
												<input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_delete_<?php echo  $row['billid']; ?>" onClick="funDel('<?php echo $row['billid']; ?>');" value="X">
											<?php
											} ?>
											&nbsp;&nbsp;&nbsp;
											<?php if ($gstvalid == "Yes") { ?>
												<a href="pdf_nogstprint_gst_billing_demo_emamireturn.php?p=<?php echo ucfirst($row['billid']); ?>&consi_type=<?php echo $row['consi_type']; ?>&bill_type=<?php echo  $row['bill_type']; ?>" class="btn btn-info" target="_blank">PDF</a>
											<?php } else { ?>
												<a href="pdf_nogstprint_gst_billing_demo_emamireturn.php?p=<?php echo ucfirst($row['billid']); ?>" class="btn btn-info" target="_blank">PDF</a>
											<?php } ?>
										</td>


									</tr>
								<?php
									$slno++;
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div><!-- class="container-fluid nav-hidden" ends here  -->

	<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
		<div class="modal-header">
			<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
			<h3 id="myModalLabel">OTP Check</h3>
		</div>
		<div class="modal-body">
			<center><span id="getotp"></span></center>
			<h4>Enter 4 Digit Code</h4>
			<p>
			<table>
				<tr>
					<td> <input type="text" id="otp" class="form-control" value="" autocomplete="off"> </td>
					<td> <input type="button" class="btn btn-primary" onClick="checkotp();" value="Check"> </td>
				</tr>
				<input type="hidden" id="ref_id" value="">
			</table>
			</p>
		</div>
		<div class="modal-footer">
			<button data-dismiss="modal" class="btn">Close</button>
		</div>
	</div><!--#myModal-->
	<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModallll">
		<div class="modal-header">
			<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
			<h3 id="myModalLabel">OTP Check</h3>
		</div>
		<div class="modal-body">
			<h4>Enter 4 Digit Code</h4>
			<p>
			<table>
				<tr>
					<td> <input type="text" id="otpppp" class="form-control" value="" autocomplete="off"> </td>
					<td> <input type="button" class="btn btn-primary" onClick="checkotpppp();" value="check"> </td>
				</tr>
				<input type="hidden" id="ref_idddd" value="">
			</table>
			</p>
		</div>
		<div class="modal-footer">
			<button data-dismiss="modal" class="btn">Close</button>
		</div>
	</div><!--#myModal-->
	<script>
		function getType(data) {
			location = 'return_entry_emami.php?consi_type=' + data;
			/*	if(data=='Consignor'){
					$("#d1").show();
					$("#d2").show();
					$("#d3").hide();
					$("#d4").hide();
				}else{
					$("#d1").hide();
					$("#d2").hide();
					$("#d3").show();
					$("#d4").show();
				}*/
		}

		function setTotal() {
			istaxable = document.getElementById('istaxable').value;
			grossamt = parseFloat(document.getElementById("grossamt").innerHTML);
			if (isNaN(grossamt)) {
				grossamt = 0;
			}

			var ulamt = 0;
			$(".ulamt").each(function() {
				amt = parseFloat($(this).val());
				if (isNaN(amt)) {
					amt = 0;
				}
				ulamt = ulamt + amt;
			});

			//alert(grossamt);
			grossamt = grossamt - ulamt;

			if (istaxable == "1") {
				cgst_percent = document.getElementById("cgst_percent").value;
				sgst_percent = document.getElementById('sgst_percent').value;

				//alert(krishi_cess);
				if (cgst_percent == "")
					cgst_percent = 0;

				if (sgst_percent == "")
					sgst_percent = 0;
				if (!isNaN(cgst_percent) && !isNaN(sgst_percent)) {
					cgst_percent = (parseFloat(cgst_percent) * parseFloat(grossamt)) / 100;
					sgst_percent = (parseFloat(sgst_percent) * parseFloat(grossamt)) / 100;

					$("#taxableamt").html(cgst_percent.toFixed(2));
					$("#servtaxamt").html(sgst_percent.toFixed(2));

					netamt = parseFloat(grossamt) + parseFloat(cgst_percent) + parseFloat(sgst_percent) +
						parseFloat(ulamt);

					$("#netamt").html(Math.round(netamt).toFixed(2));
					$("#net").val(Math.round(netamt).toFixed(2));
				}
			} else {
				netamt = parseFloat(grossamt);
				$("#servtaxamt").html(0);
				$("#taxableamt").html(0);
				$("#netamt").html(Math.round(netamt).toFixed(2));
				$("#net").val(Math.round(netamt).toFixed(2));
			}
		}

		function checkinputs() {
			var x = document.getElementById("returnbidding_entrylist").rows.length;
			var net = parseFloat(document.getElementById('net').value);



			if (x == 1) {
				alert("Please add billties");
				$('#bid_id').select2('focus');
				return false;
			} else if ($("#billno").val() == "") {
				alert("Please enter bill no.");
				$("#billno").focus();
				return false;
			} else if ($("#billdate").val() == "") {
				alert("Please enter bill date");
				$("#billdate").focus();
				return false;
			} else if (net == 0) {
				alert("Bill Amount Can't Be Zero");
				//$("#billdate").focus();
				return false;
			}


		}

		function funremovereturnbidding_entry() {
			removelist = document.getElementById("removelist").value;
			addlist = document.getElementById("addlist").value;
			remarr = removelist.split(",");
			addarr = addlist.split(",");
			grossamt = parseFloat($("#grossamt").html());
			if (confirm("Are you sure! You want to remove this billties.")) {

				//alert(remarr.length);
				len = remarr.length;
				for (var i = 0; i < len; i++) {
					rem = remarr['' + i];
					//alert(rem);
					var index = addarr.indexOf(rem);
					if (index != -1) {
						addarr[index] = 0;
					}
					remamt = $("#amt" + rem).html();
					//alert(""+remamt);

					grossamt = parseFloat(grossamt) - parseFloat($("#amt" + rem).html());

				}
				$("#grossamt").html("" + parseFloat(grossamt).toFixed(2));
				strids = addarr.join();
				document.getElementById("addlist").value = strids;
				document.getElementById("removelist").value = "";
				$("#returnbidding_entrylist tr input:checked").parents('tr').remove();
				setTotal();
			}

		}

		function checkreturnbidding_entry(bid_id) {
			addlist = document.getElementById("addlist").value;
			//alert('addlist');
			addarr = addlist.split(",");
			var index = addarr.indexOf(bid_id);

			if (index != -1) {
				alert("This Bilty already added...");
				$("#bid_id").select2().select2('val', ''); //for select2 refresh to blank value
				$('#bid_id').select2('focus');
			} else {
				//alert(bid_id);
				if (bid_id != "") {
					$.ajax({
						type: 'POST',
						url: '../ajax/check_shrtge_billty_emami_return.php',
						data: 'bid_id=' + bid_id,
						dataType: 'html',
						success: function(data) {
							//alert(data);
							/*if(data == '1')
								{
									alert("Billty Not Received..");
									$("#bid_id").select2().select2('val','');//for select2 refresh to blank value
									$('#bid_id').select2('focus');
									return false;
								}					
								else */
							if (data == '5') {
								alert("Billty Date is below to  GST");
								$("#bid_id").select2().select2('val', ''); //for select2 refresh to blank value
								$('#bid_id').select2('focus');
								return false;
							} else if (data == '3') {
								if (confirm("This Billty has shortage..DO you want to add this ??")) {
									addreturnbidding_entry(bid_id);
								} else {
									$("#bid_id").select2().select2('val', ''); //for select2 refresh to blank value
									$('#bid_id').select2('focus');
								}
							} else {
								addreturnbidding_entry(bid_id);
							}
						}

					}); //ajax close		
				}
			}

		}

		function addreturnbidding_entry(bid_id) {
			if (bid_id != "") {
				grossamt = parseFloat($("#grossamt").html());
				$.ajax({
					type: 'POST',
					url: '../ajax/add_bill_emami_return.php',
					data: 'bid_id=' + bid_id,
					dataType: 'html',
					success: function(data) {
						//alert(data);
						if (data != "") {
							var x = document.getElementById("returnbidding_entrylist").rows.length;
							arr = data.split("|");
							var table = document.getElementById("returnbidding_entrylist");
							var row = table.insertRow(-1);
							row.className = "data-content";
							row.setAttribute("data-val", "" + arr[1]);
							var cell1 = row.insertCell(0);
							var cell2 = row.insertCell(1);
							var cell3 = row.insertCell(2);
							var cell4 = row.insertCell(3);
							var cell5 = row.insertCell(4);
							//var cell6 = row.insertCell(5);
							var cell7 = row.insertCell(5);
							var cell8 = row.insertCell(6);
							var cell9 = row.insertCell(7);
							var cell10 = row.insertCell(8);
							var cell11 = row.insertCell(9);
							var cell12 = row.insertCell(10);
							var cell13 = row.insertCell(11);
							cell1.innerHTML = "<input type='checkbox' id='chk" + bid_id + "' value='1' onclick='addids(" + bid_id + ");'>";
							cell1.style.textAlign = "center";
							cell2.innerHTML = arr[0];
							cell2.style.fontWeight = "bold";
							cell3.innerHTML = arr[11];
							cell3.style.fontWeight = "bold";
							cell4.innerHTML = arr[14];
							cell4.style.fontWeight = "bold";
							cell5.innerHTML = arr[13];
							cell5.style.fontWeight = "bold";
							//cell6.innerHTML =  "<input type='text' id='pur_no"+bid_id+"' name='pur_no"+bid_id+"' class='input-medium'  value='"+arr[10]+"'>";
							//cell6.style.fontWeight ="bold";
							cell7.innerHTML = arr[4];
							cell7.style.fontWeight = "bold";
							cell8.innerHTML = arr[5];
							cell8.style.fontWeight = "bold";
							cell9.innerHTML = "<span id ='destwt" + bid_id + "'>" + arr[6] + "</span>";
							cell9.style.fontWeight = "bold";
							cell10.innerHTML = "<span id ='recwt" + bid_id + "'>" + arr[7] + "</span>";
							cell10.style.fontWeight = "bold";
							cell11.innerHTML = "<input type='text' id='ulamt" + bid_id + "' name='ulamt[]' class='input-medium ulamt'  value='' onchange = 'setAmt(this.value," + bid_id + ");' >";
							cell11.style.fontWeight = "bold";
							cell11.style.textAlign = "center";
							$('#ulamt' + bid_id).width("50px");
							cell12.innerHTML = "<input type='text' id='rate" + bid_id + "' name='rate[]' class='input-medium rate'  value='" + parseFloat(arr[8]) + "'				onchange = 'setAmt(this.value," + bid_id + ");' >";
							cell12.style.fontWeight = "bold";
							cell12.style.textAlign = "center";
							$('#rate' + bid_id).width("50px");
							amt = parseFloat(arr[9]).toFixed(2); //300;//
							cell13.innerHTML = "<span class='amt_basant' id ='amt" + bid_id + "'>" + amt + "</span>";
							cell13.style.fontWeight = "bold";
							cell13.style.textAlign = "right";

							list_old = $("#addlist").val();
							if (list_old == "")
								list_old = list_old + bid_id;
							else
								list_old = list_old + "," + bid_id;
							$("#addlist").val(list_old);

							grossamt = parseFloat(grossamt) + parseFloat(amt);
							$("#grossamt").html(grossamt.toFixed(2));
							$("#bid_id").select2().select2("val", "");
							$('#bid_id').select2('focus');
							setTotal();
						}

					}

				}); //ajax close
			}

		}

		function setAmt(amt, bid_id) {
			var ulamt = parseFloat($("#ulamt" + bid_id).val());
			var rate = parseFloat($("#rate" + bid_id).val());
			var recwt = parseFloat($("#recwt" + bid_id).html());

			if (isNaN(ulamt)) {
				ulamt = 0;
			}
			if (isNaN(rate)) {
				rate = 0;
			}
			if (isNaN(recwt)) {
				recwt = 0;
			}

			amt = (rate * recwt) + ulamt;
			$("#amt" + bid_id).html(amt.toFixed(2));

			var grsamt = 0;
			$(".amt_basant").each(function() {
				amt = parseFloat($(this).html());
				if (isNaN(amt)) {
					amt = 0;
				}
				grsamt = grsamt + amt;
			});


			//grossamt =  parseFloat($("#grossamt").html());
			$("#grossamt").html(grsamt.toFixed(2));
			setTotal();
		}

		function addids(bid_id) {
			strids = document.getElementById("removelist").value;
			if (document.getElementById("chk" + bid_id).checked == true) {
				if (strids == "")
					strids = strids + bid_id;
				else
					strids = strids + "," + bid_id;
			} else {
				arr = strids.split(",");
				var index = arr.indexOf('' + bid_id);

				if (index !== -1) {
					arr[index] = 0;
				}
				strids = arr.join();
				//alert(strids);
			}
			// alert(strids);
			document.getElementById("removelist").value = strids;
		}

		function save_receive(bid_id) {
			recievedwt = $("#recievedwt" + bid_id).val();
			recievedate = $("#recievedate" + bid_id).val();
			shortage = $("#shortage" + bid_id).val();
			if (bid_id != "") {
				$.ajax({
					type: 'POST',
					url: '../ajax/save_received.php',
					data: 'bid_id=' + bid_id + '&recievedwt=' + recievedwt + '&recievedate=' + recievedate + '&shortage=' + shortage,
					dataType: 'html',
					success: function(data) {
						if (data == '0') {
							$("#recievedwt" + bid_id).val("");
							$("#recievedate" + bid_id).val("");
							$("#shortage" + bid_id).val("");
						}
					}

				}); //ajax close
			}
		}

		function funDel1(billdetailid,bid_id) {
			// alert(bid_id); 
		   
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			//alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: '../ajax/deleteinvoice1.php',
					data: 'bid_id=' + bid_id + '&billdetailid=' + billdetailid + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
						// alert(data);
						//   alert(data);
						// alert('Data Deleted Successfully');edit=693&consi_type=Consignee
						location = pagename + '?edit=<?php echo $_GET['edit'];?>&consi_type=<?php echo $_GET['consi_type'];?>';
					}

				}); //ajax close
			} //confirm close
		} //fun close
		
	</script>
	<script>
		$("#searchreturnbidding_entry").keyup(function() {
			searchterm = $("#searchreturnbidding_entry").val().toLowerCase();
			$(".data-content").each(function() {
				value = $(this).attr("data-val").toLowerCase();
				if (value.indexOf(searchterm) == 0)
					$(this).show();
				else
					$(this).hide();

			});
		});
		//below code for date mask
		jQuery(function($) {
			$("#billdate").mask("99-99-9999", {
				placeholder: "dd-mm-yyyy"
			});
		});
		setTotal();
		function updategatepassno(bid_id) {
			var gatepassno = document.getElementById('gatepassno' + bid_id).value;

			$.ajax({
				type: 'POST',
				url: 'updategatepassno.php',
				data: 'bid_id=' + bid_id + '&gatepassno=' + gatepassno,
				dataType: 'html',
				success: function(data) {

				}

			}); //ajax close
		}

		function checkotpppp() {

			var otp = document.getElementById('otpppp').value;
			var ref_id = document.getElementById('ref_idddd').value;
			if (otp != '') {


				jQuery.ajax({
					type: 'POST',
					url: 'checkotp_billing_entry_delete.php',
					data: 'ref_id=' + ref_id + '&otp=' + otp,
					dataType: 'html',
					success: function(data) {
					//	alert(data);
						if (data == 1) {
							//location = "other_expense.php?expenseid="+ref_id;
							//alert("ok");
							jQuery("#myModallll").modal('hide');
							jQuery("#add_data_deleteS1_" + ref_id).click();
						} else
							alert("Wrong OTP");
					}
				}); //ajax close

			}
		}

		function funDelotp1(billdetailid) {
			// alert(billdetailid);
			if (billdetailid != '') {

				jQuery.ajax({
					type: 'POST',
					url: 'getotp_billing_entry_delete.php',
					data: 'billdetailid=' + billdetailid,
					dataType: 'html',
					success: function(data) {
						// alert(data);
						jQuery("#ref_idddd").val(billdetailid);
						jQuery("#myModallll").modal('show');
					}
				}); //ajax close
			}
		}


function gstType() {

				var gst_type = document.getElementById('gst_type').value;
		var bill_type = document.getElementById('bill_type').value;
		
		if(bill_type=="Invoice"){
		if(gst_type=="CSGST")
		{     jQuery('#gst5').show();
      jQuery('#gst6').show();
   //  jQuery('#grand_total1').show();
 
    jQuery('#gst3').show();
        jQuery('#gst4').show();
        
        
            jQuery('#gst7').hide();
		       jQuery('#gst8').hide();
		    
		    	jQuery("#cgst_percent").val(6);
		    		jQuery("#sgst_percent").val(6);
		    		setTotal();
		 
		} 
			if(gst_type=="IGST")
		{
		      jQuery('#gst7').show();
		       jQuery('#gst8').show();
		        jQuery('#gst5').hide();
      jQuery('#gst6').hide();
   //  jQuery('#grand_total1').hide();
  
      jQuery('#gst3').hide();
        jQuery('#gst4').hide();
		    	jQuery("#igst").val(12);
		    	
		    		setTotal();
		 
		} 	if(gst_type=="") {
		jQuery("#cgst_percent").val(0);
		
		    		jQuery("#sgst_percent").val(0);
			jQuery("#igst").val(0);
		
		    		setTotal();
		}
		}
		
		if(bill_type=="challan"){
		 
		    	jQuery("#cgst_percent").val(0);
		
		    		jQuery("#sgst_percent").val(0);
		    		setTotal();
		}
		
		}
		
		
		
		function funDelotp(billid) {
			// alert(billid);
			if (billid != '') {

				jQuery.ajax({
					type: 'POST',
					url: 'getotp_billing_entry_delete.php',
					data: 'billid=' + billid,
					dataType: 'html',
					success: function(data) {
						// alert(data);
						jQuery("#ref_id").val(billid);
						jQuery("#myModal").modal('show');
					}
				}); //ajax close
			}
		}


		
		function checkotp() {

var otp = document.getElementById('otp').value;
var ref_id = document.getElementById('ref_id').value;
if (otp != '') {


	jQuery.ajax({
		type: 'POST',
		url: 'checkotp_billing_entry_delete.php',
		data: 'ref_id=' + ref_id + '&otp=' + otp,
		dataType: 'html',
		success: function(data) {
			// alert(data);
			if (data == 1) {
				//location = "other_expense.php?expenseid="+ref_id;
				//alert("ok");
				jQuery("#myModal").modal('hide');
				jQuery("#add_data_delete_" + ref_id).click();
			} else
				alert("Wrong OTP");
		}
	}); //ajax close

}
}




function funDel(billid) {
			// alert(billid);   
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			//alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: '../ajax/removedeleteinvoice_return.php',
					data: 'billid=' + billid + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
						  // alert(data);
						// alert('Data Deleted Successfully');
						location = pagename + '?action=10';
					}

				}); //ajax close
			} //confirm close
		} //fun close
		
		
		  function showAmt() {

var bill_type = document.getElementById('bill_type').value;

if (bill_type == 'Invoice') {
//alert(bill_type);
   //  jQuery('#grand_total2').show();
    jQuery('#gst2').show();
  
   //  jQuery('#grand_total1').show();
    jQuery('#gst1').show();



} else {

   //  jQuery('#grand_total2').hide();
    jQuery('#gst2').hide();

   //  jQuery('#grand_total1').hide();
    jQuery('#gst1').hide();
    

}
}
	</script>

</body>

</html>